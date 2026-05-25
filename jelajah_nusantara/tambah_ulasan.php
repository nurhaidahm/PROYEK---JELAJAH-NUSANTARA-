<?php
session_start();
require 'db.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='loginregister.php';</script>";
    exit;
}

$id_wisata = $_POST['id_wisata'];
// FIX: Ambil dari $_SESSION['username'] yang sudah kita buat di loginregister.php
$nama_user = $_SESSION['username']; 
$komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
$rating = (int)$_POST['rating'];
$tanggal = date('Y-m-d H:i:s');

// Query insert
$query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal)
          VALUES ('$id_wisata', '$nama_user', '$komentar', '$rating', '$tanggal')";

if (mysqli_query($conn, $query)) {
    header("Location: detail.php?id=$id_wisata");
} else {
    // Tampilkan error jika query gagal agar kita tahu masalahnya
    echo "Error Database: " . mysqli_error($conn);
}
exit;