<?php
session_start();
include '../db.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginregister.php");
    exit();
}

// Query untuk mengambil semua ulasan + nama wisata
$query = "SELECT u.*, w.nama_wisata 
          FROM ulasan u 
          JOIN wisata w ON u.id_wisata = w.id_wisata 
          ORDER BY u.tanggal DESC";
$result = mysqli_query($conn, $query);

// Cek jika query gagal
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Ulasan</title>
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
        .sidebar a:hover, .sidebar a.active {
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        }
        .edit-btn {
            background-color: #3498db;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="padding: 0 20px; margin-bottom: 30px;">Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_wisata.php">Kelola Wisata</a>
    <a href="manage_ulasan.php" class="active">Kelola Ulasan</a>
    <a href="manage_users.php">Kelola User</a>
    <a href="../logout.php" style="margin-top: 50px; color: #e74c3c;">Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h2>Kelola Ulasan Pengunjung</h2>
        <div>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</div>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Wisata</th>
                    <th>Nama User</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_wisata']) ?></td>
                        <td><?= htmlspecialchars($row['nama_user']) ?></td>
                        <td><?= $row['rating'] ?>/5</td>
                        <td><?= nl2br(htmlspecialchars(substr($row['komentar_ulasan'], 0, 50))) ?>...</td>
                        <td><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <a href="edit_ulasan.php?id=<?= $row['id_ulasan'] ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_ulasan.php?id=<?= $row['id_ulasan'] ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
