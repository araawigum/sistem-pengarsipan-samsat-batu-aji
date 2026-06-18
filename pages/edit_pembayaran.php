<?php
session_start();

require_once "../config/database.php";

if(!isset($_GET['id']))
{
    header("Location: pembayaran.php");
    exit;
}

$id = $_GET['id'];

$data_pembayaran = mysqli_query(
    $koneksi,
    "SELECT *
    FROM pembayaran
    WHERE id_pembayaran='$id'"
);

$data = mysqli_fetch_assoc($data_pembayaran);

$kendaraan = mysqli_query(
    $koneksi,
    "SELECT
        kendaraan.*,
        wajib_pajak.nama

    FROM kendaraan

    LEFT JOIN wajib_pajak
    ON kendaraan.id_wajib_pajak = wajib_pajak.id_wajib_pajak

    ORDER BY kendaraan.no_polisi ASC"
);

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Pembayaran</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link
href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
rel="stylesheet">

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

<a class="active" href="pembayaran.php">
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
                Edit Data Pembayaran
            </h2>

           <form method="POST">

    <div class="form-grid">

   <div class="form-card">

    <label>ID Pembayaran</label>

   <input
type="text"
value="P-<?php echo str_pad($data['id_pembayaran'],4,'0',STR_PAD_LEFT); ?>"
readonly>

</div>

<div class="form-card">

    <label>Jenis</label>

    <select
    name="jenis_pembayaran"
    required>

        <option value="">
            Pilih Jenis
        </option>

        <option
value="QRIS"
<?php if($data['jenis_pembayaran']=='QRIS') echo 'selected'; ?>>
    QRIS
</option>

<option
value="Transfer"
<?php if($data['jenis_pembayaran']=='Transfer') echo 'selected'; ?>>
    Transfer
</option>

<option
value="Tunai"
<?php if($data['jenis_pembayaran']=='Tunai') echo 'selected'; ?>>
    Tunai
</option>

    </select>

</div>

        <div class="form-card">

    <label>Tanggal</label>

    <input
type="date"
name="tanggal_bayar"
value="<?php echo $data['tanggal_bayar']; ?>"
required>

</div>

        <div class="form-card">

    <label>Total</label>

   <input
type="number"
name="total_bayar"
min="0"
value="<?php echo $data['total_bayar']; ?>"
required>

</div>

       <div class="form-card">

    <label>ID Kendaraan</label>

    <select
id="id_kendaraan"
name="id_kendaraan"
required>

        <option value="">
            Pilih Kendaraan
        </option>

        <?php
        while($row = mysqli_fetch_assoc($kendaraan))
        {
        ?>

       <option
value="<?php echo $row['id_kendaraan']; ?>"
<?php
if($row['id_kendaraan'] == $data['id_kendaraan'])
{
    echo "selected";
}
?>>

    K-<?php echo str_pad($row['id_kendaraan'],4,'0',STR_PAD_LEFT); ?>
    -
    <?php echo $row['no_polisi']; ?>
    -
    <?php echo $row['nama']; ?>

</option>

        <?php
        }
        ?>

    </select>

</div>

       <div class="form-card">

    <label>Status</label>

    <select
    name="status_pembayaran"
    required>

        <option value="">
            Pilih Status
        </option>

        <option
value="Lunas"
<?php if($data['status_pembayaran']=='Lunas') echo 'selected'; ?>>
    Lunas
</option>

<option
value="Menunggak"
<?php if($data['status_pembayaran']=='Menunggak') echo 'selected'; ?>>
    Menunggak
</option>

    </select>

</div>

</div> <!-- form-grid -->

<div class="button-group">

    <a
    href="hapus_pembayaran.php?id=<?php echo $id; ?>"
    class="btn-delete"
    onclick="return confirm('Hapus data pembayaran ini?')">

        Hapus

    </a>

    <a
    href="pembayaran.php"
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

    $('#id_kendaraan').select2({
        placeholder: 'Cari Kendaraan',
        width: '100%'
    });

});

</script>

</body>

</html>

<?php

if(isset($_POST['simpan']))
{
    $id_kendaraan = $_POST['id_kendaraan'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $total_bayar = $_POST['total_bayar'];
    $status_pembayaran = $_POST['status_pembayaran'];

    mysqli_query(
    $koneksi,
    "UPDATE pembayaran
    SET
        id_kendaraan='$id_kendaraan',
        tanggal_bayar='$tanggal_bayar',
        jenis_pembayaran='$jenis_pembayaran',
        total_bayar='$total_bayar',
        status_pembayaran='$status_pembayaran'
    WHERE id_pembayaran='$id'"
);

    echo "

    <script>

        alert('Data pembayaran berhasil diperbarui');

        window.location='pembayaran.php';

    </script>

    ";
}
?>