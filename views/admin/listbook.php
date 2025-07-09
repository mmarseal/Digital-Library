<?php
include "koneksi.php";
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Buku</li>
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
                        <a href="admin.php?p=addbook" class="btn btn-primary">Tambah Data Buku</a>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>ISBN</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dml = "SELECT * FROM book ORDER BY book_title ASC";
                                $qry = mysqli_query($conn, $dml);
                                $no = 1;

                                while ($row = mysqli_fetch_assoc($qry)) {
                                    $id = $row['book_id'];
                                ?>
                                    <tr>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= htmlspecialchars($row['book_title']); ?></td>
                                        <td><?= htmlspecialchars($row['author']); ?></td>
                                        <td><?= htmlspecialchars($row['publisher_name']); ?></td>
                                        <td><?= htmlspecialchars($row['isbn']); ?></td>
                                        <td><?= htmlspecialchars($row['book_copies']); ?></td>
                                        <td><?= $row['status'] == '1' ? "Tersedia" : "Tidak Tersedia"; ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="admin.php?p=editbook&id=<?= $id; ?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                <a href="action/book_delete.php?id=<?= $id; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus buku ini?')"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
