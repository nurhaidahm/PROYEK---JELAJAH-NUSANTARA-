<?php
include 'db.php';

// Menangkap parameter ID Wisata dari URL action form
$id_wisata = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input data dari elemen form POST
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $rating = (int)$_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    // Validasi ketat: data wajib terisi dan ID Wisata valid
    if ($id_wisata > 0 && !empty($nama) && !empty($komentar)) {
        
        // Query untuk memasukkan ulasan baru
        $query = "INSERT INTO ulasan (id_wisata, nama_user, komentar_ulasan, rating, tanggal) 
                  VALUES ($id_wisata, '$nama', '$komentar', $rating, NOW())";
        
        if (mysqli_query($conn, $query)) {
            // Jika berhasil, balikkan ke detail.php sesuai ID asalnya dengan tanda sukses=tambah
            header("Location: detail.php?id=$id_wisata&success=tambah");
            exit();
        } else {
            echo "Gagal menyimpan ulasan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Data tidak valid. Pastikan semua kolom form terisi dengan benar.";
    }
} else {
    // Pengamanan apabila file diakses langsung secara ilegal tanpa submit form
    header("Location: index.php");
    exit();
}
?>