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

    $bulan = '';

    if (isset($_GET['bulan'])) {
        $bulan = $_GET['bulan'];
    }

    $tahun = '';

    if (isset($_GET['tahun'])) {
        $tahun = $_GET['tahun'];
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

AND
(
    '$bulan' = ''
    OR MONTH(pembayaran.tanggal_bayar) = '$bulan'
)

AND
(
    '$tahun' = ''
    OR YEAR(pembayaran.tanggal_bayar) = '$tahun'
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

                    <a href="pembayaran.php">
                        Pembayaran
                    </a>

                    <a href="arsip.php">
                        Arsip
                    </a>

                    <a class="active" href="laporan.php">
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

                        <h2>Laporan Data</h2>

                        <<a
                            href="cetak_laporan.php?cari=<?php echo urlencode($cari); ?>&tahun=<?php echo $tahun; ?>&bulan=<?php echo $bulan; ?>&status=<?php echo $status; ?>&urut=<?php echo $urut; ?>"
                            class="btn-add">
                            Cetak PDF
                            </a>

                    </div>

                    <form method="GET">

                        <div class="filter-card">

                            <div class="search-group">

                                <label>
                                    No. Polisi / Nama Wajib Pajak
                                </label>

                                <input
                                    type="text"
                                    name="cari"
                                    value="<?php echo $cari; ?>"
                                    placeholder="Ketik Untuk Mencari">

                            </div>

                            <div class="sort-group">

                                <label>
                                    Tahun
                                </label>

                                <input
                                    type="text"
                                    name="tahun"
                                    value="<?php echo $tahun; ?>"
                                    placeholder="Masukkan Tahun">

                            </div>

                            <div class="sort-group">

                                <label>
                                    Bulan
                                </label>

                                <select name="bulan">

                                    <option value=""
                                        <?php if ($bulan == '') echo 'selected'; ?>>
                                        Semua Bulan
                                    </option>

                                    <option value="1"
                                        <?php if ($bulan == '1') echo 'selected'; ?>>
                                        Januari
                                    </option>

                                    <option value="2"
                                        <?php if ($bulan == '2') echo 'selected'; ?>>
                                        Februari
                                    </option>

                                    <option value="3"
                                        <?php if ($bulan == '3') echo 'selected'; ?>>
                                        Maret
                                    </option>

                                    <option value="4"
                                        <?php if ($bulan == '4') echo 'selected'; ?>>
                                        April
                                    </option>

                                    <option value="5"
                                        <?php if ($bulan == '5') echo 'selected'; ?>>
                                        Mei
                                    </option>

                                    <option value="6"
                                        <?php if ($bulan == '6') echo 'selected'; ?>>
                                        Juni
                                    </option>

                                    <option value="7"
                                        <?php if ($bulan == '7') echo 'selected'; ?>>
                                        Juli
                                    </option>

                                    <option value="8"
                                        <?php if ($bulan == '8') echo 'selected'; ?>>
                                        Agustus
                                    </option>

                                    <option value="9"
                                        <?php if ($bulan == '9') echo 'selected'; ?>>
                                        September
                                    </option>

                                    <option value="10"
                                        <?php if ($bulan == '10') echo 'selected'; ?>>
                                        Oktober
                                    </option>

                                    <option value="11"
                                        <?php if ($bulan == '11') echo 'selected'; ?>>
                                        November
                                    </option>

                                    <option value="12"
                                        <?php if ($bulan == '12') echo 'selected'; ?>>
                                        Desember
                                    </option>

                                </select>

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
                                    <th>Tanggal</th>
                                    <th>No. Polisi</th>
                                    <th>Nama Wajib Pajak</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>

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
                                                <?php echo date('d M Y', strtotime($data['tanggal_bayar'])); ?>
                                            </td>

                                            <td>
                                                <?php echo $data['no_polisi']; ?>
                                            </td>

                                            <td>
                                                <?php echo $data['nama']; ?>
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

                                        </tr>

                                    <?php

                                    }
                                } else {

                                    ?>

                                    <tr>

                                        <td colspan="7">
                                            Belum ada data laporan.
                                        </td>

                                    </tr>

                                <?php

                                }

                                ?>

                            </tbody>

                        </table>

                        <?php

                        $total_query = mysqli_query(
                            $koneksi,

                            "SELECT SUM(total_bayar) as total

FROM pembayaran

WHERE
(
    '$status' = ''
    OR status_pembayaran = '$status'
)

AND
(
    '$bulan' = ''
    OR MONTH(tanggal_bayar) = '$bulan'
)

AND
(
    '$tahun' = ''
    OR YEAR(tanggal_bayar) = '$tahun'
)"
                        );

                        $total_data = mysqli_fetch_assoc($total_query);

                        ?>

                        <div style="margin-top:20px; text-align:right;">

                            <h3>
                                Total Pembayaran :
                                Rp <?php echo number_format($total_data['total'], 0, ',', '.'); ?>
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </body>

    </html>