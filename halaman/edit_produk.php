<?php
include '../fungsi/autentikasi.php';
cekLogin();
if ($_SESSION['Level'] != 'administrator') {
    header('Location: produk.php');
    exit;
}
include '../config/koneksi.php';

// Ambil data produk berdasarkan ID
$id_produk = $_GET['id'];
$query = "SELECT * FROM produk WHERE ProdukID = $id_produk";
$result = mysqli_query($koneksi, $query);
$data_produk = mysqli_fetch_assoc($result);

include '../template/header.php';
?>

<h2>Edit Produk</h2>
<div class="row">
    <div class="col-md-6">
        <form action="../proses/proses_edit_produk.php" method="POST">
            <input type="hidden" name="id" value="<?= $data_produk['ProdukID']; ?>">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $data_produk['NamaProduk']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= $data_produk['Harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?= $data_produk['Stok']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="produk.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
