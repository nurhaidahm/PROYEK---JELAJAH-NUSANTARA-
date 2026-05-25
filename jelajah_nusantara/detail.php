<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data wisata
$resultWisata = mysqli_query($conn, "SELECT * FROM wisata WHERE id_wisata = $id");
$wisata = mysqli_fetch_assoc($resultWisata);

// Proses Form Ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    mysqli_query($conn, "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) VALUES ($id, '$nama', '$komentar', $rating, NOW())");
    header("Location: detail.php?id=$id");
    exit();
}

$resultUlasan = mysqli_query($conn, "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Detail') ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container { display: flex; gap: 40px; align-items: flex-start; padding: 20px; }
        .left-column { flex: 1; }
        .right-column { flex: 1; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .gambar-wisata { max-width: 100%; border-radius: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata'] ?? '') ?></h2>
        <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata'] ?? '') ?>" class="gambar-wisata">
        <p><?= nl2br(htmlspecialchars($wisata['deskripsi_wisata'] ?? '')) ?></p>
        <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata'] ?? '') ?></p>
    </div>

    <div class="right-column">
        <h3>Tambah Ulasan</h3>
        <form method="POST">
            <input type="hidden" name="action" value="tambah">
            <label>Nama:</label><br><input type="text" name="nama" required style="width:100%"><br><br>
            <label>Rating:</label><br>
            <input type="number" name="rating" min="1" max="5" value="5" required><br><br>
            <label>Komentar:</label><br><textarea name="komentar" required style="width:100%" rows="4"></textarea><br><br>
            <button type="submit">Masukkan Ulasan</button>
        </form>
    </div>
</div>

</body>
</html>