<?php
session_start();

require_once "../config/database.php";

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}

$id_query = mysqli_query(
    $koneksi,
    "SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA='db_arsip_samsat'
    AND TABLE_NAME='kendaraan'"
);

$id_data = mysqli_fetch_assoc($id_query);

$id_otomatis = "K-" . str_pad(
    $id_data['AUTO_INCREMENT'],
    4,
    '0',
    STR_PAD_LEFT
);

$wp = mysqli_query(
    $koneksi,
    "SELECT *
    FROM wajib_pajak
    ORDER BY nama ASC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Kendaraan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link
href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
rel="stylesheet" />

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

            <a class="active" href="kendaraan.php">
                Kendaraan
            </a>

            <a href="pembayaran.php">
                Pembayaran
            </a>

            <a href="arsip.php">
                Arsip
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
                    <?php echo $_SESSION['nama']; ?>
                </span>

            </div>

        </div>

        <div class="content">

            <h2 class="form-title">
                Tambah Data Kendaraan
            </h2>

            <form method="POST">

    <div class="form-grid">

        <div class="form-card">

            <label>ID Kendaraan</label>

            <input
            type="text"
            value="<?php echo $id_otomatis; ?>"
            readonly>

        </div>

        <div class="form-card">

            <label>Tahun</label>

            <input
            type="number"
            name="tahun"
            min="1900"
            max="2099"
            required>

        </div>

        <div class="form-card">

            <label>No. Polisi</label>

           <input
type="text"
name="no_polisi"
required>

        </div>

        <div class="form-card">

            <label>ID Wajib Pajak</label>

            <select
id="id_wajib_pajak"
name="id_wajib_pajak"
required>

                <option value="">
                    Pilih Wajib Pajak
                </option>

                <?php
                while($row = mysqli_fetch_assoc($wp))
                {
                ?>

                <option
                value="<?php echo $row['id_wajib_pajak']; ?>">

                    WP-<?php echo str_pad($row['id_wajib_pajak'],4,'0',STR_PAD_LEFT); ?>
                    -
                    <?php echo $row['nama']; ?>

                </option>

                <?php
                }
                ?>

            </select>

        </div>

        <div class="form-card">

            <label>Merk</label>

            <input
type="text"
name="merk"
required>

        </div>

        <div class="form-card">

            <label>Status</label>

            <select
            name="status"
            required>

                <option value="">
                    Pilih Status
                </option>

                <option value="Aktif">
                    Aktif
                </option>

                <option value="Rusak">
                    Rusak
                </option>

                <option value="Dijual">
                    Dijual
                </option>

            </select>

        </div>

        <div class="form-card full-width">

            <label>Tipe</label>

           <input
type="text"
name="tipe"
required>

        </div>

    </div>

    <div class="button-group">

        <a
        href="kendaraan.php"
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function(){

    $('#id_wajib_pajak').select2({
        placeholder: 'Cari Wajib Pajak',
        width: '100%'
    });

});

</script>

</body>

</html>

<?php

if(isset($_POST['simpan']))
{
    $id_wajib_pajak = $_POST['id_wajib_pajak'];
    $no_polisi = $_POST['no_polisi'];
    $merk = $_POST['merk'];
    $tipe = $_POST['tipe'];
    $tahun = $_POST['tahun'];
    $status = $_POST['status'];

    mysqli_query(
        $koneksi,
        "INSERT INTO kendaraan
        (
            id_wajib_pajak,
            no_polisi,
            merk,
            tipe,
            tahun,
            status
        )
        VALUES
        (
            '$id_wajib_pajak',
            '$no_polisi',
            '$merk',
            '$tipe',
            '$tahun',
            '$status'
        )"
    );

    echo "

    <script>

        alert('Data kendaraan berhasil disimpan');

        window.location='kendaraan.php';

    </script>

    ";
}

?>