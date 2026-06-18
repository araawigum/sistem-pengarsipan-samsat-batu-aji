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

   $query = mysqli_query(
$koneksi,
"SELECT
dokumen.*,
pembayaran.id_pembayaran,
kendaraan.no_polisi
FROM dokumen
LEFT JOIN pembayaran
ON dokumen.id_pembayaran = pembayaran.id_pembayaran
LEFT JOIN kendaraan
ON pembayaran.id_kendaraan = kendaraan.id_kendaraan

WHERE
dokumen.id_dokumen LIKE '%$cari%'
OR pembayaran.id_pembayaran LIKE '%$cari%'
OR kendaraan.no_polisi LIKE '%$cari%'

ORDER BY dokumen.id_dokumen $urut"
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

    <title>Data Arsip</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">

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

            <a class="active" href="arsip.php">
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

                <h2>Data Arsip</h2>

                <a
href="tambah_arsip.php"
class="btn-add">

    + Tambah Arsip

</a>

            </div>

            <form method="GET">

<div class="filter-card">

    <div class="search-group">

        <label>
            Cari ID Arsip / No. Polisi / ID Pembayaran
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
    <th>ID Arsip</th>
    <th>ID Pembayaran</th>
    <th>Jenis Dokumen</th>
    <th>Nama File</th>
    <th>Tanggal Upload</th>
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
        A-<?php echo str_pad($data['id_dokumen'],4,'0',STR_PAD_LEFT); ?>
    </td>

    <td>
        P-<?php echo str_pad($data['id_pembayaran'],4,'0',STR_PAD_LEFT); ?>
    </td>

    <td>
        <?php echo $data['jenis_dokumen']; ?>
    </td>

    <td>
        <?php
echo strlen($data['nama_file']) > 40
? substr($data['nama_file'],0,40).'...'
: $data['nama_file'];
?>
    </td>

    <td>
        <?php echo date('d M Y', strtotime($data['tanggal_upload'])); ?>
    </td>

    <td>

        <a
href="edit_arsip.php?id=<?php echo $data['id_dokumen']; ?>"
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
        Belum ada data Arsip.
    </td>

</tr>

<?php

}

?>

</tbody>

                </table>

            </div>

        </div>

    </div>

    </div>

    </body>
    </html>