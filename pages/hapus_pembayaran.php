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
    "DELETE FROM pembayaran
    WHERE id_pembayaran='$id'"
);

header("Location: pembayaran.php");
exit;

?>