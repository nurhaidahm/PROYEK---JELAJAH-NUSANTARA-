<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Proses Tambah Ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    // Coba insert
    $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
              VALUES ($id, '$nama', '$komentar', $rating, NOW())";
    
    if (mysqli_query($conn, $query)) {
        // Jika sukses, redirect
        header("Location: detail.php?id=$id");
        exit();
    } else {
        // Tampilkan error jika gagal
        die("Error Query: " . mysqli_error($conn));
    }
}

// Ambil Data
$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

$queryUlasan = "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC";
$resultUlasan = mysqli_query($conn, $queryUlasan);
?>