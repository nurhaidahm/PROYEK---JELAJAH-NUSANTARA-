<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ... (kode query wisata tetap sama) ...

// PROSES TAMBAH ULASAN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    // Pastikan kolom database di VPS kalian adalah 'tanggal' atau 'tanggal_ulasan'
    $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
              VALUES ($id, '$nama', '$komentar', $rating, NOW())";
    
    if (!mysqli_query($conn, $query)) {
        die("Gagal menyimpan ulasan: " . mysqli_error($conn)); // Ini akan muncul kalau ada kolom yang salah nama
    }
    
    header("Location: detail.php?id=$id");
    exit();
}

// ... (lanjutan kode query ulasan dan HTML tetap sama) ...