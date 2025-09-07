<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

// Logika untuk mengupdate stok
// ...

// Tampilkan tabel produk dengan form update stok
?>
<div class="container mt-5">
    <h2>Update Stok Barang</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Stok Saat Ini</th>
                <th>Tambah Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query_stok = "SELECT * FROM produk";
            $result_stok = mysqli_query($koneksi, $query_stok);
            while($row = mysqli_fetch_assoc($result_stok)): ?>
            <tr>
                <form action="../proses/proses_stok.php" method="POST">
                <td><?= $row['NamaProduk']; ?></td>
                <td><?= $row['Stok']; ?></td>
                <td><input type="number" name="tambah_stok" min="0"></td>
                <input type="hidden" name="id_produk" value="<?= $row['ProdukID']; ?>">
                <td><button type="submit" class="btn btn-sm btn-primary">Update</button></td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>