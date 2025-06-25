<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Transaksi Peminjaman</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item active">Data Transaksi</li>
                </ol>
            </div>
        </div>
    </div></section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="admin.php?p=addtransaksi" class="btn btn-primary">Tambah Transaksi Baru</a>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No.</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tgl. Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th class="text-center">Jml. Buku</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "koneksi.php";

                                $sql = "
                                    SELECT 
                                        b.borrow_id, b.date_borrow, b.due_date, b.status AS transaction_status,
                                        m.firstname, m.lastname,
                                        COUNT(bd.book_id) AS total_books
                                    FROM borrow AS b
                                    LEFT JOIN member AS m ON b.member_id = m.member_id
                                    LEFT JOIN borrowdetails AS bd ON b.borrow_id = bd.borrow_id
                                    GROUP BY b.borrow_id
                                    ORDER BY b.date_borrow DESC
                                ";

                                $query = mysqli_query($db, $sql);

                                if ($query && mysqli_num_rows($query) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['date_borrow'])); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['due_date'])); ?></td>
                                            <td class="text-center"><span class="badge badge-info"><?php echo $row['total_books']; ?></span></td>
                                            <td class="text-center">
                                                <?php
                                                    // ==========================================================
                                                    // INILAH PERBAIKANNYA: Logika status disesuaikan
                                                    // 0 = Dipinjam, 1 = Selesai
                                                    // ==========================================================
                                                    if ($row['transaction_status'] == 0) {
                                                        echo '<span class="badge badge-warning">Dipinjam</span>';
                                                    } else {
                                                        echo '<span class="badge badge-success">Selesai</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="admin.php?p=detailtransaksi&id=<?php echo $row['borrow_id']; ?>" class="btn btn-primary" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <?php 
                                                    // Tombol "Kembali" hanya muncul jika status masih "Dipinjam"
                                                    if ($row['transaction_status'] == 0): 
                                                    ?>
                                                        <a href="action/return_transaction.php?id=<?php echo $row['borrow_id']; ?>" class="btn btn-success" title="Proses Pengembalian" onclick="return confirm('Proses pengembalian untuk transaksi ini?')">
                                                            <i class="fas fa-undo-alt"></i> Kembali
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center">Belum ada data transaksi.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>