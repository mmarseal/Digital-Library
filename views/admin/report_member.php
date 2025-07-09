<?php
include 'koneksi.php';

$selected_type = $_GET['type'] ?? '';
$selected_status = $_GET['status'] ?? '';

$sql = "SELECT member_id, firstname, lastname, email, gender, address, contact, type, status FROM member";
$conditions = [];
$params = [];
$types = '';

if (!empty($selected_type)) {
    $conditions[] = "type = ?";
    $params[] = $selected_type;
    $types .= 's';
}
if ($selected_status !== '') {
    $conditions[] = "status = ?";
    $params[] = $selected_status;
    $types .= 'i';
}

if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}
$sql .= " ORDER BY firstname ASC";

$stmt = mysqli_prepare($conn, $sql);
if ($types) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Laporan Data Anggota</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Anggota</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header"><h3 class="card-title">Filter Laporan</h3></div>
            <div class="card-body">
                <form method="GET" action="admin.php">
                    <input type="hidden" name="p" value="report_member">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipe Anggota</label>
                                <select name="type" class="form-control">
                                    <option value="">-- Semua Tipe --</option>
                                    <option value="Guru" <?= $selected_type === 'Guru' ? 'selected' : '' ?>>Guru</option>
                                    <option value="Siswa" <?= $selected_type === 'Siswa' ? 'selected' : '' ?>>Siswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Semua Status --</option>
                                    <option value="1" <?= $selected_status === '1' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= $selected_status === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Hasil Laporan Anggota</h3></div>
            <div class="card-body">
                <table id="reportMemberTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Kontak</th>
                            <th>Tipe</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= $row['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                    <td><?= htmlspecialchars($row['contact']) ?></td>
                                    <td><?= htmlspecialchars($row['type']) ?></td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 1): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">Tidak ada data untuk ditampilkan sesuai filter.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if ($('#reportMemberTable').length) {
        $("#reportMemberTable").DataTable({
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            responsive: true,
            lengthChange: true,
            autoWidth: false
        }).buttons().container().appendTo('#reportMemberTable_wrapper .col-md-6:eq(0)');
    }
  });
</script>
