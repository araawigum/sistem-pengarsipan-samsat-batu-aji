    <?php
    session_start();

    require_once "../config/database.php";

    $cari = '';

    if (isset($_GET['cari'])) {
        $cari = $_GET['cari'];
    }

    $status = '';

    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    }

    $urut = 'DESC';

    if (isset($_GET['urut'])) {
        if ($_GET['urut'] == 'lama') {
            $urut = 'ASC';
        }
    }

    if (!isset($_SESSION['id_user'])) {
        header("Location: ../login.php");
        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "SELECT
pembayaran.*,
kendaraan.no_polisi,
wajib_pajak.nama

FROM pembayaran

LEFT JOIN kendaraan
ON pembayaran.id_kendaraan = kendaraan.id_kendaraan

LEFT JOIN wajib_pajak
ON kendaraan.id_wajib_pajak = wajib_pajak.id_wajib_pajak

WHERE
(
    pembayaran.id_pembayaran LIKE '%$cari%'
    OR kendaraan.no_polisi LIKE '%$cari%'
    OR wajib_pajak.nama LIKE '%$cari%'
)

AND
(
    '$status' = ''
    OR pembayaran.status_pembayaran = '$status'
)

ORDER BY pembayaran.id_pembayaran $urut"
    );
    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Data Pembayaran</title>

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

                    <a class="active" href="pembayaran.php">
                        Pembayaran
                    </a>

                    <a href="arsip.php">
                        Arsip
                    </a>

                    <a href="laporan.php">
                        Laporan
                    </a>

                    <?php if ($_SESSION['role'] == 'admin') { ?>

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

                        <h2>Data Pembayaran</h2>

                        <a
                            href="tambah_pembayaran.php"
                            class="btn-add">

                            + Tambah Pembayaran

                        </a>

                    </div>

                    <form method="GET">

                        <div class="filter-card">

                            <div class="search-group">

                                <label>
                                    Cari ID Pembayaran / No. Polisi / Nama
                                </label>

                                <input
                                    type="text"
                                    name="cari"
                                    value="<?php echo $cari; ?>"
                                    placeholder="Ketik Untuk Mencari">

                            </div>

                            <div class="sort-group">

                                <label>
                                    Status
                                </label>

                                <select name="status">

                                    <option
                                        value=""
                                        <?php if ($status == '') echo 'selected'; ?>>

                                        Semua Status

                                    </option>

                                    <option
                                        value="Lunas"
                                        <?php if ($status == 'Lunas') echo 'selected'; ?>>

                                        Lunas

                                    </option>

                                    <option
                                        value="Menunggak"
                                        <?php if ($status == 'Menunggak') echo 'selected'; ?>>

                                        Menunggak

                                    </option>

                                </select>

                            </div>

                            <div class="sort-group">

                                <label>
                                    Urutkan
                                </label>

                                <select name="urut">

                                    <option
                                        value="baru"
                                        <?php if ($urut == 'DESC') echo 'selected'; ?>>

                                        Terbaru

                                    </option>

                                    <option
                                        value="lama"
                                        <?php if ($urut == 'ASC') echo 'selected'; ?>>

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
                                    <th>ID Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>No. Polisi</th>
                                    <th>Jenis</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                if (mysqli_num_rows($query) > 0) {
                                    $no = 1;

                                    while ($data = mysqli_fetch_assoc($query)) {

                                ?>

                                        <tr>

                                            <td><?php echo $no++; ?></td>

                                            <td>
                                                P-<?php echo str_pad($data['id_pembayaran'], 4, '0', STR_PAD_LEFT); ?>
                                            </td>

                                            <td>
                                                <?php echo date('d M Y', strtotime($data['tanggal_bayar'])); ?>
                                            </td>

                                            <td>
                                                <?php echo str_pad($data['no_polisi'], 4, '0', STR_PAD_LEFT); ?>
                                            </td>

                                            <td>
                                                <?php echo $data['jenis_pembayaran']; ?>
                                            </td>

                                            <td>
                                                Rp <?php echo number_format($data['total_bayar'], 0, ',', '.'); ?>
                                            </td>

                                            <td>
                                                <?php echo $data['status_pembayaran']; ?>
                                            </td>

                                            <td>

                                                <a
                                                    href="edit_pembayaran.php?id=<?php echo $data['id_pembayaran']; ?>"
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
                                } else {

                                    ?>

                                    <tr>

                                        <td colspan="8">
                                            Belum ada data pembayaran.
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