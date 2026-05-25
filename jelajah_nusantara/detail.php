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
    echo "Gagal menyimpan ulasan. ";
    echo "Pesan Error MySQL: " . mysqli_error($conn) . "<br>";
    
    // Cek struktur kolom tabel ulasan
    $res = mysqli_query($conn, "DESCRIBE ulasan");
    echo "Struktur Tabel Ulasan Anda saat ini: <pre>";
    while($row = mysqli_fetch_assoc($res)) {
        print_r($row);
    }
    echo "</pre>";
    die(); 
}
    
    header("Location: detail.php?id=$id");
    exit();
}

