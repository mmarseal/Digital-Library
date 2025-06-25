<?php
    session_start();
    if(isset($_SESSION['sesi'])){
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>.:Sistem Perpustakaan:.</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
   <body>
		<div id="container">
            <div id="header">
                <div id="nama-alamat-perpustakaan-container">
                    <div class="nama-alamat-perpustakaan">
                        <h1> PERPUSTAKAAN UMUM </h1>
                    </div>
                    <div class="nama-alamat-perpustakaan">
                        <h4> Jl. Lembah Abang No 11, Telp: (021)55555555 </h4>
                    </div>
                </div>
            </div>
            <div id="header2">
                <div id="nama-user">Hai, Saya admin loh!</div>
            </div>

            <div id="sidebar">
                <a href="index.php?p=beranda">Beranda</a>
                <p class="label-navigasi">Data Master</p>
                <ul>
                    <li><a href="index.php?p=listmember">Data Anggota</a></li>
                    <li><a href="index.php?p=listbook">Data Buku</a></li>                  
                </ul>
                <p class="label-navigasi">Data Transaksi</p>
                <ul>
                    <li><a href="index.php?p=listborrow">Data Peminjaman</a></li>
                    <li><a href="index.php?p=listbook"></a></li>                  
                </ul>
                <a href="logout.php">Logout</a>
            </div>

            <div id="content-container">
             <!--konten nanti taruh disini ya-->
            <?php 
                $p_dir = 'views';
                if(!empty($_GET['p'])){
                    $pages = scandir($p_dir,0);
                    unset($pages[0], $pages[1]);
                    $view = $_GET['p'];
                    if(in_array($view.'.php', $pages)){
                        include($p_dir.'/'.$view.'.php');
                    }else{
                        echo 'filenya gak ada bro';
                    }
                }else{
                    include($p_dir.'/beranda.php');
                }
            ?>
            </div>

            <div id="footer">
                <h3>Sistem Informasi Perpustakaan (SIPUS)|Praktikum</h3>
            </div>
        </div>

	</body>
</html>
<?php
    }else{
        echo "<script>alert('Login Dulu mAs Bro!');</script>";
        header('location:login.php');
        
    }
?>