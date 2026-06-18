    <?php
    session_start();

    require_once "../config/database.php";

    $id_query = mysqli_query(
    $koneksi,
    "SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA='db_arsip_samsat'
    AND TABLE_NAME='user'"
);

$id_data = mysqli_fetch_assoc($id_query);

$id_otomatis = "U-" . str_pad(
    $id_data['AUTO_INCREMENT'],
    4,
    '0',
    STR_PAD_LEFT
);

    if(!isset($_SESSION['id_user']))
    {
        header("Location: ../login.php");
        exit;
    }

    if($_SESSION['role'] != 'admin')
{
    header("Location: dashboard.php");
    exit;
}

    ?>

    <!DOCTYPE html>

    <html>

    <head>

    <title>Tambah User</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css?v=10">

    </head>

    <body>

    <div class="container">

    <div class="sidebar">

        <div class="logo">
            SAMSAT BATU AJI
        </div>

        <div class="menu">

            <a href="dashboard.php">
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

            <?php if($_SESSION['role'] == 'admin') { ?>

                <a class="active" href="user.php">
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
                    <?php echo $_SESSION['nama']; ?>
                </span>

            </div>

        </div>

        <div class="content">

        <h2 class="form-title">
    Tambah User
</h2>

<form method="POST">

<div class="form-grid">

    <div class="form-card">

        <label>ID User</label>

        <input
        type="text"
        value="U-<?php echo str_pad($id_data['AUTO_INCREMENT'],4,'0',STR_PAD_LEFT); ?>"
        readonly>

    </div>

    <div class="form-card">

        <label>Nama</label>

        <input
        type="text"
        name="nama"
        required>

    </div>

    <div class="form-card">

    <label>Username</label>

    <input
    type="text"
    name="username"
    required>

</div>

<div class="form-card">

    <label>Password</label>

    <input
    type="text"
    name="password"
    required>

</div>

</div>

<div class="button-group">

    <a
    href="user.php"
    class="btn-back">

        Kembali

    </a>

    <button
    type="submit"
    name="simpan"
    class="btn-save">

        Simpan

    </button>

</div>

</form>

        </div>

    </div>

    </div>

    </body>
    </html>

    <?php

if(isset($_POST['simpan']))
{
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query(
    $koneksi,
    "INSERT INTO user
    (
        nama,
        username,
        password,
        role
    )
    VALUES
    (
        '$nama',
        '$username',
        '$password',
        'user'
    )"
);

    echo "
    <script>

        alert('User berhasil ditambahkan');

        window.location='user.php';

    </script>
    ";
}

?>