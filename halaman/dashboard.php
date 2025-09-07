<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

// Mendapatkan Jumlah Produk
$query_produk = "SELECT COUNT(*) AS total_produk FROM produk";
$result_produk = mysqli_query($koneksi, $query_produk);
$data_produk = mysqli_fetch_assoc($result_produk);
$total_produk = $data_produk['total_produk'];

// Mendapatkan Total Transaksi Hari Ini
$tanggal_hari_ini = date("Y-m-d");
$query_penjualan = "SELECT SUM(TotalHarga) AS total_penjualan FROM penjualan WHERE TanggalPenjualan = '$tanggal_hari_ini'";
$result_penjualan = mysqli_query($koneksi, $query_penjualan);
$data_penjualan = mysqli_fetch_assoc($result_penjualan);
$total_penjualan = $data_penjualan['total_penjualan'];

// Jika null ubah jadi 0
if ($total_penjualan === null) {
    $total_penjualan = 0;
}

include '../template/header.php';
?>

<!-- CSS -->
<style>
.text-gradient {
    background: linear-gradient(45deg, #4e73df, #1cc88a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.card-stat {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>

<div class="container-fluid px-4">
    <!-- Header Welcome -->
    <div class="card shadow-sm mb-4 border-0 rounded-4 bg-light">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1 text-gradient">Halo, <?= $_SESSION['Username']; ?> 👋</h3>
                <p class="text-muted mb-2">Anda login sebagai 
                    <span class="badge bg-primary"><?= $_SESSION['Level']; ?></span>
                </p>
                <a href="../proses/proses_logout.php" class="btn btn-sm btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
            <i class="bi bi-person-circle fs-1 text-primary"></i>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row">
        <!-- Jumlah Produk -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 card-stat">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Jumlah Produk</h6>
                            <h2 class="fw-bold"><?= $total_produk; ?></h2>
                            <a href="produk.php" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                        </div>
                        <div class="icon bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:70px; height:70px;">
                            <i class="bi bi-box-seam fs-2"></i>
                        </div>
                    </div>
                    <i class="bi position-absolute text-primary opacity-25" style="font-size:90px; bottom:-10px; right:-10px;"></i>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 card-stat">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Transaksi Hari Ini</h6>
                            <h2 class="fw-bold">Rp <?= number_format($total_penjualan, 0, ',', '.'); ?></h2>
                            <a href="laporan_penjualan_harian.php" class="btn btn-sm btn-outline-success mt-2">Lihat Detail</a>
                        </div>
                        <div class="icon bg-success text-white rounded-circle d-flex justify-content-center align-items-center" style="width:70px; height:70px;">
                            <i class="bi bi-cash-stack fs-2"></i>
                        </div>
                    </div>
                    <i class="bi position-absolute text-success opacity-25" style="font-size:90px; bottom:-10px; right:-10px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../template/footer.php';
?>
