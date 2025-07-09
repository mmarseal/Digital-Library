<?php
include '../koneksi.php';

$member_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($member_id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM member WHERE member_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $member_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../admin.php?p=listmember");
    exit();
} else {
    echo "Parameter ID tidak valid bro!";
}
?>
