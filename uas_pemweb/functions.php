<?php
// Koneksi ke database MySQL
$conn = mysqli_connect("localhost", "root", "", "db_mahasiswakkn");
// Fungsi untuk menjalankan query SQL dan mengembalikan hasil dalam bentuk array asosiatif

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)) {
        $rows [] = $row;
    }
    return $rows;
}
// Fungsi untuk menambahkan data mahasiswa ke database

function tambah ($data) {
    global $conn;
    // Melakukan sanitasi input data

    $nama = htmlspecialchars ($data["nama"]);
    $nim = htmlspecialchars ($data["nim"]);
    $email = htmlspecialchars ($data["email"]);
    $jurusan = htmlspecialchars ($data["jurusan"]);

    //upload gambar
    $gambar = upload();
    if( !$gambar) {
        return false;
    }
    // Menjalankan query SQL untuk menambahkan data ke database

    $query = "INSERT INTO mahasiswakkn VALUES('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);
     // Mengembalikan jumlah baris yang terpengaruh oleh query

    return mysqli_affected_rows($conn);
}
// Fungsi untuk mengunggah file gambar ke folder img dan mengembalikan nama file yang baru

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek ada gambar
    if( $error === 4 ) {
        echo "<script>
                alert('pilih gambar dahulu');
             </script>";
        return false;
    }

    //cek gambar atau gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
                alert('file ini bukan gambar');
             </script>";
        return false;
    }

    //cek jika ukuran terlalu besar
    if ( $ukuranFile > 1000000 ) {
        echo "<script>
        alert('ukuran gambar terlalu besar');
     </script>";
return false;
    }

    //gambar upload
    //generate nama gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar; 

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswakkn WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars ($data["nama"]);
    $nim = htmlspecialchars ($data["nim"]);
    $email = htmlspecialchars ($data["email"]);
    $jurusan = htmlspecialchars ($data["jurusan"]);
    $gambarLama = htmlspecialchars ($data["gambarLama"]);

    //cek apakah upload gambar baru
    if ( $_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswakkn SET
            nama = '$nama',
            nim = '$nim',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar'
            WHERE id = $id
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswakkn WHERE 
        nama LIKE '%$keyword%' OR 
        nim LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%'
    ";
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username ada
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if ( mysqli_fetch_assoc($result) ) {
        echo "<script>
            alert('username sudah ada')</script>";
            return false;
    }
    // cek konfirmasi password
    if ( $password !== $password2 ) {
        echo "<script>
            alert ('password tidak sama');
        </script>";
        return false;
    } 

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>