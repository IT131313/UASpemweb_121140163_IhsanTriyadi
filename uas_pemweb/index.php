<?php
class MahasiswaController
{
    // Koneksi ke database

    private $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect("localhost", "root", "", "db_mahasiswakkn");
    }
    // Fungsi untuk menjalankan query
    public function query($query)
    {
        $result = mysqli_query($this->conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
     // Fungsi untuk mendapatkan data mahasiswa per halaman

    public function getDataPerPage($halamanAktif, $jumlahDataPerHalaman)
    {
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
        $query = "SELECT * FROM mahasiswakkn LIMIT $awalData, $jumlahDataPerHalaman";
        return $this->query($query);
    }
     // Fungsi untuk menghitung jumlah halaman
    public function hitungJumlahHalaman($jumlahData, $jumlahDataPerHalaman)
    {
        return ceil($jumlahData / $jumlahDataPerHalaman);
    }
    // Fungsi untuk mencari data berdasarkan keyword
    public function cariData($keyword)
    {
        $query = "SELECT * FROM mahasiswakkn WHERE 
            nama LIKE '%$keyword%' OR 
            nim LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'
        ";
        return $this->query($query);
    }
}

// Gunakan class MahasiswaController
// Inisialisasi objek MahasiswaController
$mahasiswaController = new MahasiswaController();
// Mengecek apakah pengguna sudah login, jika tidak, redirect ke halaman login
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
// Memanggil functions.php yang mungkin berisi fungsi-fungsi lain yang diperlukan

//pagination
//config pagination
$jumlahDataPerHalaman = 5;
$jumlahData = count($mahasiswaController->query("SELECT * FROM mahasiswakkn"));
$jumlahHalaman = $mahasiswaController->hitungJumlahHalaman($jumlahData, $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

$mahasiswakkn = $mahasiswaController->getDataPerPage($halamanAktif, $jumlahDataPerHalaman);

//cari
if (isset($_POST["cari"])) {
    $mahasiswakkn = $mahasiswaController->cariData($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body {
            height: 100vh;
            background-color:  #34568B;
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 20px;
        }

        #judul {
            text-align: center;
            color: white;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .btn:hover {
            background-color: white;
            color: black;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 70%;
            padding: 10px;
            box-sizing: border-box;
        }

        .btn-outline-secondary {
            background-color: white;
            color: #007BFF;
            border: 1px solid #007BFF;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-left: -1px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .btn-outline-secondary:hover {
            background-color: #007BFF;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
        }

       
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            background-color: #007BFF;
            color: white;
            border: 1px solid #007BFF;
            padding: 8px 16px;
            text-decoration: none;
            cursor: pointer;
        }

        .page-link:hover {
            background-color: white;
            color: #007BFF;
        }
    </style>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>

<body class="h-vh-100 bg-brandColor2">
    <?php include 'nav.php'; ?>
    <br><br><br>
    <div class="container">
        <h1 id="judul" align="center">Daftar Mahasiswa KKN</h1>
        <a class="btn btn-primary mb-3" href="tambah.php">Tambah Data Mahasiswa</a>
        <form action="" method="post" class="mb-3">
            <div class="input-group">
                <input id="keyword" type="text" name="keyword" class="form-control" placeholder="Cari dengan nama atau nim atau jurusan" autofocus autocomplete="off">
                <button class="btn btn-outline-secondary" type="submit" name="cari">Cari</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Gambar</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($mahasiswakkn as $row) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <a class="btn btn-success" href="ubah.php?id=<?php echo $row["id"]; ?>">Edit</a>
                            <a class="btn btn-danger" href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Yakin');">Hapus</a>
                        </td>
                        <td><img src="img/<?php echo $row["gambar"]; ?>" alt="" width="50"></td>
                        <td><?php echo $row["nim"]; ?></td>
                        <td><?php echo $row["nama"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["jurusan"]; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- PAGINATION -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($halamanAktif > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $halamanAktif - 1 ?>">Prev</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                    <?php if ($i == $halamanAktif) : ?>
                        <li class="page-item active"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php else : ?>
                        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $halamanAktif + 1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
 
    <script>
        function cariMahasiswa() {
            var keywordValue = document.getElementById("keyword").value.toLowerCase();
            var judulElement = document.getElementById("judul");

            judulElement.style.color = "";
        }
    </script>
</body>

</html>
