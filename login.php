<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: pages/dashboard.php");
    exit;
}

include 'config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM user
WHERE username='$username'
AND password='$password'"
    );
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        header("Location: pages/dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>

<html>

<head>

    <title>Login Sistem Arsip Samsat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f1f3f7;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 40px;
        }

        .login-container {
            width: 100%;
            max-width: 1360px;
            min-height: 850px;

            background: white;

            border-radius: 28px;
            overflow: hidden;

            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-left {

            background: linear-gradient(180deg,
                    #072b66 0%,
                    #03122f 100%);

            color: white;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            position: relative;

            padding: 60px;
        }

        .login-left h1 {
            font-size: 56px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .login-left p {
            text-align: center;
            font-size: 22px;
            line-height: 1.8;
        }

        .login-footer {
            position: absolute;
            bottom: 30px;
            font-size: 14px;
        }

        .login-right {
            display: flex;
            justify-content: center;
            align-items: center;

            padding: 80px;
        }

        .login-form {
            width: 100%;
            max-width: 560px;
        }

        .login-form h2 {
            text-align: center;

            color: #12357A;

            font-size: 52px;
            font-weight: 700;
        }

        .subtitle {

            text-align: center;

            color: #7c8597;

            margin-top: 10px;
            margin-bottom: 60px;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;

            font-weight: 600;
            color: #12357A;
        }

        .form-group input {

            width: 100%;
            height: 58px;

            border: none;

            background: #f5f7fb;

            border-radius: 12px;

            padding: 0 18px;
        }

        .btn-login {

            width: 100%;
            height: 58px;

            border: none;

            background: #1658d8;
            color: white;

            border-radius: 12px;

            font-size: 20px;
            font-weight: 600;

            cursor: pointer;
        }

        .login-error {

            background: #fee2e2;
            color: #dc2626;

            padding: 14px;

            border-radius: 10px;

            text-align: center;

            margin-bottom: 20px;
        }

        @media(max-width:992px) {

            .login-container {
                grid-template-columns: 1fr;
            }

            .login-left {
                display: none;
            }

        }
    </style>

</head>

<body>

    <div class="login-container">

        <div class="login-left">

            <h1>SAMSAT BATU AJI</h1>

            <p>

                SISTEM PENGARSIPAN DATA
                <br>
                WAJIB PAJAK

            </p>

            <div class="login-footer">

                © 2026 Samsat Batu Aji. All rights reserved.

            </div>

        </div>

        <div class="login-right">

            <form
                method="POST"
                class="login-form">

                <h2>Selamat Datang!</h2>

                <div class="subtitle">

                    Silahkan masuk untuk melanjutkan ke sistem

                </div>

                <?php if (isset($error)) { ?>

                    <div class="login-error">

                        <?php echo $error; ?>

                    </div>

                <?php } ?>

                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        required>

                </div>

                <button
                    type="submit"
                    name="login"
                    class="btn-login">

                    Login

                </button>

            </form>

        </div>

    </div>

</body>

</html>