    <?php
    session_start();

    require_once "../config/database.php";

    $id = $_GET['id'];

    $data_arsip = mysqli_query(
        $koneksi,
        "SELECT *
    FROM dokumen
    WHERE id_dokumen='$id'"
    );

    $data = mysqli_fetch_assoc($data_arsip);

    $ext = strtolower(
        pathinfo(
            $data['nama_file'],
            PATHINFO_EXTENSION
        )
    );

    $pembayaran = mysqli_query(
        $koneksi,
        "SELECT
        pembayaran.*,
        kendaraan.no_polisi

    FROM pembayaran

    LEFT JOIN kendaraan
    ON pembayaran.id_kendaraan = kendaraan.id_kendaraan

    ORDER BY pembayaran.id_pembayaran DESC"
    );

    if (!isset($_SESSION['id_user'])) {
        header("Location: ../login.php");
        exit;
    }

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Edit Data Arsip</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../assets/css/style.css?v=10">

        <link
            href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet">

    </head>

    <body>

        <div class="container">

            <div class="sidebar">

                <div class="logo">
                    SAMSAT BATU AJI
                </div>

                <div class="menu">

                    <a class="active" href="arsip.php">
                        Arsip
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
                        Edit Data Arsip
                    </h2>

                    <form method="POST">

                        <div class="edit-layout">

                            <div class="form-section">

                                <div class="form-card">

                                    <label>ID Arsip</label>

                                    <input
                                        type="text"
                                        value="A-<?php echo str_pad($data['id_dokumen'], 4, '0', STR_PAD_LEFT); ?>"
                                        readonly>

                                </div>

                                <div class="form-card">

                                    <label>Nama File</label>

                                    <input
                                        type="text"
                                        value="<?php echo $data['nama_file']; ?>"
                                        readonly>

                                </div>

                                <div class="form-card">

                                    <label>Jenis Dokumen</label>

                                    <select
                                        name="jenis_dokumen"
                                        required>

                                        <option value="">
                                            Pilih Jenis Dokumen
                                        </option>

                                        <option
                                            value="STNK"
                                            <?php if ($data['jenis_dokumen'] == 'STNK') echo 'selected'; ?>>

                                            STNK

                                        </option>

                                        <option
                                            value="Lainnya"
                                            <?php if ($data['jenis_dokumen'] == 'Lainnya') echo 'selected'; ?>>

                                            Lainnya

                                        </option>

                                    </select>

                                </div>

                                <div class="form-card">

                                    <label>ID Pembayaran</label>

                                    <select
                                        id="id_pembayaran"
                                        name="id_pembayaran"
                                        required>

                                        <option value="">
                                            Pilih Pembayaran
                                        </option>

                                        <?php
                                        while ($row = mysqli_fetch_assoc($pembayaran)) {
                                        ?>

                                            <option
                                                value="<?php echo $row['id_pembayaran']; ?>"

                                                <?php
                                                if ($row['id_pembayaran'] == $data['id_pembayaran']) {
                                                    echo "selected";
                                                }
                                                ?>>

                                                P-<?php echo str_pad($row['id_pembayaran'], 4, '0', STR_PAD_LEFT); ?>
                                                -
                                                <?php echo $row['no_polisi']; ?>

                                            </option>

                                        <?php
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="form-card">

                                    <label>Tanggal Upload</label>

                                    <input
                                        type="datetime-local"
                                        name="tanggal_upload"
                                        value="<?php echo date('Y-m-d\TH:i', strtotime($data['tanggal_upload'])); ?>"
                                        required>

                                </div>

                            </div>

                            <div class="preview-section">

                                <label>Preview File</label>

                                <p style="
    margin-top:6px;
    margin-bottom:12px;
    font-size:13px;
    color:#666;
    ">
                                    <?php echo $data['nama_file']; ?>
                                </p>

                                <div class="preview-box">

                                    <?php
                                    if (file_exists("../uploads/" . $data['nama_file'])) {
                                    ?>

                                        <?php if ($ext == 'pdf') { ?>

                                            <iframe
                                                src="../uploads/<?php echo $data['nama_file']; ?>"
                                                width="100%"
                                                height="100%"
                                                style="border:none;">
                                            </iframe>

                                        <?php } elseif (
                                            $ext == 'jpg' ||
                                            $ext == 'jpeg' ||
                                            $ext == 'png'
                                        ) { ?>

                                            <img
                                                src="../uploads/<?php echo $data['nama_file']; ?>"
                                                style="
        width:100%;
        height:100%;
        object-fit:contain;
        ">

                                        <?php } else { ?>

                                            <div style="padding:20px;">

                                                File tidak dapat dipreview.

                                                <br><br>

                                                <a
                                                    href="../uploads/<?php echo $data['nama_file']; ?>"
                                                    target="_blank"
                                                    class="btn-edit">

                                                    Download File

                                                </a>

                                            </div>

                                        <?php } ?>

                                    <?php
                                    } else {
                                    ?>

                                        <p style="padding:20px;">
                                            File tidak ditemukan.
                                        </p>

                                    <?php
                                    }
                                    ?>

                                </div>

                            </div>

                        </div>

                        <div class="button-group">

                            <a
                                href="hapus_arsip.php?id=<?php echo $id; ?>"
                                class="btn-delete"
                                onclick="return confirm('Hapus arsip ini?')">

                                Hapus

                            </a>

                            <a
                                href="arsip.php"
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

                $('#id_pembayaran').select2({
                    placeholder: 'Cari Pembayaran',
                    width: '100%'
                });

            });
        </script>

    </body>

    </html>

    <?php

    if (isset($_POST['simpan'])) {
        $id_pembayaran = $_POST['id_pembayaran'];
        $jenis_dokumen = $_POST['jenis_dokumen'];
        $tanggal_upload = $_POST['tanggal_upload'];

        $nama_file = $data['nama_file'];

        $data_relasi = mysqli_query(
            $koneksi,
            "SELECT
    kendaraan.no_polisi,
    wajib_pajak.nama
    FROM pembayaran
    LEFT JOIN kendaraan
    ON pembayaran.id_kendaraan = kendaraan.id_kendaraan
    LEFT JOIN wajib_pajak
    ON kendaraan.id_wajib_pajak = wajib_pajak.id_wajib_pajak
    WHERE pembayaran.id_pembayaran='$id_pembayaran'"
        );

        $relasi = mysqli_fetch_assoc($data_relasi);

        $nama_wp = str_replace(
            ' ',
            '',
            $relasi['nama']
        );

        mysqli_query(
            $koneksi,
            "UPDATE dokumen
    SET
        id_pembayaran='$id_pembayaran',
        jenis_dokumen='$jenis_dokumen',
        nama_file='$nama_file',
        tanggal_upload='$tanggal_upload'
    WHERE id_dokumen='$id'"
        );

        echo "

    <script>

        alert('Data arsip berhasil diperbarui');

        window.location='arsip.php';

    </script>

    ";
    }

    ?>