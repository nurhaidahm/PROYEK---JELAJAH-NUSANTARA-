<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "jelajah_nusantara";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// OTOMATISASI DATABASE: Mengecek & membuat kolom role_users jika belum ada di database VPS
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'role_users'");
if (mysqli_num_rows($check_column) == 0) {
    mysqli_query($conn, "ALTER TABLE users ADD COLUMN role_users ENUM('admin','user') DEFAULT 'user'");
}
?>