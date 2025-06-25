<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Digital Library</title>
    <link rel="icon" type="image/png" href="img/mobile-library.png">

    <link rel="stylesheet" href="style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <form action="auth_register.php" method="post">
            <h2>Daftar Akun Baru</h2>

            <!-- Pesan sukses / error -->
            <?php
            if (isset($_GET['error'])) {
                $messages = [
                    'empty' => 'Semua field wajib diisi!',
                    'exists' => 'Username sudah terdaftar!',
                    'mismatch' => 'Konfirmasi password tidak cocok!',
                    'failed' => 'Gagal mendaftar. Coba lagi.'
                ];
                echo '<div class="error-message">' . htmlspecialchars($messages[$_GET['error']]) . '</div>';
            }
            ?>

            <div class="input-group">
                <input type="text" name="firstname" placeholder="Nama Depan" required>
            </div>

            <div class="input-group">
                <input type="text" name="lastname" placeholder="Nama Belakang" required>
            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm" placeholder="Ulangi Password" required>
            </div>

            <button type="submit" name="submit" class="login-btn">Daftar</button>

            <div class="register-link">
                <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
