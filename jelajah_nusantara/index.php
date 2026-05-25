<?php
include 'db.php';

// Ambil semua data wisata
$query = "SELECT * FROM wisata";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beranda - Review Wisata</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e0f7f5;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .login-admin {
            background-color: #ffffff;
            border: 2px solid #1abc9c;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: #1abc9c;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-admin:hover {
            background-color: #1abc9c;
            color: white;
        }

        h1 {
            text-align: center;
            color: #159c8c;
            margin-bottom: 30px;
        }

        .search-box {
            display: flex;
            justify-content: center;
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
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #159c8c;
        }

        .card-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(48%, 1fr));
            gap: 20px;
        }

        .wisata-card {
            background: white;
            border: 1px solid #b2dfdb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12 rgba(26, 188, 156, 0.15);
            transition: transform 0.2s ease-in-out;
        }

        .wisata-card:hover {
            transform: translateY(-5px);
        }

        .gambar {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        h3 {
            margin: 0 0 10px;
            color: #159c8c;
        }

        p {
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
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

        hr {
            border: none;
            border-top: 1px solid #b2dfdb;
            margin: 30px 0;
        }

        /* Style Animasi Kedip untuk Indikator Status */
        @keyframes pulse {
            0% { opacity: 0.4; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <a class="login-admin" href="admin/login.php">Login Admin</a>
    </div>

    <h1>Jelajah Nusantara - Review Wisata</h1>

    <form class="search-box" method="GET" action="search.php">
        <input type="text" name="q" placeholder="Cari wisata...">
        <button type="submit">Search</button>
    </form>

    <hr>

    <div class="card-wrapper">
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
</div>

<div id="status-network" style="position: fixed; bottom: 20px; left: 20px; padding: 10px 18px; background: #1abc9c; color: white; border-radius: 30px; font-weight: bold; font-size: 14px; font-family: sans-serif; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;">
  <span id="status-dot" style="height: 10px; width: 10px; background-color: #ffffff; border-radius: 50%; display: inline-block; animation: pulse 1s infinite alternate;"></span>
  <span id="status-text">Koneksi: Online</span>
</div>

<script>
  function updateOnlineStatus() {
    const statusDiv = document.getElementById('status-network');
    const statusText = document.getElementById('status-text');
    
    if (navigator.onLine) {
      statusText.innerHTML = "Koneksi: Online";
      statusDiv.style.background = "#1abc9c"; // Hijau tosca bawaan tema kalian
    } else {
      statusText.innerHTML = "Koneksi: Offline";
      statusDiv.style.background = "#e74c3c"; // Merah tanda putus koneksi
    }
  }

  // Mengintai perubahan status jaringan secara real-time
  window.addEventListener('online', updateOnlineStatus);
  window.addEventListener('offline', updateOnlineStatus);

  // Jalankan fungsi sekali saat halaman selesai dimuat
  document.addEventListener("DOMContentLoaded", updateOnlineStatus);
</script>
</body>
</html>