<?php
session_start();

require_once "../config/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Tambah Wajib Pajak</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">

</head>

<body>

    <div class="container">

        <div class="sidebar">

            <div class="logo">
                SAMSAT BATU AJI
            </div>

            <div class="menu">

                <a class="active" href="wajib_pajak.php">
                    Wajib Pajak
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
                    Tambah Data Wajib Pajak
                </h2>

                <form method="POST">

                    <div class="form-card">

                        <label>Nama</label>

                        <input
                            type="text"
                            name="nama"
                            required>

                    </div>

                    <div class="form-card">

                        <label>No. KTP</label>

                        <input
                            type="text"
                            name="no_ktp"
                            required>

                    </div>

                    <div class="form-card">

                        <label>No. HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            required>

                    </div>

                    <div class="form-card">

                        <label>Alamat</label>

                        <input
                            type="text"
                            name="alamat"
                            required>

                    </div>

                    <div class="button-group">

                        <a href="wajib_pajak.php" class="btn-back">
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

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $cek = mysqli_query(
    $koneksi,
    "SELECT id_wajib_pajak
     FROM wajib_pajak
     WHERE no_ktp = '$no_ktp'
     LIMIT 1"
);

if (mysqli_num_rows($cek) > 0) {

    echo "

    <script>

        alert('Nomor KTP sudah terdaftar!');

        window.location='tambah_wajib_pajak.php';

    </script>

    ";

    exit;
}

    mysqli_query(
        $koneksi,
        "INSERT INTO wajib_pajak
        (
            nama,
            no_ktp,
            alamat,
            no_hp
        )
        VALUES
        (
            '$nama',
            '$no_ktp',
            '$alamat',
            '$no_hp'
        )"
    );

    echo "

    <script>

        alert('Data berhasil disimpan');

        window.location='wajib_pajak.php';

    </script>

    ";
}
?>