<?php
// Memulai sesi PHP
session_start();
// Jika sudah login, redirect ke halaman index.php
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
// Memanggil functions.php yang mungkin berisi fungsi-fungsi lain yang diperlukan
require 'functions.php';
// Jika form login dikirimkan (submit)
if (isset($_POST['login'])) {
     // Mengambil data username dan password dari form
    $username = $_POST["username"];
    $password = $_POST["password"];
      // Mengeksekusi query untuk mengambil data user dengan username yang sesuai
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($result) === 1)  {
        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            //sets session
            $_SESSION["login"] = true;
        }
        // Redirect ke halaman index.php
        header("location: index.php");
        exit;
    }
    
    // Jika username tidak ditemukan atau password salah, set variabel error
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login</title>
    <style>
        body {
            height: 100vh;
            background-color: #34568B;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-form {
            width: 350px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-form h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #343a40;
            text-align: center;
        }

        .login-form hr {
            border: 1px solid #dee2e6;
            margin: 15px 0;
        }

        .login-form input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 15px;
            margin-left: 10px;
            font-size: 14px;
        }

        .login-form input[type="checkbox"] + label {
            margin-bottom: 0;
            position: relative;
            float: right;
        }

        .login-form input[type="checkbox"] + label::before {
            content: '\2714';
            font-size: 18px;
            color: #20c997;
            margin-right: 5px;
        }

        .login-form input[type="checkbox"] + label::after {
            content: 'Ingat Saya';
            color: #343a40;
            font-size: 14px;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        .login-form a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        .notif-form {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f16c69;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .notif-form span {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .notif-form h5 {
            font-size: 16px;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <?php if (isset($error)) : ?>
        <div class="notif-form">
            <span class="mif-notification fg-white mif-4x place-right" style="margin-top: -10px;"></span>
            <h5 class="text-light">Username / Password Salah ! </h5>
        </div>
    <?php endif; ?>

    <form action="" method="post" class="login-form">
        <h2>Login</h2>
        <hr>
        <input type="text" name="username" placeholder="Masukkan username">
        <input type="password" name="password" placeholder="Masukkan password...">
        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember"></label>
        </div>
        <button type="submit" name="login">Masuk <span class="mif-enter"></span></button>
        <a href="registrasi.php">Daftar <span class="mif-user-plus"></span></a>
    </form>
</body>

</html>
