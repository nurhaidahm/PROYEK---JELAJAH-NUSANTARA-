<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 1. Ambil data wisata
$resultWisata = mysqli_query($conn, "SELECT * FROM wisata WHERE id_wisata = $id");
$wisata = mysqli_fetch_assoc($resultWisata);

// 2. Proses POST (Tambah/Edit/Hapus) - Diletakkan di atas agar form bisa refresh data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // ... (kode logika tetap sama) ...
    header("Location: detail.php?id=$id");
    exit();
}

// 3. Ambil data ulasan
$resultUlasan = mysqli_query($conn, "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Detail') ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* CSS Kamu sudah bagus, tambahkan ini agar gambar muncul */
        .gambar-wisata { max-width: 100%; border-radius: 10px; }
    </style>
</head>
<body>

    <?php if ($wisata): ?>
        <h2><?= htmlspecialchars($wisata['nama_wisata']) ?></h2>
        <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata']) ?>" class="gambar-wisata">
        <p><?= htmlspecialchars($wisata['deskripsi_wisata']) ?></p>
    <?php else: ?>
        <p>Wisata tidak ditemukan.</p>
    <?php endif; ?>

    </body>
</html>