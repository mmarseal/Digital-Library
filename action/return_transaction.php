<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Akses tidak sah. ID Transaksi tidak ditemukan.");
}

$borrow_id = $_GET['id'];
$return_date = date('Y-m-d');

mysqli_begin_transaction($conn);

try {
    $sql_update_borrow = "UPDATE borrow SET status = 1 WHERE borrow_id = ?";
    $stmt_borrow = mysqli_prepare($conn, $sql_update_borrow);
    mysqli_stmt_bind_param($stmt_borrow, "i", $borrow_id);
    mysqli_stmt_execute($stmt_borrow);

    $sql_update_details = "UPDATE borrowdetails SET borrow_status = 1, date_return = ? WHERE borrow_id = ?";
    $stmt_details = mysqli_prepare($conn, $sql_update_details);
    mysqli_stmt_bind_param($stmt_details, "si", $return_date, $borrow_id);
    mysqli_stmt_execute($stmt_details);

    $sql_update_books = "UPDATE book SET status = 1 WHERE book_id IN (SELECT book_id FROM borrowdetails WHERE borrow_id = ?)";
    $stmt_books = mysqli_prepare($conn, $sql_update_books);
    mysqli_stmt_bind_param($stmt_books, "i", $borrow_id);
    mysqli_stmt_execute($stmt_books);

    mysqli_commit($conn);

    header("Location: ../admin.php?p=listtransaksi&status=return_success");
    exit();

} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($conn);
    header("Location: ../admin.php?p=listtransaksi&status=return_failed");
    exit();
} finally {
    mysqli_close($conn);
}
?>

