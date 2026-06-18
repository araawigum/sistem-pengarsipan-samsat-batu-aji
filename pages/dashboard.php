<?php
session_start();

require_once "../config/database.php";

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}

$total_wp = mysqli_num_rows(
    mysqli_query($koneksi,"SELECT * FROM wajib_pajak")
);

$total_kendaraan = mysqli_num_rows(
    mysqli_query($koneksi,"SELECT * FROM kendaraan")
);

$total_pembayaran = mysqli_num_rows(
    mysqli_query($koneksi,"SELECT * FROM pembayaran")
);

$total_arsip = mysqli_num_rows(
    mysqli_query($koneksi,"SELECT * FROM dokumen")
);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <div class="sidebar">

        <div class="logo">
            SAMSAT BATU AJI
        </div>

        <div class="menu">

            <a class="active" href="dashboard.php">
                Dashboard
            </a>

            <a href="wajib_pajak.php">
                Wajib Pajak
            </a>

            <a href="kendaraan.php">
                Kendaraan
            </a>

            <a href="pembayaran.php">
                Pembayaran
            </a>

            <a href="arsip.php">
                Arsip
            </a>

            <a href="laporan.php">
    Laporan
</a>

            <?php if($_SESSION['role'] == 'admin') { ?>

                <a href="user.php">
                    User
                </a>

            <?php } ?>

        </div>

        <div class="logout">

            <a href="../logout.php">
                Keluar
            </a>

        </div>

    </div>

    <div class="main">

        <div class="header">

            <div class="user-info">

    <span class="user-name">
        <?php echo $_SESSION['username']; ?>
    </span>

</div>

        </div>

        <div class="content">

            <div class="welcome-card">

                <h1>
                    Selamat Datang,
                    <span>
                        <?php echo $_SESSION['nama']; ?>
                    </span>
                </h1>

                <p>
                    Di Sistem Pengarsipan Data Wajib Pajak Samsat Batu Aji!
                </p>

                <p>
                    Gunakan fitur-fitur pada sistem ini untuk mengelola data,
                    arsip, laporan, dan pengaturan sistem dengan mudah dan efisien.
                </p>

            </div>

            <div class="stats">

                <div class="stat-card">

                    <div class="icon-circle blue"></div>

                    <div class="stat-content">

                        <h3>Total Wajib Pajak</h3>

                        <div class="stat-number">
                            <?php echo $total_wp; ?>
                        </div>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="icon-circle green"></div>

                    <div class="stat-content">

                        <h3>Total Kendaraan</h3>

                        <div class="stat-number">
                            <?php echo $total_kendaraan; ?>
                        </div>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="icon-circle orange"></div>

                    <div class="stat-content">

                        <h3>Total Pembayaran</h3>

                        <div class="stat-number">
                            <?php echo $total_pembayaran; ?>
                        </div>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="icon-circle purple"></div>

                    <div class="stat-content">

                        <h3>Total Arsip Dokumen</h3>

                        <div class="stat-number">
                            <?php echo $total_arsip; ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>