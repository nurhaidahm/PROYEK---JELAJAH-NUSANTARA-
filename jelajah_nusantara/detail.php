<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    // id_ulasan tidak perlu diisi karena sudah Auto Increment
    $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
              VALUES ($id, '$nama', '$komentar', $rating, NOW())";
    
    if (!mysqli_query($conn, $query)) {
        die("Error Query Insert: " . mysqli_error($conn));
    }
    header("Location: detail.php?id=$id");
    exit();
}

$queryUlasan = "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC";
$resultUlasan = mysqli_query($conn, $queryUlasan);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Detail Wisata') ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: rgb(13, 94, 90); padding: 20px; margin: 0; }
        h2, h3, p { color: white; }
        .container { display: flex; gap: 40px; align-items: flex-start; margin-bottom: 40px; }
        .left-column { flex: 1; }
        .right-column { flex: 1; }
        .gambar-wisata { max-width: 85%; height: auto; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); margin: 40px 0; }
        .form-container { background: #ffffff; padding: 25px; border-radius: 10px; border: 2px solid #b2dfdb; margin-top: 100px; }
        .form-container h3 { margin-top: 0; color: #00695c; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; margin: 5px 0 15px 0; border: 1px solid #b2dfdb; border-radius: 6px; }
        button[type="submit"] { background-color: #b2dfdb; border: none; color: #004d40; padding: 10px 16px; font-weight: bold; border-radius: 6px; cursor: pointer; }
        .ulasan-card { border: 1px solid #b2dfdb; background-color: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 10px; color: black; }
    </style>
</head>
<body>
<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata'] ?? '') ?></h2>
        <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata'] ?? '') ?>" class="gambar-wisata">
        <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata'] ?? '') ?></p>
        <p><?= htmlspecialchars($wisata['deskripsi_wisata'] ?? '') ?></p>
    </div>
    <div class="right-column">
        <div class="form-container">
            <h3>Tambah Ulasan</h3>
            <form method="POST">
                <input type="hidden" name="action" value="tambah">
                <label>Nama:</label><br><input type="text" name="nama" required>
                <label>Rating (1-5):</label><br><input type="number" name="rating" min="1" max="5" value="5">
                <label>Komentar:</label><br><textarea name="komentar" rows="4" required></textarea>
                <button type="submit">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>
<h3>Ulasan Pengunjung</h3>
<?php if ($resultUlasan && mysqli_num_rows($resultUlasan) > 0): ?>
    <?php while($ulasan = mysqli_fetch_assoc($resultUlasan)): ?>
        <div class="ulasan-card">
            <p><strong><?= htmlspecialchars($ulasan['nama_user']) ?></strong> - Rating: <?= $ulasan['rating'] ?>/5</p>
            <p><?= htmlspecialchars($ulasan['komentar_ulasan']) ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Belum ada ulasan.</p>
<?php endif; ?>
</body>
</html>