<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "jelajah_nusantara";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 1. OTO-PERBAIKAN TABEL: USERS
$check_user_col = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'role_users'");
if (mysqli_num_rows($check_user_col) == 0) {
    mysqli_query($conn, "ALTER TABLE users ADD COLUMN role_users ENUM('admin','user') DEFAULT 'user'");
}

// 2. OTO-PERBAIKAN TABEL: WISATA (Memastikan id_wisata Auto Increment agar Tambah Wisata Lancar)
mysqli_query($conn, "ALTER TABLE `wisata` MODIFY `id_wisata` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY IF NOT EXISTS (`id_wisata`)");

// 3. OTO-PERBAIKAN TABEL: ULASAN (Memastikan kolom id_ulasan & penamaan kolom tanggal sinkron)
mysqli_query($conn, "ALTER TABLE `ulasan` MODIFY `id_ulasan` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY IF NOT EXISTS (`id_ulasan`)");

// Cek apakah kolom 'tanggal' di tabel ulasan belum ada, jika belum ada maka buatkan otomatis
$check_ulasan_date = mysqli_query($conn, "SHOW COLUMNS FROM `ulasan` LIKE 'tanggal'");
if (mysqli_num_rows($check_ulasan_date) == 0) {
    mysqli_query($conn, "ALTER TABLE `ulasan` ADD COLUMN `tanggal` DATETIME DEFAULT CURRENT_TIMESTAMP");
}
?>