<?php
// Sertakan koneksi dan validasi dasar
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<section class='content'><div class='container-fluid'><div class='alert alert-danger'>ID Transaksi tidak valid.</div></div></section>";
    exit;
}

$borrow_id = $_GET['id'];

// --- Query 1: Ambil data transaksi utama dan data peminjam ---
$sql_transaction = "
    SELECT 
        b.borrow_id, b.date_borrow, b.due_date, b.status AS transaction_status,
        m.firstname, m.lastname, m.email, m.contact
    FROM borrow AS b
    JOIN member AS m ON b.member_id = m.member_id
    WHERE b.borrow_id = ?
";
$stmt_transaction = mysqli_prepare($db, $sql_transaction);
mysqli_stmt_bind_param($stmt_transaction, "i", $borrow_id);
mysqli_stmt_execute($stmt_transaction);
$result_transaction = mysqli_stmt_get_result($stmt_transaction);
$transaction_data = mysqli_fetch_assoc($result_transaction);

if (!$transaction_data) {
    echo "<section class='content'><div class='container-fluid'><div class='alert alert-danger'>Transaksi tidak ditemukan.</div></div></section>";
    exit;
}

// --- Query 2: Ambil daftar buku yang dipinjam, SERTAKAN borrow_details_id ---
$sql_books = "
    SELECT 
        bd.borrow_details_id, -- ID ini penting untuk update per buku
        bk.book_title, bk.author,
        bd.borrow_status, bd.date_return
    FROM borrowdetails AS bd
    JOIN book AS bk ON bd.book_id = bk.book_id
    WHERE bd.borrow_id = ?
";
$stmt_books = mysqli_prepare($db, $sql_books);
mysqli_stmt_bind_param($stmt_books, "i", $borrow_id);
mysqli_stmt_execute($stmt_books);
$result_books = mysqli_stmt_get_result($stmt_books);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Detail Transaksi</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin.php?p=listtransaksi">Data Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header"><h3 class="card-title">Informasi Transaksi</h3></div>
                    <div class="card-body">
                        <strong><i class="fas fa-book-reader mr-1"></i> ID Transaksi</strong>
                        <p class="text-muted"><?php echo htmlspecialchars($transaction_data['borrow_id']); ?></p><hr>
                        <strong><i class="far fa-calendar-alt mr-1"></i> Tanggal Pinjam</strong>
                        <p class="text-muted"><?php echo date('d F Y', strtotime($transaction_data['date_borrow'])); ?></p><hr>
                        <strong><i class="far fa-calendar-check mr-1"></i> Jatuh Tempo</strong>
                        <p class="text-muted"><?php echo date('d F Y', strtotime($transaction_data['due_date'])); ?></p><hr>
                        <strong><i class="fas fa-info-circle mr-1"></i> Status Transaksi</strong>
                        <p class="text-muted">
                            <?php
                                // Menggunakan logika status baru: 0 = Dipinjam
                                if ($transaction_data['transaction_status'] == 0) {
                                    echo '<span class="badge badge-warning">Dipinjam</span>';
                                } else {
                                    echo '<span class="badge badge-success">Selesai</span>';
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header"><h3 class="card-title">Informasi Peminjam</h3></div>
                    <div class="card-body">
                        <strong><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                        <p class="text-muted"><?php echo htmlspecialchars($transaction_data['firstname'] . ' ' . $transaction_data['lastname']); ?></p><hr>
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted"><?php echo htmlspecialchars($transaction_data['email']); ?></p><hr>
                        <strong><i class="fas fa-phone-alt mr-1"></i> Kontak</strong>
                        <p class="text-muted"><?php echo htmlspecialchars($transaction_data['contact']); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-header"><h3 class="card-title">Daftar Buku yang Dipinjam</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Judul Buku</th>
                                    <th class="text-center">Status</th>
                                    <th>Dikembalikan Tgl</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_books && mysqli_num_rows($result_books) > 0) {
                                    $no = 1;
                                    while ($book = mysqli_fetch_assoc($result_books)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo htmlspecialchars($book['book_title']); ?></td>
                                    <td class="text-center">
                                        <?php
                                            // Menggunakan logika status baru: 0 = Dipinjam
                                            if ($book['borrow_status'] == 0) {
                                                echo '<span class="badge badge-warning">Dipinjam</span>';
                                            } else {
                                                echo '<span class="badge badge-success">Kembali</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $book['date_return'] ? date('d F Y', strtotime($book['date_return'])) : '-'; ?></td>
                                    <td class="text-center">
                                        <?php
                                        // Tombol "Kembalikan" hanya muncul jika status buku masih 'Dipinjam' (0)
                                        if ($book['borrow_status'] == 0) {
                                        ?>
                                            <a href="action/return_book.php?detail_id=<?php echo $book['borrow_details_id']; ?>&borrow_id=<?php echo $borrow_id; ?>" class="btn btn-success btn-sm" onclick="return confirm('Anda yakin ingin mengembalikan buku ini?')">
                                                <i class="fas fa-undo-alt"></i> Kembalikan
                                            </a>
                                        <?php
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php } } else { echo '<tr><td colspan="5" class="text-center">Tidak ada detail buku.</td></tr>'; } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="admin.php?p=listtransaksi" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>