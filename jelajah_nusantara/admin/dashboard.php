<?php
session_start();
include '../db.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginregister.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Query untuk mengambil semua wisata
$queryWisata = "SELECT * FROM wisata ORDER BY id_wisata DESC";
$resultWisata = mysqli_query($conn, $queryWisata);

// Query untuk mengambil semua ulasan
$queryUlasan = "SELECT u.*, w.nama_wisata 
                FROM ulasan u 
                JOIN wisata w ON u.id_wisata = w.id_wisata 
                ORDER BY u.tanggal DESC";
$resultUlasan = mysqli_query($conn, $queryUlasan);

// Query untuk menghitung jumlah data
$queryCount = "SELECT 
                (SELECT COUNT(*) FROM wisata) as total_wisata,
                (SELECT COUNT(*) FROM ulasan) as total_ulasan,
                (SELECT COUNT(*) FROM users) as total_users";
$resultCount = mysqli_query($conn, $queryCount);
$countData = mysqli_fetch_assoc($resultCount);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard JELAJAH NUSANTARA</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #159c8c;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
        }
        .sidebar a.active {
            background-color: #1abc9c;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin-top: 0;
            color: #159c8c;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #159c8c;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .edit-btn {
            background-color: #3498db;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        .add-btn {
            background-color: #2ecc71;
            color: white;
            padding: 10px 15px;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 style="padding: 0 20px; margin-bottom: 30px;">Admin Panel</h2>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="manage_wisata.php">Kelola Wisata</a>
        <a href="manage_ulasan.php">Kelola Ulasan</a>
        <a href="manage_users.php">Kelola User</a>
        <a href="../logout.php" style="margin-top: 50px; color: #e74c3c;">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Admin</h2>
            <div>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Wisata</h3>
                <p><?= $countData['total_wisata'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Ulasan</h3>
                <p><?= $countData['total_ulasan'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Total User</h3>
                <p><?= $countData['total_users'] ?></p>
            </div>
        </div>

        <div class="card">
            <h3>Wisata Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Wisata</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($resultWisata)): ?>
                    <tr>
                        <td><?= $row['id_wisata'] ?></td>
                        <td><?= htmlspecialchars($row['nama_wisata']) ?></td>
                        <td><?= htmlspecialchars($row['lokasi_wisata']) ?></td>
                        <td>
                            <a href="edit_wisata.php?id=<?= $row['id_wisata'] ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_wisata.php?id=<?= $row['id_wisata'] ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Ulasan Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Wisata</th>
                        <th>Nama User</th>
                        <th>Rating</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($resultUlasan)): ?>
                    <tr>
                        <td><?= $row['id_ulasan'] ?></td>
                        <td><?= htmlspecialchars($row['nama_wisata']) ?></td>
                        <td><?= htmlspecialchars($row['nama_user']) ?></td>
                        <td><?= $row['rating'] ?>/5</td>
                        <td><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <a href="edit_ulasan.php?id=<?= $row['id_ulasan'] ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_ulasan.php?id=<?= $row['id_ulasan'] ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>