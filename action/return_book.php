<?php
include '../koneksi.php';

if (!isset($_GET['detail_id']) || !isset($_GET['borrow_id'])) {
    die("Akses tidak sah. ID tidak ditemukan.");
}

$detail_id = $_GET['detail_id'];
$borrow_id = $_GET['borrow_id'];
$return_date = date('Y-m-d'); // Tanggal pengembalian adalah hari ini

mysqli_begin_transaction($conn);

try {

    $sql_update_detail = "UPDATE borrowdetails SET borrow_status = 1, date_return = ? WHERE borrow_details_id = ?";
    $stmt_update_detail = mysqli_prepare($conn, $sql_update_detail);
    mysqli_stmt_bind_param($stmt_update_detail, "si", $return_date, $detail_id);
    mysqli_stmt_execute($stmt_update_detail);

    $sql_get_book_id = "SELECT book_id FROM borrowdetails WHERE borrow_details_id = ?";
    $stmt_get_book_id = mysqli_prepare($conn, $sql_get_book_id);
    mysqli_stmt_bind_param($stmt_get_book_id, "i", $detail_id);
    mysqli_stmt_execute($stmt_get_book_id);
    $result_book_id = mysqli_stmt_get_result($stmt_get_book_id);
    if ($row_book_id = mysqli_fetch_assoc($result_book_id)) {
        $book_id_to_update = $row_book_id['book_id'];
        
        $sql_update_book_stock = "UPDATE book SET status = 1 WHERE book_id = ?";
        $stmt_update_book_stock = mysqli_prepare($conn, $sql_update_book_stock);
        mysqli_stmt_bind_param($stmt_update_book_stock, "i", $book_id_to_update);
        mysqli_stmt_execute($stmt_update_book_stock);
    }
    
    $sql_check_all_returned = "SELECT COUNT(*) as pending_books FROM borrowdetails WHERE borrow_id = ? AND borrow_status = 0";
    $stmt_check = mysqli_prepare($conn, $sql_check_all_returned);
    mysqli_stmt_bind_param($stmt_check, "i", $borrow_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $pending_count = mysqli_fetch_assoc($result_check)['pending_books'];
    
    if ($pending_count == 0) {
        $sql_update_borrow = "UPDATE borrow SET status = 1 WHERE borrow_id = ?"; // 1 = Selesai
        $stmt_update_borrow = mysqli_prepare($conn, $sql_update_borrow);
        mysqli_stmt_bind_param($stmt_update_borrow, "i", $borrow_id);
        mysqli_stmt_execute($stmt_update_borrow);
    }
    
    mysqli_commit($conn);
    
    header("Location: ../admin.php?p=detailtransaksi&id=" . $borrow_id . "&status=return_success");
    exit();

} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($conn);
    
    header("Location: ../admin.php?p=detailtransaksi&id=" . $borrow_id . "&status=return_failed");
    exit();
}
?>