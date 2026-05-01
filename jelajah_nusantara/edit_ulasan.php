<?php
include 'db.php';

$id_wisata = $_GET['id'];
$query = "SELECT * FROM ulasan WHERE id_wisata = $id_wisata";
$result = mysqli_query($conn, $query);
$ulasan = mysqli_fetch_assoc($result);
?>

<form method="POST" action="update_ulasan.php">
    <input type="hidden" name="id_ulasan" value="<?= $ulasan['id_ulasan'] ?>">
    <p>
        <label>Nama:</label><br>
        <input type="text" name="nama_user" value="<?= $ulasan['nama_user'] ?>" required>
    </p>
    <p>
        <label>Rating:</label><br>
        <input type="number" name="rating" value="<?= $ulasan['rating'] ?>" min="1" max="5" required>
    </p>
    <p>
        <label>Komentar:</label><br>
        <textarea name="komentar" required><?= $ulasan['komentar_ulasan'] ?></textarea>
    </p>
    <button type="submit">Update</button>
</form>
