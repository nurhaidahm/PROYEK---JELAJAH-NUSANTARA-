<?php
include 'db.php';

// Ambil ID dari URL parameter (?id=XX)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query ambil data objek wisata berdasarkan ID
$queryWisata = "SELECT * FROM wisata WHERE id_wisata = $id";
$resultWisata = mysqli_query($conn, $queryWisata);
$wisata = mysqli_fetch_assoc($resultWisata);

// Jika data wisata tidak ditemukan di database, alihkan ke index.php
if (!$wisata) {
    header("Location: index.php");
    exit();
}

// Query ambil daftar ulasan khusus untuk objek wisata ini
$queryUlasan = "
    SELECT u.id_ulasan, u.nama_user, u.komentar_ulasan, u.rating, u.tanggal
    FROM ulasan u
    WHERE u.id_wisata = $id
    ORDER BY u.tanggal DESC
";
$resultUlasan = mysqli_query($conn, $queryUlasan);
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
        color: rgb(255, 255, 255);
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
        box-sizing: border-box; /* Agar padding tidak merusak lebar */
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

    .star-rating {
        font-size: 24px;
        margin-bottom: 10px;
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
        margin: 5px 0;
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
            <h3>Tambah Ulasan</h3>
            <form method="POST" action="submit_review.php?id=<?= $id ?>">
                <div>
                    <label for="nama" style="color: #004d40; font-weight: bold;">Nama:</label><br>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div style="margin: 10px 0;">
                    <label style="color: #004d40; font-weight: bold;">Rating:</label><br>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span onclick="setRating(<?= $i ?>)" style="color: #ffc107;">★</span>
                        <?php endfor; ?>
                        <input type="hidden" id="rating" name="rating" value="5">
                    </div>
                </div>

                <div>
                    <label for="komentar" style="color: #004d40; font-weight: bold;">Komentar:</label><br>
                    <textarea id="komentar" name="komentar" rows="4" required></textarea>
                </div>

                <button type="submit">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>

<h3>Ulasan Pengunjung</h3>

<?php if (mysqli_num_rows($resultUlasan) > 0): ?>
    <?php while($ulasan = mysqli_fetch_assoc($resultUlasan)): ?>
        <div class="ulasan-card">
            <p>
                <strong><?= htmlspecialchars($ulasan['nama_user']) ?></strong> 
                - <span class="rating"><?= str_repeat('★', $ulasan['rating']) . str_repeat('☆', 5 - $ulasan['rating']) ?></span>
                (<?= $ulasan['rating'] ?>/5)
            </p>
            <p><?= nl2br(htmlspecialchars($ulasan['komentar_ulasan'])) ?></p>
            <small style="color: #666;"><?= date('d M Y, H:i', strtotime($ulasan['tanggal'])) ?></small>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="color:white;">Belum ada ulasan untuk wisata ini.</p>
<?php endif; ?>

<script>
    // Fungsi JavaScript untuk memilih jumlah bintang rating
    function setRating(rating) {
        document.getElementById('rating').value = rating;
        const stars = document.querySelectorAll('.star-rating span');
        stars.forEach((star, index) => {
            star.style.color = index < rating ? '#ffc107' : '#ccc';
        });
    }

    // Fungsi Pop-up Notifikasi Sukses
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'tambah') {
            alert('Terima kasih! Ulasan berhasil ditambahkan.');
            
            // Bersihkan parameter 'success' dari URL agar pop-up tidak muncul lagi saat di-refresh
            window.history.replaceState({}, document.title, "detail.php?id=" + urlParams.get('id'));
        }
    }
</script>

</body>
</html>