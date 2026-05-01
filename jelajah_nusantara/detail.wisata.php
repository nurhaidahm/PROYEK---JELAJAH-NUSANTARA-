<?php
include 'db.php';

// Ambil ID wisata dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil detail wisata
$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

// Ambil ulasan terkait wisata ini
$queryUlasan = "
    SELECT u.id_ulasan, u.nama_user, u.komentar_ulasan, u.rating, u.tanggal
    FROM ulasan u
    WHERE u.id_wisata = $id
    ORDER BY u.tanggal DESC
";
$resultUlasan = mysqli_query($conn, $queryUlasan);

// Proses form tambah/edit/hapus ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'tambah') {
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $rating = (int)$_POST['rating'];
            $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
            $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
                      VALUES ($id, '$nama', '$komentar', $rating, NOW())";
            mysqli_query($conn, $query);
            
        } elseif ($action === 'edit') {
            $id_ulasan = (int)$_POST['id_ulasan'];
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $rating = (int)$_POST['rating'];
            $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
            $query = "UPDATE ulasan SET 
                      nama_user = '$nama',
                      komentar_ulasan = '$komentar',
                      rating = $rating
                      WHERE id_ulasan = $id_ulasan";
            mysqli_query($conn, $query);
            
        } elseif ($action === 'hapus') {
            $id_ulasan = (int)$_POST['id_ulasan'];
            $query = "DELETE FROM ulasan WHERE id_ulasan = $id_ulasan";
            mysqli_query($conn, $query);
        }

        // Hindari resubmission
        header("Location: detail_wisata.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata']) ?> - Detail Wisata</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .ulasan-card {
            border: 1px solid #ccc; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px;
        }
        .rating { color: #ffc107; font-weight: bold; }
        .action-buttons { margin-top: 10px; }
        .form-container { 
            background: #f5f5f5; 
            padding: 20px; 
            border-radius: 5px; 
            margin-bottom: 20px;
        }
        .form-container h3 { margin-top: 0; }
        .star-rating { font-size: 24px; }
        .star-rating span { cursor: pointer; }
    </style>
</head>
<body>

<h2><?= htmlspecialchars($wisata['nama_wisata']) ?></h2>
<p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata']) ?></p>
<p><?= htmlspecialchars($wisata['deskripsi_wisata']) ?></p>

<hr>
<h3>Ulasan Pengunjung</h3>

<div class="form-container">
    <h3><?= isset($_GET['edit']) ? 'Edit Ulasan' : 'Tambah Ulasan' ?></h3>
    <form method="POST">
        <input type="hidden" name="action" value="<?= isset($_GET['edit']) ? 'edit' : 'tambah' ?>">
        
        <?php if (isset($_GET['edit'])): ?>
            <?php 
                $edit_id = (int)$_GET['edit'];
                $queryEdit = "SELECT * FROM ulasan WHERE id_ulasan = $edit_id";
                $resultEdit = mysqli_query($conn, $queryEdit);
                $editData = mysqli_fetch_assoc($resultEdit);
            ?>
            <input type="hidden" name="id_ulasan" value="<?= $edit_id ?>">
        <?php endif; ?>
        
        <div>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required 
                   value="<?= isset($editData) ? htmlspecialchars($editData['nama_user']) : '' ?>">
        </div>
        
        <div style="margin: 10px 0;">
            <label>Rating:</label><br>
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span onclick="setRating(<?= $i ?>)" 
                          style="<?= (isset($editData) && $editData['rating'] >= $i) || (!isset($editData) && $i == 5) ? 'color: #ffc107;' : 'color: #ccc;' ?>">
                        ★
                    </span>
                <?php endfor; ?>
                <input type="hidden" id="rating" name="rating" 
                       value="<?= isset($editData) ? $editData['rating'] : 5 ?>">
            </div>
        </div>
        
        <div>
            <label for="komentar">Komentar:</label><br>
            <textarea id="komentar" name="komentar" rows="4" required><?= isset($editData) ? htmlspecialchars($editData['komentar_ulasan']) : '' ?></textarea>
        </div>
        
        <button type="submit"><?= isset($_GET['edit']) ? 'Update Ulasan' : 'Kirim Ulasan' ?></button>
        
        <?php if (isset($_GET['edit'])): ?>
            <a href="detail_wisata.php?id=<?= $id ?>">Batal</a>
        <?php endif; ?>
    </form>
</div>

<!-- Daftar Ulasan -->
<?php if (mysqli_num_rows($resultUlasan) > 0): ?>
    <?php while($ulasan = mysqli_fetch_assoc($resultUlasan)): ?>
        <div class="ulasan-card">
            <p><strong><?= htmlspecialchars($ulasan['nama_user']) ?></strong> 
               - <span class="rating"><?= str_repeat('★', $ulasan['rating']) . str_repeat('☆', 5 - $ulasan['rating']) ?></span>
               (<?= $ulasan['rating'] ?>/5)</p>
            <p><?= nl2br(htmlspecialchars($ulasan['komentar_ulasan'])) ?></p>
            <small><?= date('d M Y, H:i', strtotime($ulasan['tanggal'])) ?></small>
            
            <div class="action-buttons">
                <a href="detail_wisata.php?id=<?= $id ?>&edit=<?= $ulasan['id_ulasan'] ?>">Edit</a> | 
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="id_ulasan" value="<?= $ulasan['id_ulasan'] ?>">
                    <button type="submit" style="background: none; border: none; color: #0066cc; cursor: pointer; padding: 0;">Hapus</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Belum ada ulasan untuk wisata ini.</p>
<?php endif; ?>

<script>
    function setRating(rating) {
        document.getElementById('rating').value = rating;
        const stars = document.querySelectorAll('.star-rating span');
        stars.forEach((star, index) => {
            star.style.color = index < rating ? '#ffc107' : '#ccc';
        });
    }
</script>

</body>
</html>
