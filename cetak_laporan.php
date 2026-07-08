<?php
require_once "../config/database.php";

$bulan = '';

if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
}

$tahun = '';

if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
}

$status = '';

if (isset($_GET['status'])) {
    $status = $_GET['status'];
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

ORDER BY pembayaran.id_pembayaran DESC"
);

$total_kendaraan = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,

        "SELECT COUNT(DISTINCT kendaraan.id_kendaraan) as total

FROM pembayaran

LEFT JOIN kendaraan
ON pembayaran.id_kendaraan = kendaraan.id_kendaraan

WHERE
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
)"
    )
);

$kendaraan_aktif = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,

        "SELECT COUNT(DISTINCT kendaraan.id_kendaraan) as total

FROM pembayaran

LEFT JOIN kendaraan
ON pembayaran.id_kendaraan = kendaraan.id_kendaraan

WHERE kendaraan.status='Aktif'

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
)"
    )
);

$pembayaran_lunas = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,

        "SELECT COUNT(*) as total

FROM pembayaran

WHERE status_pembayaran='Lunas'

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
    )
);

$pembayaran_menunggak = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,

        "SELECT COUNT(*) as total

FROM pembayaran

WHERE status_pembayaran='Menunggak'

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
    )
);

$total_pembayaran = mysqli_fetch_assoc(
    mysqli_query(
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
    )
);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan</title>

    <style>
        body {
            font-family: Arial;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>

</head>

<body>

    <h3 align="center">
        SAMSAT BATU AJI
    </h3>

    <h2 align="center">
        LAPORAN DATA PEMBAYARAN
    </h2>

    <p>
        Tanggal Cetak :
        <?php echo date('d F Y H:i'); ?>
    </p>

    <p>
        Periode :

        <?php

        $nama_bulan = array(
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember"
        );

        if ($bulan != '' && $tahun != '') {
            echo $nama_bulan[$bulan] . " " . $tahun;
        } elseif ($bulan != '') {
            echo $nama_bulan[$bulan] . " (Semua Tahun)";
        } elseif ($tahun != '') {
            echo "Tahun " . $tahun;
        } else {
            echo "Semua Periode";
        }

        ?>

    </p>

    <hr>

    <h3>Ringkasan Laporan</h3>

    <p>
        Total Kendaraan :
        <?php echo $total_kendaraan['total']; ?>
    </p>

    <p>
        Kendaraan Aktif :
        <?php echo $kendaraan_aktif['total']; ?>
    </p>

    <p>
        Pembayaran Lunas :
        <?php echo $pembayaran_lunas['total']; ?>
    </p>

    <p>
        Pembayaran Menunggak :
        <?php echo $pembayaran_menunggak['total']; ?>
    </p>

    <p>
        Total Pembayaran :
        Rp <?php echo number_format($total_pembayaran['total'], 0, ',', '.'); ?>
    </p>

    <hr>

    <table>

        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No Polisi</th>
            <th>Nama WP</th>
            <th>Total</th>
            <th>Status</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

            <tr>

                <td><?= $no++; ?></td>

                <td>
                    <?= date('d-m-Y', strtotime($data['tanggal_bayar'])); ?>
                </td>

                <td>
                    <?= $data['no_polisi']; ?>
                </td>

                <td>
                    <?= $data['nama']; ?>
                </td>

                <td>
                    Rp <?= number_format($data['total_bayar'], 0, ',', '.'); ?>
                </td>

                <td>
                    <?= $data['status_pembayaran']; ?>
                </td>

            </tr>

        <?php
        }
        ?>

    </table>

    <script>
        window.print();
    </script>

</body>

</html>