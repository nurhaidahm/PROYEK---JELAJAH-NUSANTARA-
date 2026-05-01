<?php
session_start();
include '../db.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginregister.php");
    exit();
}

// Cek apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cegah admin menghapus dirinya sendiri
    if ($_SESSION['id_user'] == $id) {
        echo "<script>alert('Anda tidak dapat menghapus akun Anda sendiri.'); window.location.href='manage_users.php';</script>";
        exit();
    }

    // Lakukan query delete
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?msg=deleted");
        exit();
    } else {
        echo "Gagal menghapus user: " . mysqli_error($conn);
    }
} else {
    // Redirect jika tidak ada ID
    header("Location: manage_users.php");
    exit();
}
?>
