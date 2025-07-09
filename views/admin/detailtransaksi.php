<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<section class='content'><div class='container-fluid'><div class='alert alert-danger'>ID Transaksi tidak valid.</div></div></section>";
    exit;
}

$borrow_id = $_GET['id'];

// Query 1: Ambil data transaksi dan peminjam
$sql_transaction = "
    SELECT 
        b.borrow_id, b.date_borrow, b.due_date, b.status AS transaction_status,
        m.firstname, m.lastname, m.email, m.contact
    FROM borrow AS b
    JOIN member AS m ON b.member_id = m.member_id
    WHERE b.borrow_id = ?
";

if ($stmt_transaction = mysqli_prepare($conn, $sql_transaction)) {
    mysqli_stmt_bind_param($stmt_transaction, "i", $borrow_id);
    mysqli_stmt_execute($stmt_transaction);
    $result_transaction = mysqli_stmt_get_result($stmt_transaction);
    $transaction_data = mysqli_fetch_assoc($result_transaction);
    mysqli_stmt_close($stmt_transaction);
} else {
    die("Error preparing statement: " . mysqli_error($conn));
}

if (!$transaction_data) {
    echo "<section class='content'><div class='container-fluid'><div class='alert alert-danger'>Transaksi tidak ditemukan.</div></div></section>";
    exit;
}

// Query 2: Ambil daftar buku yang dipinjam
$sql_books = "
    SELECT 
        bd.borrow_details_id,
        bk.book_title, bk.author,
        bd.borrow_status, bd.date_return
    FROM borrowdetails AS bd
    JOIN book AS bk ON bd.book_id = bk.book_id
    WHERE bd.borrow_id = ?
";

if ($stmt_books = mysqli_prepare($conn, $sql_books)) {
    mysqli_stmt_bind_param($stmt_books, "i", $borrow_id);
    mysqli_stmt_execute($stmt_books);
    $result_books = mysqli_stmt_get_result($stmt_books);
    mysqli_stmt_close($stmt_books);
} else {
    die("Error preparing statement: " . mysqli_error($conn));
}
?>

<!-- HTML content (content-header & content sections) tetap sama -->

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
    <!-- ... lanjut dengan HTML sama persis seperti kode kamu ... -->
</section>
