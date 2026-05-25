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
            box-shadow: 0 4px 12px rgba(26, 188, 156, 0.15);
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

<div id="status-network" style="position: fixed; bottom: 20px; left: 20px; background: #1abc9c; color: white; padding: 10px 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: bold; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 99999; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;">
  <span id="status-dot" style="width: 8px; height: 8px; background: white; border-radius: 50%; display: inline-block; animation: status-pulse 1.5s infinite ease-in-out;"></span>
  <span id="status-text">Koneksi: Online (Hash: <?php echo htmlspecialchars(trim(shell_exec('git rev-parse --short HEAD') ?? 'N/A')); ?>)</span>
</div>

<style>
@keyframes status-pulse {
  0% { transform: scale(0.95); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 1; }
  100% { transform: scale(0.95); opacity: 0.5; }
}
</style>

<script>
function updateNetworkStatus() {
  const statusContainer = document.getElementById('status-network');
  const statusText = document.getElementById('status-text');
  const currentHash = <?php echo json_encode(trim(shell_exec('git rev-parse --short HEAD') ?? 'N/A')); ?>;

  if (navigator.onLine) {
    statusContainer.style.background = '#1abc9c';
    statusText.innerText = 'Koneksi: Online (Hash: ' + currentHash + ')';
  } else {
    statusContainer.style.background = '#e74c3c';
    statusText.innerText = 'Koneksi: Offline';
  }
}

window.addEventListener('online', updateNetworkStatus);
window.addEventListener('offline', updateNetworkStatus);
</script>

</body>
</html>