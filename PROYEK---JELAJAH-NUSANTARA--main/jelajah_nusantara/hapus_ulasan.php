<?php
include 'db.php';

$id_ulasan = $_GET['id'];
$id_wisata = $_GET['id_wisata'];

$query = "DELETE FROM ulasan WHERE id_wisata = $id_wisata";
mysqli_query($conn, $query);

header("Location: detail.php?id=$id_wisata");
exit;
?>
