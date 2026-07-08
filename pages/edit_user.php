    <?php
    session_start();

    require_once "../config/database.php";

    $id = $_GET['id'];

    $data_user = mysqli_query(
        $koneksi,
        "SELECT *
FROM user
WHERE id_user='$id'"
    );

    $data = mysqli_fetch_assoc($data_user);

    if (!$data) {
        header("Location: user.php");
        exit;
    }

    if (!isset($_SESSION['id_user'])) {
        header("Location: ../login.php");
        exit;
    }

    if ($_SESSION['role'] != 'admin') {
        header("Location: dashboard.php");
        exit;
    }

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Edit Data User</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../assets/css/style.css?v=10">

    </head>

    <body>

        <div class="container">

            <div class="sidebar">

                <div class="logo">
                    SAMSAT BATU AJI
                </div>

                <div class="menu">

                    <?php if ($_SESSION['role'] == 'admin') { ?>

                        <a class="active" href="user.php">
                            User
                        </a>

                    <?php } ?>

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
                        Edit Data User
                    </h2>

                    <form method="POST">

                        <div class="form-grid">

                            <div class="form-card">

                                <label>ID User</label>

                                <input
                                    type="text"
                                    value="U-<?php echo str_pad($data['id_user'], 4, '0', STR_PAD_LEFT); ?>"
                                    readonly>

                            </div>

                            <div class="form-card">

                                <label>Nama</label>

                                <input
                                    type="text"
                                    name="nama"
                                    value="<?php echo $data['nama']; ?>"
                                    required>

                            </div>

                            <div class="form-card">

                                <label>Username</label>

                                <input
                                    type="text"
                                    name="username"
                                    value="<?php echo $data['username']; ?>"
                                    required>

                            </div>

                            <div class="form-card">

                                <label>Password</label>

                                <input
                                    type="text"
                                    name="password"
                                    value="<?php echo $data['password']; ?>"
                                    required>

                            </div>

                        </div>

                        <div class="button-group">

                            <?php if ($data['role'] != 'admin') { ?>

                            <a
                                href="hapus_user.php?id=<?php echo $id; ?>"
                                class="btn-delete"
                                onclick="return confirm('Hapus user ini?')">

                                Hapus

                            </a>

                            <?php } ?>

                            <a
                                href="user.php"
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

    </body>

    </html>

    <?php

    if (isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        mysqli_query(
            $koneksi,
            "UPDATE user
SET
    nama='$nama',
    username='$username',
    password='$password'
WHERE id_user='$id'"
        );

        echo "
    <script>

        alert('User berhasil diperbarui');

        window.location='user.php';

    </script>
    ";
    }

    ?>