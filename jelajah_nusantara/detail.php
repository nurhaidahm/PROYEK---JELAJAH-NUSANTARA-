<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Proses Form POST (Tambah/Edit/Hapus) - DITARUH DI ATAS agar data selalu fresh
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'tambah') {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $rating = (int)$_POST['rating'];
        $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
        $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) VALUES ($id, '$nama', '$komentar', $rating, NOW())";
        mysqli_query($conn, $query) or die("Error Insert: " . mysqli_error($conn));
        
    } elseif ($action === 'edit') {
        $id_ulasan = (int)$_POST['id_ulasan'];
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $rating = (int)$_POST['rating'];
        $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
        $query = "UPDATE ulasan SET nama_user = '$nama', komentar_ulasan = '$komentar', rating = $rating WHERE id_ulasan = $id_ulasan";
        mysqli_query($conn, $query) or die("Error Update: " . mysqli_error($conn));
        
    } elseif ($action === 'hapus') {
        $id_ulasan = (int)$_POST['id_ulasan'];
        mysqli_query($conn, "DELETE FROM ulasan WHERE id_ulasan = $id_ulasan") or die("Error Delete: " . mysqli_error($conn));
    }
    
    header("Location: detail.php?id=$id");
    exit();
}

// Ambil data wisata & ulasan (Dijalankan SETELAH proses POST)
$resultWisata = mysqli_query($conn, "SELECT * FROM wisata WHERE id_wisata = $id");
$wisata = mysqli_fetch_assoc($resultWisata);

$resultUlasan = mysqli_query($conn, "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Detail Wisata') ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: rgb(13, 94, 90); padding: 20px; margin: 0; color: white; }
        .container { display: flex; gap: 40px; margin-bottom: 40px; }
        .left-column { flex: 1; }
        .right-column { flex: 1; }
        .gambar-wisata { max-width: 85%; border-radius: 12px; margin: 20px 0; }
        .form-container { background: #fff; padding: 25px; border-radius: 10px; color: #333; margin-top: 50px; }
        .ulasan-card { background: #fff; color: #000; padding: 15px; margin-bottom: 15px; border-radius: 10px; }
        .rating { color: #ffb300; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Wisata Tidak Ditemukan') ?></h2>
        <?php if (!empty($wisata['gambar_wisata'])): ?>
            <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata']) ?>" class="gambar-wisata">
        <?php endif; ?>
        <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata'] ?? '') ?></p>
        <p><?= nl2br(htmlspecialchars($wisata['deskripsi_wisata'] ?? '')) ?></p>
    </div>

    <div class="right-column">
        <div class="form-container">
            <h3>Tambah Ulasan</h3>
            <form method="POST">
                <input type="hidden" name="action" value="tambah">
                <label>Nama:</label><br><input type="text" name="nama" required style="width:100%"><br>
                <label>Rating (1-5):</label><br><input type="number" name="rating" min="1" max="5" value="5" required style="width:100%"><br>
                <label>Komentar:</label><br><textarea name="komentar" required style="width:100%"></textarea><br>
                <button type="submit">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>

<h3>Ulasan Pengunjung</h3>
<?php if (mysqli_num_rows($resultUlasan) > 0): ?>
    <?php while($ulasan = mysqli_fetch_assoc($resultUlasan)): ?>
        <div class="ulasan-card">
            <p><strong><?= htmlspecialchars($ulasan['nama_user']) ?></strong> - <span class="rating"><?= $ulasan['rating'] ?>/5</span></p>
            <p><?= nl2br(htmlspecialchars($ulasan['komentar_ulasan'])) ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Belum ada ulasan untuk wisata ini.</p>
<?php endif; ?>

</body>
</html>