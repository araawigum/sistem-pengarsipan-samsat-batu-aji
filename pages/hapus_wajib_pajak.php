<?php

session_start();

require_once "../config/database.php";

if(!isset($_SESSION['id_user']))
{
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM wajib_pajak
    WHERE id_wajib_pajak = '$id'"
);

header("Location: wajib_pajak.php");

exit;

?>