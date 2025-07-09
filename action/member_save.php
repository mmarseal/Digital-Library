<?php
include '../koneksi.php';

if (isset($_POST['submit'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname  = htmlspecialchars($_POST['lastname']);
    $gender    = htmlspecialchars($_POST['gender']);
    $alamat    = htmlspecialchars($_POST['address']);
    $phone     = htmlspecialchars($_POST['contact']);
    $tipe      = htmlspecialchars($_POST['type']);
    $email     = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $idx       = isset($_POST['id']) ? intval($_POST['id']) : null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format email tidak valid.");
    }

    if (!empty($idx)) {
        $sql = "UPDATE member SET firstname=?, lastname=?, email=?, gender=?, address=?, contact=?, type=? WHERE member_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $firstname, $lastname, $email, $gender, $alamat, $phone, $tipe, $idx);
    } else {
        $sql = "INSERT INTO member(firstname, lastname, email, gender, address, contact, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $email, $gender, $alamat, $phone, $tipe);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("location: ../admin.php?p=listmember&status=sukses");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
