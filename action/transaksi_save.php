<?php
include '../koneksi.php';

if (!isset($_POST['submit'])) {
    header("Location: ../admin.php");
    exit();
}

$member_id = $_POST['member_id'] ?? null;
$book_ids = $_POST['book_ids'] ?? [];
$date_borrow = $_POST['date_borrow'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$status = 0; // 0 = belum kembali

if (empty($member_id) || empty($book_ids)) {
    header("Location: ../admin.php?p=addtransaksi&status=error_input");
    exit();
}

// Validasi format tanggal (YYYY-MM-DD)
$date_regex = "/^\d{4}-\d{2}-\d{2}$/";
if (!preg_match($date_regex, $date_borrow) || !preg_match($date_regex, $due_date)) {
    header("Location: ../admin.php?p=addtransaksi&status=invalid_date");
    exit();
}

mysqli_begin_transaction($conn);

try {
    // Step 1: Simpan data ke tabel 'borrow'
    $sql_borrow = "INSERT INTO borrow (member_id, date_borrow, due_date, status) VALUES (?, ?, ?, ?)";
    $stmt_borrow = mysqli_prepare($conn, $sql_borrow);
    mysqli_stmt_bind_param($stmt_borrow, "issi", $member_id, $date_borrow, $due_date, $status);
    mysqli_stmt_execute($stmt_borrow);
    $borrow_id = mysqli_insert_id($conn);

    // Step 2: Simpan ke tabel 'borrowdetails'
    $sql_details = "INSERT INTO borrowdetails (borrow_id, book_id, borrow_status) VALUES (?, ?, ?)";
    $stmt_details = mysqli_prepare($conn, $sql_details);
    mysqli_stmt_bind_param($stmt_details, "iii", $borrow_id, $book_id, $borrow_status);

    // Step 3: Update status buku jadi tidak tersedia (status = 0)
    $sql_update_book = "UPDATE book SET status = 0 WHERE book_id = ?";
    $stmt_update_book = mysqli_prepare($conn, $sql_update_book);
    mysqli_stmt_bind_param($stmt_update_book, "i", $book_id);

    foreach ($book_ids as $book_id) {
        $borrow_status = 0; // 0 = dipinjam

        // Simpan ke borrowdetails
        mysqli_stmt_execute($stmt_details);

        // Update status buku
        mysqli_stmt_execute($stmt_update_book);
    }

    mysqli_commit($conn);
    header("Location: ../admin.php?p=listtransaksi&status=add_success");
    exit();

} catch (mysqli_sql_exception $e) {
    mysqli_rollback($conn);
    error_log("DB Error: " . $e->getMessage());
    header("Location: ../admin.php?p=addtransaksi&status=db_error");
    exit();
}

