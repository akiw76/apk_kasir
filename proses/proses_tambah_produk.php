<?php
include '../config/koneksi.php';

// Cek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Query untuk menambahkan produk baru
    $query = "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$nama_produk', '$harga', '$stok')";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../halaman/produk.php?pesan=sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    header('Location: ../halaman/produk.php');
}
?>