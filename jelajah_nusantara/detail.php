<?php
include 'db.php';

// Mendapatkan ID Wisata dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 1. Ambil Data Wisata
$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

// 2. Proses Form Tambah Ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
              VALUES ($id, '$nama', '$komentar', $rating, NOW())";
    
    // Jika gagal, munculkan pesan error
    if (!mysqli_query($conn, $query)) {
        die("Error Query Insert: " . mysqli_error($conn));
    }

    // Jika berhasil, refresh halaman agar ulasan muncul
    header("Location: detail.php?id=$id&status=success");
    exit();
}

// 3. Ambil Data Ulasan
$queryUlasan = "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC";
$resultUlasan = mysqli_query($conn, $queryUlasan);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Wisata') ?> - Detail</title>
    <style>
        body { font-family: sans-serif; background-color: rgb(13, 94, 90); padding: 20px; color: white; }
        .container { display: flex; gap: 40px; margin-bottom: 50px; }
        .gambar-wisata { max-width: 85%; border-radius: 12px; }
        .form-container { background: #ffffff; padding: 25px; border-radius: 10px; color: black; }
        .ulasan-card { border: 1px solid #b2dfdb; background-color: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 10px; color: black; }
    </style>
</head>
<body>

<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Wisata Tidak Ditemukan') ?></h2>
        <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata'] ?? '') ?>" class="gambar-wisata">
        <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata'] ?? '') ?></p>
        <p><?= htmlspecialchars($wisata['deskripsi_wisata'] ?? '') ?></p>
    </div>

    <div class="right-column">
        <div class="form-container">
            <h3>Tambah Ulasan</h3>
            <form method="POST">
                <input type="hidden" name="action" value="tambah">
                <label>Nama:</label><br>
                <input type="text" name="nama" required style="width:100%;"><br><br>
                <label>Rating (1-5):</label><br>
                <input type="number" name="rating" min="1" max="5" value="5" style="width:100%;"><br><br>
                <label>Komentar:</label><br>
                <textarea name="komentar" rows="4" required style="width:100%;"></textarea><br><br>
                <button type="submit" style="padding:10px 20px; cursor:pointer;">Kirim Ulasan</button>
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
            <small><?= $ulasan['tanggal'] ?></small>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Belum ada ulasan untuk wisata ini.</p>
<?php endif; ?>

</body>
</html>