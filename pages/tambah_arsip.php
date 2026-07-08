    <?php
    session_start();

    require_once "../config/database.php";

    $id_query = mysqli_query(
        $koneksi,
        "SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA='db_arsip_samsat'
    AND TABLE_NAME='dokumen'"
    );

    $id_data = mysqli_fetch_assoc($id_query);

    $id_otomatis = "A-" . str_pad(
        $id_data['AUTO_INCREMENT'],
        4,
        '0',
        STR_PAD_LEFT
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

        <title>Tambah Data Arsip</title>

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
                        Tambah Data Arsip
                    </h2>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="upload-layout">

                            <div class="upload-form">

                                <div class="form-card">

                                    <label>ID Arsip</label>

                                    <input
                                        type="text"
                                        value="<?php echo $id_otomatis; ?>"
                                        readonly>

                                </div>

                                <div class="form-card">

                                    <label>Nama Arsip</label>

                                    <input
                                        type="text"
                                        name="nama_arsip"
                                        required>

                                </div>

                                <div class="form-card">

                                    <label>Jenis Dokumen</label>

                                    <select
                                        name="jenis_dokumen"
                                        required>

                                        <option value="">
                                            Pilih Jenis Dokumen
                                        </option>

                                        <option value="STNK">
                                            STNK
                                        </option>

                                        <option value="Lainnya">
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
                                                value="<?php echo $row['id_pembayaran']; ?>">

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
                                        required>

                                </div>

                            </div>

                            <div class="upload-preview">

                                <label>Upload File</label>

                                <label
                                    for="file"
                                    class="upload-box">

                                    <div class="upload-icon">+</div>

                                </label>

                                <p id="file-name">
                                    Belum ada file dipilih
                                </p>

                                <input
                                    type="file"
                                    id="file"
                                    name="file"
                                    class="file-input"
                                    required>

                            </div>

                        </div>

                        <div class="button-group">

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

        <script>
            document.getElementById('file').addEventListener('change', function() {

                if (this.files.length > 0) {
                    document.getElementById('file-name').innerText =
                        this.files[0].name;
                }

            });
        </script>

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

        $nama_arsip = $_POST['nama_arsip'];

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

        $tmp_file = $_FILES['file']['tmp_name'];

        $ekstensi = pathinfo(
            $_FILES['file']['name'],
            PATHINFO_EXTENSION
        );

        $nama_wp = str_replace(
            ' ',
            '',
            $relasi['nama']
        );

        $nama_file =
            $nama_arsip .
            "_" .
            $relasi['no_polisi'] .
            "_" .
            $nama_wp .
            "_" .
            date('YmdHis') .
            "." .
            $ekstensi;

        if ($jenis_dokumen == "STNK") {
            $nama_file =
                "STNK_" .
                $relasi['no_polisi'] .
                "_" .
                $nama_wp .
                "_" .
                date('YmdHis') .
                "." .
                $ekstensi;
        }

        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array(strtolower($ekstensi), $allowed)) {
            echo "
    <script>
        alert('Format file tidak didukung');
    </script>
    ";
            exit;
        }

        move_uploaded_file(
            $tmp_file,
            "../uploads/" . $nama_file
        );

        mysqli_query(
            $koneksi,
            "INSERT INTO dokumen
        (
            id_pembayaran,
            jenis_dokumen,
            nama_file,
            tanggal_upload
        )
        VALUES
        (
            '$id_pembayaran',
            '$jenis_dokumen',
            '$nama_file',
            '$tanggal_upload'
        )"
        );

        echo "

    <script>

        alert('Data arsip berhasil disimpan');

        window.location='arsip.php';

    </script>

    ";
    }

    ?>