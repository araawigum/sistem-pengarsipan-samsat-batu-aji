<?php
session_start();

require_once "../config/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

if ($id == $_SESSION['id_user']) {
    echo "
    <script>

        alert('Anda tidak dapat menghapus akun yang sedang digunakan');

        window.location='user.php';

    </script>
    ";
    exit;
}

mysqli_query(
    $koneksi,
    "DELETE FROM user
WHERE id_user='$id'"
);

echo "
<script>

    alert('User berhasil dihapus');

    window.location='user.php';

</script>
";