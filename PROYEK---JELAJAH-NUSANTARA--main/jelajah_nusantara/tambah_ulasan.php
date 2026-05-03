<?php
session_start();
require 'db.php';

$id_wisata = $_POST['id_wisata'];
$nama_user = $_SESSION['nama_user'];
$komentar = $_POST['komentar'];
$rating = $_POST['rating'];
$tanggal = date('Y-m-d H:i:s');

$query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal)
          VALUES ('$id_wisata', '$nama_user', '$komentar', '$rating', '$tanggal')";
mysqli_query($conn, $query);

header("Location: detail.php?id=$id_wisata");
exit;
