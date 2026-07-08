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
kendaraan.*,
wajib_pajak.nama

FROM kendaraan

LEFT JOIN wajib_pajak
ON kendaraan.id_wajib_pajak = wajib_pajak.id_wajib_pajak

WHERE
(
    kendaraan.no_polisi LIKE '%$cari%'
    OR wajib_pajak.nama LIKE '%$cari%'
)

AND
(
    '$status' = ''
    OR kendaraan.status = '$status'
)

ORDER BY kendaraan.id_kendaraan $urut"
    );
    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Data Kendaraan</title>

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

                    <a class="active" href="kendaraan.php">
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

                        <h2>Data Kendaraan</h2>

                        <a
                            href="tambah_kendaraan.php"
                            class="btn-add">

                            + Tambah Kendaraan

                        </a>

                    </div>

                    <form method="GET">

                        <div class="filter-card">

                            <div class="search-group">

                                <label>
                                    Cari No. Polisi / Nama Wajib Pajak
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
                                        value="Aktif"
                                        <?php if ($status == 'Aktif') echo 'selected'; ?>>

                                        Aktif

                                    </option>

                                    <option
                                        value="Rusak"
                                        <?php if ($status == 'Rusak') echo 'selected'; ?>>

                                        Rusak

                                    </option>

                                    <option
                                        value="Dijual"
                                        <?php if ($status == 'Dijual') echo 'selected'; ?>>

                                        Dijual

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

                </div>

                </form>

                <div class="table-card">

                    <table class="data-table">

                        <thead>

                            <tr>

                                <th>No.</th>
                                <th>Nama</th>
                                <th>No. Polisi</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Tahun</th>
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

                                        <td>
                                            <?php echo $no++; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['nama']; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['no_polisi']; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['merk']; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['tipe']; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['tahun']; ?>
                                        </td>

                                        <td>
                                            <?php echo $data['status']; ?>
                                        </td>

                                        <td>

                                            <a
                                                href="edit_kendaraan.php?id=<?php echo $data['id_kendaraan']; ?>"
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
                                        Belum ada data kendaraan.
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

    </body>

    </html>