<?php
include 'db.php';

$id_wisata = $_POST['id_wisataa'];
$nama_user = $_POST['nama_user'];
$komentar = $_POST['komentar'];
$rating = $_POST['rating'];

$query = "UPDATE ulasan SET 
            nama_user = '$nama_user',
            komentar_ulasan = '$komentar',
            rating = '$rating'
          WHERE id_ulasan = $id_ulasan";

if (mysqli_query($conn, $query)) {
    header("Location: detail.php?id=" . $_GET['id']);
    exit;
} else {
    echo "Gagal update: " . mysqli_error($conn);
}
?>
