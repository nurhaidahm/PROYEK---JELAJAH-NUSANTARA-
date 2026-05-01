<?php
session_start();
include '../db.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username'])) {
    header("Location: ../loginregister.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data wisata untuk menghapus gambar
$query = "SELECT gambar_wisata FROM wisata WHERE id_wisata = $id";
$result = mysqli_query($conn, $query);
$wisata = mysqli_fetch_assoc($result);

// Hapus gambar jika ada
if ($wisata && !empty($wisata['gambar_wisata']) && file_exists("../gambar/" . $wisata['gambar_wisata'])) {
    unlink("../gambar/" . $wisata['gambar_wisata']);
}

// Hapus wisata dari database
$query = "DELETE FROM wisata WHERE id_wisata = $id";
mysqli_query($conn, $query);

// Hapus juga ulasan terkait wisata ini
$query = "DELETE FROM ulasan WHERE id_wisata = $id";
mysqli_query($conn, $query);

header("Location: manage_wisata.php");
exit();
?>