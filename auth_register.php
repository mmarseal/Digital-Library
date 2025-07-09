<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validasi kosong
    if (empty($username) || empty($password) || empty($confirm)) {
        header("Location: register.php?error=empty");
        exit();
    }

    // Cek konfirmasi password
    if ($password !== $confirm) {
        header("Location: register.php?error=mismatch");
        exit();
    }

    // Cek username sudah dipakai
    $check = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        header("Location: register.php?error=exists");
        exit();
    }

    mysqli_stmt_close($check);

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke DB
    $insert = mysqli_prepare($conn, "INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert, "ssss", $firstname, $lastname, $username, $hash);



    if (mysqli_stmt_execute($insert)) {
        header("Location: login.php?success=registered");
        exit();
    } else {
        header("Location: register.php?error=failed");
        exit();
    }
}
?>

