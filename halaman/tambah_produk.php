<?php
include '../fungsi/autentikasi.php';
cekLogin();
if ($_SESSION['Level'] != 'administrator') {
    header('Location: produk.php');
    exit;
}
include '../config/koneksi.php';

include '../template/header.php';
?>

<h2>Tambah Produk</h2>
<div class="row">
    <div class="col-md-6">
        <form action="../proses/proses_tambah_produk.php" method="POST">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="produk.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<div class="container my-3">
  <div class="p-3 bg-danger text-white rounded d-flex align-items-center" style="cursor:pointer;" onclick="history.back()">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    <span class="fw-bold">Kembali</span>
  </div>
</div>


<?php include '../template/footer.php'; ?>