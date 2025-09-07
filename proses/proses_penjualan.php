<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pelanggan_id = $_POST['pelanggan_id'];
    $total_harga = $_POST['total_harga'];
    $produk_ids = $_POST['produk_id'];
    $jumlahs = $_POST['jumlah'];

    // Validasi dasar
    if (empty($pelanggan_id) || empty($total_harga) || empty($produk_ids)) {
        echo "<script>alert('Data transaksi tidak lengkap!'); window.location.href='../halaman/penjualan.php';</script>";
        exit();
    }

    $tanggal_penjualan = date("Y-m-d");
    $user_id = $_SESSION['UserID'];

    // Mulai transaksi database
    mysqli_begin_transaction($koneksi);
    $sukses = true;

    // 1. Simpan data ke tabel 'penjualan'
    $query_penjualan = "INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID, UserID) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query_penjualan);
    mysqli_stmt_bind_param($stmt, "sddi", $tanggal_penjualan, $total_harga, $pelanggan_id, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        $sukses = false;
    }
    $penjualan_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);

    // 2. Simpan data ke tabel 'detailpenjualan' dan update stok produk
    for ($i = 0; $i < count($produk_ids); $i++) {
        $produk_id = $produk_ids[$i];
        $jumlah = $jumlahs[$i];

        // Ambil harga dan stok produk dari database
        $query_produk = "SELECT Harga, Stok FROM produk WHERE ProdukID = ?";
        $stmt_produk = mysqli_prepare($koneksi, $query_produk);
        mysqli_stmt_bind_param($stmt_produk, "i", $produk_id);
        mysqli_stmt_execute($stmt_produk);
        mysqli_stmt_bind_result($stmt_produk, $harga_produk, $stok_produk);
        mysqli_stmt_fetch($stmt_produk);
        mysqli_stmt_close($stmt_produk);

        // Hitung subtotal
        $subtotal = $harga_produk * $jumlah;

        // Cek apakah stok cukup
        $stok_baru = $stok_produk - $jumlah;
        if ($stok_baru < 0) {
            $sukses = false;
            break; // Keluar dari loop jika stok tidak cukup
        }

        // Simpan detail penjualan
        $query_detail = "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) VALUES (?, ?, ?, ?)";
        $stmt_detail = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "iiid", $penjualan_id, $produk_id, $jumlah, $subtotal);
        if (!mysqli_stmt_execute($stmt_detail)) {
            $sukses = false;
            break;
        }
        mysqli_stmt_close($stmt_detail);

        // Update stok produk
        $query_stok_update = "UPDATE produk SET Stok = ? WHERE ProdukID = ?";
        $stmt_stok = mysqli_prepare($koneksi, $query_stok_update);
        mysqli_stmt_bind_param($stmt_stok, "ii", $stok_baru, $produk_id);
        if (!mysqli_stmt_execute($stmt_stok)) {
            $sukses = false;
            break;
        }
        mysqli_stmt_close($stmt_stok);
    }

    // Commit atau Rollback transaksi
    if ($sukses) {
        mysqli_commit($koneksi);
        echo "<script>alert('Transaksi berhasil disimpan!'); window.location.href='../halaman/penjualan.php';</script>";
    } else {
        mysqli_rollback($koneksi);
        echo "<script>alert('Transaksi gagal. Mungkin stok tidak cukup!'); window.location.href='../halaman/penjualan.php';</script>";
    }
}
?>