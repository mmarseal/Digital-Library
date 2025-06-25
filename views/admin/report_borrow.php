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
                    <?php
                    include "koneksi.php";
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
                    $query = mysqli_query($db, $sql);
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['book_title']) . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($row['date_borrow'])) . "</td>";
                        echo "<td>" . ($row['date_return'] ? date('d-m-Y', strtotime($row['date_return'])) : '-') . "</td>";
                        echo "<td>" . ($row['borrow_status'] == 0 ? '<span class="badge badge-warning">Dipinjam</span>' : '<span class="badge badge-success">Selesai</span>') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
