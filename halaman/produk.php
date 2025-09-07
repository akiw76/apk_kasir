<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

// Ambil kata kunci pencarian dari URL jika ada
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Ambil data produk dengan filter pencarian
$query = "SELECT ProdukID, NamaProduk, Harga, Stok FROM produk";
if (!empty($search_query)) {
    // Tambahkan kondisi WHERE untuk pencarian
    $query .= " WHERE NamaProduk LIKE '%" . mysqli_real_escape_string($koneksi, $search_query) . "%'";
}

$result = mysqli_query($koneksi, $query);

include '../template/header.php';

// Menampilkan pesan sukses atau error jika ada
if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Data produk berhasil disimpan!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit_sukses') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Data produk berhasil diperbarui!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus_sukses') {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data produk berhasil dihapus!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>

<h2 class="fw-bold mb-4 text-primary">
    <i class="bi bi-box-seam me-2"></i> Manajemen Produk
</h2>

<div class="row mb-3 align-items-center">
    <div class="col-md-6 mb-2 mb-md-0">
        <!-- Tombol "Tambah Produk" hanya untuk role 'administrator' -->
        <?php if ($_SESSION['Level'] == 'administrator'): ?>
            <a href="tambah_produk.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Produk
            </a>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <form action="" method="GET" class="d-flex">
            <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari produk..." aria-label="Search" name="search" value="<?= htmlspecialchars($search_query); ?>">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <!-- Kolom "Aksi" hanya untuk role 'administrator' -->
                        <?php if ($_SESSION['Level'] == 'administrator'): ?>
                        <th class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['NamaProduk']; ?></td>
                        <td>Rp <?= number_format($row['Harga'], 0, ',', '.'); ?></td>
                        <td><?= $row['Stok']; ?></td>
                        <?php if ($_SESSION['Level'] == 'administrator'): ?>
                        <td class="text-center">
                            <a href="edit_produk.php?id=<?= $row['ProdukID']; ?>" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="../proses/proses_hapus_produk.php?id=<?= $row['ProdukID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tombol Kembali -->
<div class="mt-4">
  <button onclick="history.back()" class="btn btn-danger d-flex align-items-center shadow-sm">
    <i class="bi bi-arrow-left me-2"></i> Kembali
  </button>
</div>



<?php include '../template/footer.php'; ?>