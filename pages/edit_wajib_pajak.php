<?php

session_start();

require_once "../config/database.php";

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM wajib_pajak
    WHERE id_wajib_pajak='$id'"
);

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Wajib Pajak</title>

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

            <a class="active" href="wajib_pajak.php">
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
                Edit Data Wajib Pajak
            </h2>

            <form method="POST">

                <div class="form-card">

                    <label>Nama</label>

                    <input
                    type="text"
                    name="nama"
                    value="<?php echo $data['nama']; ?>"
                    required>

                </div>

                <div class="form-card">

                    <label>No. KTP</label>

                    <input
                    type="text"
                    name="no_ktp"
                    value="<?php echo $data['no_ktp']; ?>"
                    required>

                </div>

                <div class="form-card">

                    <label>No. HP</label>

                    <input
                    type="text"
                    name="no_hp"
                    value="<?php echo $data['no_hp']; ?>"
                    required>

                </div>

                <div class="form-card">

                    <label>Alamat</label>

                    <input
                    type="text"
                    name="alamat"
                    value="<?php echo $data['alamat']; ?>"
                    required>

                </div>

                <div class="button-group">

    <a
    href="hapus_wajib_pajak.php?id=<?php echo $id; ?>"
    class="btn-delete"
    onclick="return confirm('Hapus data ini?')">

        Hapus

    </a>

                    <a
                    href="wajib_pajak.php"
                    class="btn-back">

                        Kembali

                    </a>

                    <button
                    type="submit"
                    name="update"
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

if(isset($_POST['update']))
{
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query(
        $koneksi,
        "UPDATE wajib_pajak
        SET
        nama='$nama',
        no_ktp='$no_ktp',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE id_wajib_pajak='$id'"
    );

    echo "

    <script>

        alert('Data berhasil diperbarui');

        window.location='wajib_pajak.php';

    </script>

    ";
}
?>