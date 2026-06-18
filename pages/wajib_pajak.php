<?php
session_start();

require_once "../config/database.php";

$cari = '';

if(isset($_GET['cari']))
{
    $cari = $_GET['cari'];
}

$urut = 'DESC';

if(isset($_GET['urut']))
{
    if($_GET['urut'] == 'lama')
    {
        $urut = 'ASC';
    }
}

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query(
    $koneksi,
    "SELECT *
    FROM wajib_pajak

    WHERE
    nama LIKE '%$cari%'
    OR no_ktp LIKE '%$cari%'
    OR no_hp LIKE '%$cari%'
    OR alamat LIKE '%$cari%'
    OR id_wajib_pajak LIKE '%$cari%'

    ORDER BY id_wajib_pajak $urut"
);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Data Wajib Pajak</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin>

    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

    <link
    rel="stylesheet"
    href="../assets/css/style.css">

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

            <a
            class="active"
            href="wajib_pajak.php">
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
                    <?php echo $_SESSION['nama']; ?>
                </span>

            </div>

        </div>

        <div class="content">

            <div class="page-header">

                <h2>Data Wajib Pajak</h2>

                <a
                href="tambah_wajib_pajak.php"
                class="btn-add">

                    + Tambah Data

                </a>

            </div>

            <form method="GET">

                <div class="filter-card">

                    <div class="search-group">

                        <label>
                            Cari Nama / No. KTP / No. HP
                        </label>

                        <input
                        type="text"
                        name="cari"
                        value="<?php echo $cari; ?>"
                        placeholder="Ketik Untuk Mencari">

                    </div>

                    <div class="sort-group">

                        <label>
                            Urutkan
                        </label>

                        <select name="urut">

                            <option
                            value="baru"
                            <?php if($urut == 'DESC') echo 'selected'; ?>>

                                Terbaru

                            </option>

                            <option
                            value="lama"
                            <?php if($urut == 'ASC') echo 'selected'; ?>>

                                Terlama

                            </option>

                        </select>

                        <button
                        type="submit"
                        class="btn-save">

                            Cari

                        </button>

                    </div>

                </div>

            </form>

            <div class="table-card">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>No.</th>
                            <th>Nama</th>
                            <th>No. KTP</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>ID WP</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        if(mysqli_num_rows($query) > 0)
                        {
                            $no = 1;

                            while($data = mysqli_fetch_assoc($query))
                            {
                        ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>

                            <td>
                                <?php echo $data['nama']; ?>
                            </td>

                            <td>
                                <?php echo $data['no_ktp']; ?>
                            </td>

                            <td>
                                <?php echo $data['no_hp']; ?>
                            </td>

                            <td>
                                <?php echo $data['alamat']; ?>
                            </td>

                            <td>
                                WP-<?php echo str_pad($data['id_wajib_pajak'], 4, '0', STR_PAD_LEFT); ?>
                            </td>

                            <td>

                                <a
                                href="edit_wajib_pajak.php?id=<?php echo $data['id_wajib_pajak']; ?>"
                                class="btn-edit">

                                    <img
                                    src="../assets/css/images/tabler_edit.png"
                                    alt="Edit"
                                    class="icon-edit">

                                </a>

                            </td>

                        </tr>

                        <?php
                            }
                        }
                        else
                        {
                        ?>

                        <tr>

                            <td colspan="7">
                                Belum ada data wajib pajak.
                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>