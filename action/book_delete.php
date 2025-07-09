<?php
include '../koneksi.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($book_id > 0) {
    $sql = "DELETE FROM book WHERE book_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ../admin.php?p=listbook&status=delete_success");
    } else {
        header("Location: ../admin.php?p=listbook&status=delete_failed_not_found");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

die("Error: ID buku tidak ditemukan.");
