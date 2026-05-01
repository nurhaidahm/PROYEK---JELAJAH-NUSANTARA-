<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "jelajah_nusantara";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pastikan tabel users memiliki kolom role_users
// Jalankan query berikut jika belum:
// ALTER TABLE users ADD COLUMN role_users ENUM('admin','user') DEFAULT 'user';
?>