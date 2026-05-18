<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

$queryUlasan = "
    SELECT u.id_ulasan, u.nama_user, u.komentar_ulasan, u.rating, u.tanggal
    FROM ulasan u
    WHERE u.id_wisata = $id
    ORDER BY u.tanggal DESC
";
$resultUlasan = mysqli_query($conn, $queryUlasan);

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

        header("Location: detail.php?id=$id&success=tambah");

        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($wisata['nama_wisata']) ?> - Detail Wisata</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: rgb(13, 94, 90);
        padding: 20px;
        margin: 0;
    }

    h2, h3, p {
        color:rgb(255, 255, 255);
    }
    
    .container {
        display: flex;
        gap: 40px;
        align-items: flex-start;
        margin-bottom: 40px;
    }

    .left-column {
        flex: 1;
    }

    .right-column {
        flex: 1;
    }

    .gambar-wisata {
        max-width: 85%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin: 40px 0;
    }

    .form-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 10px;
        border: 2px solid #b2dfdb;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;

        /* Ini bagian penting agar form sejajar dengan gambar */
        margin-top: 100px;
    }

    .form-container h3 {
        margin-top: 0;
        color: #00695c;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #b2dfdb;
        border-radius: 6px;
        background-color: #f0fdfa;
        font-size: 14px;
    }

    button[type="submit"] {
        background-color: #b2dfdb;
        border: none;
        color: #004d40;
        padding: 10px 16px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    button[type="submit"]:hover {
        background-color: #80cbc4;
    }

    .form-container a {
        color: #666;
        font-size: 14px;
        margin-left: 50px;
        text-decoration: none;
    }

    .form-container a:hover {
        text-decoration: underline;
    }

    .star-rating {
        font-size: 24px;
    }

    .star-rating span {
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .ulasan-card {
        border: 1px solid #b2dfdb;
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .ulasan-card p {
        color: black;
    }

    .ulasan-card strong {
        color: black;
    }
    .rating {
        color: #ffb300;
        font-weight: bold;
        font-size: 16px;
    }
    </style>
</head>

<body>
    

<div class="container">
    <div class="left-column">
        <h2><?= htmlspecialchars($wisata['nama_wisata']) ?></h2>

        <div class="gambar-wisata-container">
            <img src="gambar/<?= htmlspecialchars($wisata['gambar_wisata']) ?>" 
                 alt="Foto <?= htmlspecialchars($wisata['nama_wisata']) ?>" 
                 class="gambar-wisata">
        </div>

        <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi_wisata']) ?></p>
        <p><?= htmlspecialchars($wisata['deskripsi_wisata']) ?></p>
    </div>

    <div class="right-column">
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

                <button type="submit"><?= isset($_GET['edit']) ? 'Update Ulasan' : 'Masukkan Ulasan' ?></button>

                <?php if (isset($_GET['edit'])): ?>
                    <a href="detail.php?id=<?= $id ?>">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<h3>Ulasan Pengunjung</h3>

<?php if (mysqli_num_rows($resultUlasan) > 0): ?>
    <?php while($ulasan = mysqli_fetch_assoc($resultUlasan)): ?>
        <div class="ulasan-card">
            <p><strong><?= htmlspecialchars($ulasan['nama_user']) ?></strong> 
               - <span class="rating"><?= str_repeat('★', $ulasan['rating']) . str_repeat('☆', 5 - $ulasan['rating']) ?></span>
               (<?= $ulasan['rating'] ?>/5)</p>
            <p><?= nl2br(htmlspecialchars($ulasan['komentar_ulasan'])) ?></p>
            <small><?= date('d M Y, H:i', strtotime($ulasan['tanggal'])) ?></small>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="color:white;">Belum ada ulasan untuk wisata ini.</p>
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
