<?php
session_start();

include "koneksi.php";

if (isset($_POST['submit'])) {

    $user = $_POST['user'];
    $pass = $_POST['password'];

    if (empty($user) || empty($pass)) {
        header("Location: login.php?error=empty");
        exit();
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $data_user = mysqli_fetch_assoc($result);

            
            if (password_verify($pass, $data_user['password'])) {
                // --- Login Berhasil ---

                session_regenerate_id(true);

                $_SESSION['user_id'] = $data_user['user_id'];
                $_SESSION['sesi'] = $data_user['username']; 

                header("Location: admin.php"); 
                exit();

            } else {
                header("Location: login.php?error=wrongpassword");
                exit();
            }
        } else {
            header("Location: login.php?error=nouser");
            exit();
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);

} else {
    // Jika file diakses langsung tanpa submit, kembalikan ke halaman login
    header("Location: login.php");
    exit();
}
?>