<?php
// Memulai sesi untuk pengelolaan status login
session_start();
// Cek apakah pengguna belum login, jika belum, redirect ke halaman login.php

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
// Memanggil functions.php untuk menggunakan fungsi-fungsi yang diperlukan

include 'functions.php';
// Mengambil ID mahasiswa dari parameter URL

$id = $_GET["id"];
$mhs = query("SELECT * FROM mahasiswakkn WHERE id = $id")[0];
// Jika formulir edit data dikirimkan (submit)

if (isset($_POST["submit"])) {

        // Melakukan pengecekan dan perubahan data ke database menggunakan fungsi ubah
        // Jika berhasil, tampilkan alert dan redirect ke halaman index.php

    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil dirubah');
            document.location.href = 'index.php';
        </script>";
    } else {
        // Jika gagal, tampilkan alert dan redirect ke halaman index.php

        echo "
        <script>
            alert('data Gagal dirubah');
            document.location.href = 'index.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
 body {
    background-color: #34568B;
    color: white;
    text-align: center; 
}

h1 {
    text-align: center;
    color: white;
}

.form-container {
    width: 50%;
    margin: auto;
    margin-top: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

.img-container {
    margin-top: 10px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-danger {
    background-color: #d9534f;
    border-color: #d9534f;
    color: white;
}

.btn-success {
    background-color: #5bc0de;
    border-color: #5bc0de;
    color: white;
}

.btn-secondary {
    background-color: #777777;
    border-color: #777777;
    color: white;
}

.btn:hover {
    background-color: #333;
}

.drop-shadow {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    margin-bottom: 10px;
}

.form-control[type="file"] {
    padding-top: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

        }
    </style>
</head>

<body>
    <br>
    <h1>Edit Data Mahasiswa</h1>
    <a class="btn btn-danger drop-shadow cell-4  offset-4" href="index.php"><span class="mif-arrow-left"></span> Kembali</a>
    <br><br>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?php echo $mhs["gambar"]; ?>">
            <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap" required value="<?php echo $mhs["nama"]; ?>">
            </div>

            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" class="form-control" placeholder="Nomer Induk Mahasiswa" required value="<?php echo $mhs["nim"]; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Alamat Email" required value="<?php echo $mhs["email"]; ?>">
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan :</label>
                <input type="text" id="jurusan" name="jurusan" class="form-control" placeholder="Program Studi" required value="<?php echo $mhs["jurusan"]; ?>">
            </div>

            <div class="form-group">
                <label for="gambar">Gambar :</label>
                <div class="img-container thumbnail">
                    <img src="img/<?php echo $mhs['gambar'] ?>" width="100">
                </div>
                <input type="file" id="gambar" name="gambar" class="form-control" placeholder="Foto Profil">
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit" name="submit"><span class="mif-floppy-disk"></span> Edit</button>
                <button class="btn btn-secondary" type="reset" name="reset"><span class="mif-loop2 fg-red"></span> Reset</button>
            </div>
        </form>
    </div>
</body>

</html>
