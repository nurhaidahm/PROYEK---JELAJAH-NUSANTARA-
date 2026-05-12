<?php
session_start();
include '../db.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username'])) {
    header("Location: ../loginregister.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Proses form tambah wisata
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Upload gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../gambar/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $gambar = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $gambar;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        }
    }
    
    $query = "INSERT INTO wisata (nama_wisata, lokasi_wisata, deskripsi_wisata, gambar_wisata) 
              VALUES ('$nama', '$lokasi', '$deskripsi', '$gambar')";
    mysqli_query($conn, $query);
    
    header("Location: manage_wisata.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Wisata Baru</title>
    <style>
        /* Gunakan style yang sama dengan dashboard.php */
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 150px;
        }
        button {
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #159c8c;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 style="padding: 0 20px; margin-bottom: 30px;">Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_wisata.php" class="active">Kelola Wisata</a>
        <a href="manage_ulasan.php">Kelola Ulasan</a>
        <a href="manage_users.php">Kelola User</a>
        <a href="../logout.php" style="margin-top: 50px; color: #e74c3c;">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Tambah Wisata Baru</h2>
            <div>WELCOME, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</div>
        </div>

        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Wisata</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar Wisata</label>
                    <input type="file" id="gambar" name="gambar">
                </div>
                <button type="submit">Simpan</button>
                <a href="manage_wisata.php" style="margin-left: 10px;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>