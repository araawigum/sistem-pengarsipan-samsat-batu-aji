<?php
session_start();

require_once "../config/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT *
    FROM dokumen
    WHERE id_dokumen='$id'"
);

$arsip = mysqli_fetch_assoc($data);

if (file_exists("../uploads/" . $arsip['nama_file'])) {
    unlink("../uploads/" . $arsip['nama_file']);
}

mysqli_query(
    $koneksi,
    "DELETE FROM dokumen
    WHERE id_dokumen='$id'"
);

echo "

<script>

alert('Data arsip berhasil dihapus');

window.location='arsip.php';

</script>

";