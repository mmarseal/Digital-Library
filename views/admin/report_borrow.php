<?php
include "koneksi.php";  // pastikan di sini $conn adalah objek mysqli koneksi

$sql = "
    SELECT 
        b.date_borrow, b.status AS borrow_status,
        m.firstname, m.lastname,
        bo.book_title,
        bd.date_return
    FROM borrow AS b
    LEFT JOIN member AS m ON b.member_id = m.member_id
    LEFT JOIN borrowdetails AS bd ON b.borrow_id = bd.borrow_id
    LEFT JOIN book AS bo ON bd.book_id = bo.book_id
    ORDER BY b.date_borrow DESC
";

$query = mysqli_query($conn, $sql);  

$no = 1;
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Peminjaman Buku</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($query && mysqli_num_rows($query) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                <td><?= htmlspecialchars($row['book_title']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['date_borrow'])) ?></td>
                                <td><?= $row['date_return'] ? date('d-m-Y', strtotime($row['date_return'])) : '-' ?></td>
                                <td>
                                    <?= $row['borrow_status'] == 0
                                        ? '<span class="badge badge-warning">Dipinjam</span>'
                                        : '<span class="badge badge-success">Selesai</span>' ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Tidak ada data transaksi peminjaman.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
