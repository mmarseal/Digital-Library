<?php
include "koneksi.php";

$years_query = mysqli_query($conn, "SELECT DISTINCT copyright_year FROM book WHERE copyright_year IS NOT NULL ORDER BY copyright_year DESC");

$selected_year = isset($_GET['year']) ? $_GET['year'] : '';

$sql = "SELECT book_id, book_title, author, publisher_name, isbn, copyright_year, book_copies FROM book";
if (!empty($selected_year)) {
    $sql .= " WHERE copyright_year = ?";
}
$sql .= " ORDER BY book_title ASC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($selected_year)) {
    mysqli_stmt_bind_param($stmt, "s", $selected_year);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Laporan Data Buku</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Buku</li>
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
                    <input type="hidden" name="p" value="report_book">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun Terbit</label>
                                <select name="year" class="form-control">
                                    <option value="">-- Semua Tahun --</option>
                                    <?php while ($year_row = mysqli_fetch_assoc($years_query)): ?>
                                        <?php $year = htmlspecialchars($year_row['copyright_year']); ?>
                                        <option value="<?= $year ?>" <?= $year == $selected_year ? 'selected' : '' ?>>
                                            <?= $year ?>
                                        </option>
                                    <?php endwhile; ?>
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
            <div class="card-header">
                <h3 class="card-title">
                    Hasil Laporan Buku <?= !empty($selected_year) ? "Tahun " . htmlspecialchars($selected_year) : "- Semua Tahun"; ?>
                </h3>
            </div>
            <div class="card-body">
                <table id="reportTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                                    <td><?= htmlspecialchars($row['author']) ?></td>
                                    <td><?= htmlspecialchars($row['publisher_name']) ?></td>
                                    <td><?= htmlspecialchars($row['copyright_year']) ?></td>
                                    <td><?= htmlspecialchars($row['book_copies']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if ($('#reportTable').length) {
        $("#reportTable").DataTable({
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            responsive: true,
            lengthChange: true,
            autoWidth: false
        }).buttons().container().appendTo('#reportTable_wrapper .col-md-6:eq(0)');
    }
});
</script>
