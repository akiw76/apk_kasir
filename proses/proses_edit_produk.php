<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $query = "UPDATE produk SET NamaProduk = '$nama_produk', Harga = '$harga', Stok = '$stok' WHERE ProdukID = $id_produk";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../halaman/produk.php?pesan=edit_sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    header('Location: ../halaman/produk.php');
}
?>
