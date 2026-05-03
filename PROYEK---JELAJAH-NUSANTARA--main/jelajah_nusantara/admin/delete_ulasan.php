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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Hapus ulasan dari database
$query = "DELETE FROM ulasan WHERE id_ulasan = $id";
mysqli_query($conn, $query);

header("Location: manage_ulasan.php");
exit();
?>