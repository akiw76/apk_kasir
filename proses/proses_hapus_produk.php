<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $query = "DELETE FROM produk WHERE ProdukID = $id_produk";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../halaman/produk.php?pesan=hapus_sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    header('Location: ../halaman/produk.php');
}
?>