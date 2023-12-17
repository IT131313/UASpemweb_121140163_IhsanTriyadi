<?php
// Memanggil functions.php
require 'functions.php';
// Jika form registrasi dikirimkan (submit)
if (isset($_POST["register"])) {
    // Memanggil fungsi registrasi dari functions.php
    // Jika registrasi berhasil, tampilkan alert dan redirect ke halaman login.php
    if (registrasi($_POST) > 0) {
        echo "<script>
            alert ('user baru berhasil ditambahkan');
        </script>";
        header("Location: login.php");
    } else {
        // Jika registrasi gagal, tampilkan pesan error dari MySQL
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Registrasi</title>
  
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
       .regist-form {
    width: 410px;
    margin: auto;
    margin-top: 5%;
    background-color: #f8f9fa; 
    padding: 35px; 
}
        .text-center {
            text-align: center;
        }

        .text-primary {
            color: #007bff;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .form-label {
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-text {
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #6c757d;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
                box-shadow 0.15s ease-in-out;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
        }
    </style>
</head>

<body class="h-vh-100 bg-brandColor2">
    <br><br>

    <form action="" method="post" class="regist-form bg-white p-4 border bd-default win-shadow">
        <h1 class="text-center text-primary">Registrasi</h1>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Masukan Username" />
            <small class="form-text text-muted">Username tidak boleh memakai spasi dan huruf kecil semua</small>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukan Password" />
            <small class="form-text text-muted">Password minimal 8 karakter dicampur dengan angka atau simbol</small>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Konfirmasi Password</label>
            <input type="password" id="password2" name="password2" class="form-control"
                placeholder="Masukan Kembali Password Anda" />
            <small class="form-text text-muted">Masukan ulang password untuk konfirmasi</small>
        </div>
        <div class="mb-3">
            <button class="btn btn-success" type="submit" name="register"><span class="mif-user"></span> Daftar</button>
            <button class="btn btn-danger" type="reset" name="reset"><span class="mif-loop2"></span> Reset</button>
            <a class="btn btn-dark" href="login.php"><span class="mif-cancel"></span> Batal</a>
        </div>
    </form>

</body>

</html>
