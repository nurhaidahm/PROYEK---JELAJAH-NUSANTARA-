<?php
// search.php
include 'db.php'; // Pastikan file ini berada di lokasi yang benar

$keyword = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// Ambil data wisata berdasarkan keyword pencarian
$query = "SELECT * FROM wisata WHERE nama_wisata LIKE '%$keyword%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pencarian - Review Wisata</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #e0f7f5;
        padding: 30px;
        margin: 0;
    }

    h2 {
        color: #159c8c;
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        text-align: center;
        margin-bottom: 30px;
    }

    input[type="text"] {
        padding: 10px;
        width: 280px;
        border-radius: 8px;
        border: 2px solid #b2dfdb;
        margin-right: 10px;
        font-size: 14px;
    }

    button {
        padding: 10px 15px;
        background-color: #1abc9c;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #159c8c;
    }

    .grid-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .wisata-card {
        background: white;
        border: 1px solid #b2dfdb;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(26, 188, 156, 0.15);
        width: 320px;
        min-height: 350px;
        transition: transform 0.2s ease-in-out;
        text-align: center;
    }

    .wisata-card:hover {
        transform: translateY(-5px);
    }

    .gambar {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    h3 {
        color: #159c8c;
        margin-top: 0;
    }

    a {
        color: #1abc9c;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
    }

    a:hover {
        text-decoration: underline;
    }

    p {
        color: #333;
        font-size: 14px;
        margin-bottom: 10px;
    }

    hr {
        border: none;
        border-top: 1px solid #b2dfdb;
        margin: 30px 0;
    }
    </style>
</head>
<body>

<h2>Hasil Pencarian: <em><?= htmlspecialchars($keyword) ?></em></h2>

<form method="GET" action="search.php">
    <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari wisata...">
    <button type="submit">Search</button>
</form>

<hr>

<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="grid-container">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="wisata-card">
            <?php if (!empty($row['gambar_wisata'])): ?>
                <img src="gambar/<?= htmlspecialchars($row['gambar_wisata']) ?>" class="gambar" alt="Gambar Wisata">
            <?php endif; ?>
            <h3><?= htmlspecialchars($row['nama_wisata']) ?></h3>
            <p><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi_wisata']) ?></p>
            <p><?= substr(htmlspecialchars($row['deskripsi_wisata']), 0, 100) ?>...</p>
            <a href="detail.php?id=<?= $row['id_wisata'] ?>">Lihat Detail</a>
        </div>
    <?php endwhile; ?>
    </div>
<?php else: ?>
    <p style="text-align:center;">Tidak ada hasil ditemukan untuk "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
<?php endif; ?>

</body>
</html>
