<?php
session_start();

require_once "../config/database.php";

$id_query = mysqli_query(
    $koneksi,
    "SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA='db_arsip_samsat'
    AND TABLE_NAME='pembayaran'"
);

$id_data = mysqli_fetch_assoc($id_query);

$id_otomatis = "P-" . str_pad(
    $id_data['AUTO_INCREMENT'],
    4,
    '0',
    STR_PAD_LEFT
);

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

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

                <a class="active" href="pembayaran.php">
                    Pembayaran
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
                    Tambah Data Pembayaran
                </h2>

                <form method="POST">

                    <div class="form-grid">

                        <div class="form-card">

                            <label>ID Pembayaran</label>

                            <input
                                type="text"
                                value="<?php echo $id_otomatis; ?>"
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

                                <option value="QRIS">
                                    QRIS
                                </option>

                                <option value="Transfer">
                                    Transfer
                                </option>

                                <option value="Tunai">
                                    Tunai
                                </option>

                            </select>

                        </div>

                        <div class="form-card">

                            <label>Tanggal</label>

                            <input
                                type="date"
                                name="tanggal_bayar"
                                required>

                        </div>

                        <div class="form-card">

                            <label>Total</label>

                            <input
                                type="number"
                                name="total_bayar"
                                min="0"
                                required>

                        </div>

                        <div class="form-card">

                            <label>No. Polisi</label>

                            <select
                                id="id_kendaraan"
                                name="id_kendaraan"
                                required>

                                <option value="">
                                    Pilih Kendaraan
                                </option>

                                <?php
                                while ($row = mysqli_fetch_assoc($kendaraan)) {
                                ?>

                                    <option
                                        value="<?php echo $row['id_kendaraan']; ?>">

                                        <?php echo $row['no_polisi']; ?>

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

                                <option value="Lunas">
                                    Lunas
                                </option>

                                <option value="Menunggak">
                                    Menunggak
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="button-group">

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
        $(document).ready(function() {

            $('#id_kendaraan').select2({
                placeholder: 'Cari Kendaraan',
                width: '100%'
            });

        });
    </script>

</body>

</html>

<?php

if (isset($_POST['simpan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $total_bayar = $_POST['total_bayar'];
    $status_pembayaran = $_POST['status_pembayaran'];

    mysqli_query(
        $koneksi,
        "INSERT INTO pembayaran
        (
            id_kendaraan,
            tanggal_bayar,
            jenis_pembayaran,
            total_bayar,
            status_pembayaran
        )
        VALUES
        (
            '$id_kendaraan',
            '$tanggal_bayar',
            '$jenis_pembayaran',
            '$total_bayar',
            '$status_pembayaran'
        )"
    );

    echo "

    <script>

        alert('Data pembayaran berhasil disimpan');

        window.location='pembayaran.php';

    </script>

    ";
}
?>