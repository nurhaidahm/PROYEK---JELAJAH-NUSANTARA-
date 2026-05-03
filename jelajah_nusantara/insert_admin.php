<?php
include 'db.php'; // koneksi ke database

$username = 'meyla';
$password_plain = 'meyla123';

// Enkripsi password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Simpan ke database
$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password_hashed', 'admin')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Admin berhasil ditambahkan!";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>
