<?php
// Sertakan file koneksi
include 'koneksi.php';

// Inisialisasi variabel data
$members = [];
$error = '';

// Query data anggota
$sql = "SELECT * FROM member ORDER BY firstname ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $members[] = $row;
        }
    }
    mysqli_free_result($result);
} else {
    $error = "Gagal mengambil data: " . mysqli_error($conn);
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Anggota</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Anggota</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="admin.php?p=addmember" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($error): ?>
                                    <tr><td colspan="9" class="text-center text-danger"><?= htmlspecialchars($error) ?></td></tr>
                                <?php elseif (empty($members)): ?>
                                    <tr><td colspan="9" class="text-center">Tidak ada data anggota ditemukan.</td></tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($members as $row): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?>.</td>
                                            <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= $row['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                            <td><?= htmlspecialchars($row['address']) ?></td>
                                            <td><?= htmlspecialchars($row['contact']) ?></td>
                                            <td><?= htmlspecialchars($row['type']) ?></td>
                                            <td><?= $row['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="admin.php?p=editmember&id=<?= $row['member_id'] ?>" class="btn btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="action/member_delete.php?id=<?= $row['member_id'] ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin hapus data ini?')"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
