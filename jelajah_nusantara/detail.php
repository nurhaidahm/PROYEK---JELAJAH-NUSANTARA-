<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil Data Wisata
$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

// Proses Aksi (Tambah, Edit, Hapus)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    if ($action === 'tambah') {
        $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
                  VALUES ($id, '$nama', '$komentar', $rating, NOW())";
        mysqli_query($conn, $query);
    } elseif ($action === 'edit') {
        $id_ulasan = (int)$_POST['id_ulasan'];
        $query = "UPDATE ulasan SET nama_user = '$nama', komentar_ulasan = '$komentar', rating = $rating 
                  WHERE id_ulasan = $id_ulasan";
        mysqli_query($conn, $query);
    } elseif ($action === 'hapus') {
        $id_ulasan = (int)$_POST['id_ulasan'];
        $query = "DELETE FROM ulasan WHERE id_ulasan = $id_ulasan";
        mysqli_query($conn, $query);
    }
    
    // Redirect agar tidak double-submit
    header("Location: detail.php?id=$id");
    exit();
}

// Ambil Data Ulasan
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
        .gambar-wisata { max-width: 85%; height: auto; border-radius: 12px; margin: 40px 0; }
        .form-container { background: #ffffff; padding: 25px; border-radius: 10px; border: 2px solid #b2dfdb; margin-top: 100px; }
        .form-container h3 { margin-top: 0; color: #00695c; }
        input[type="text"], textarea { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #b2dfdb; border-radius: 6px; }
        button[type="submit"] { background-color: #b2dfdb; border: none; color: #004d40; padding: 10px 16px; font-weight: bold; border-radius: 6px; cursor: pointer; }
        .star-rating { font-size: 24px; cursor: pointer; color: #ccc; }
        .star-rating span.active { color: #ffc107; }
        .ulasan-card { border: 1px solid #b2dfdb; background-color: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 10px; color: black; }
        .rating { color: #ffb300; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata'] ?? 'Wisata') ?></h2>
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
                <input type="text" name="nama" required>
                <label>Rating:</label>
                <div class="star-rating">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span onclick="setRating(<?= $i ?>)" id="star-<?= $i ?>">★</span>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="5">
                <label>Komentar:</label><br>
                <textarea name="komentar" rows="4" required></textarea>
                <button type="submit">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>

<h3>Ulasan Pengunjung</h3>
<?php while($u = mysqli_fetch_assoc($resultUlasan)): ?>
    <div class="ulasan-card">
        <p><strong><?= htmlspecialchars($u['nama_user']) ?></strong> - 
           <span class="rating"><?= str_repeat('★', $u['rating']) ?></span></p>
        <p><?= htmlspecialchars($u['komentar_ulasan']) ?></p>
    </div>
<?php endwhile; ?>

<script>
    function setRating(r) {
        document.getElementById('ratingInput').value = r;
        for(let i=1; i<=5; i++) {
            document.getElementById('star-'+i).className = (i <= r) ? 'active' : '';
        }
    }
</script>
</body>
</html>