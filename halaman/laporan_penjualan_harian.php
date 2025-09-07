<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

$tanggal_hari_ini = date("Y-m-d");

// Mengambil data transaksi penjualan untuk hari ini
$query_penjualan = "SELECT 
                        p.PenjualanID,
                        p.TanggalPenjualan,
                        p.TotalHarga,
                        pl.NamaPelanggan,
                        u.Username AS NamaPetugas
                    FROM penjualan p
                    JOIN pelanggan pl ON p.PelangganID = pl.PelangganID
                    JOIN user u ON p.UserID = u.UserID
                    WHERE p.TanggalPenjualan = '$tanggal_hari_ini'";
$result_penjualan = mysqli_query($koneksi, $query_penjualan);

include '../template/header.php';
?>

<h2>Laporan Transaksi Penjualan Hari Ini (<?= $tanggal_hari_ini; ?>)</h2>
<a href="penjualan.php" class="btn btn-primary mb-3">Buat Transaksi Baru</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Petugas</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_penjualan) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result_penjualan)): ?>
                <tr>
                    <td><?= $row['PenjualanID']; ?></td>
                    <td><?= $row['TanggalPenjualan']; ?></td>
                    <td><?= $row['NamaPelanggan']; ?></td>
                    <td><?= $row['NamaPetugas']; ?></td>
                    <td>Rp <?= number_format($row['TotalHarga'], 0, ',', '.'); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info detail-btn" data-id="<?= $row['PenjualanID']; ?>">Lihat Detail</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi hari ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-body-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
include '../template/footer.php';
?>
<script>
$(document).ready(function(){
    $('.detail-btn').click(function(){
        var penjualanID = $(this).data('id');
        $.ajax({
            url: '../proses/get_detail_penjualan.php',
            type: 'GET',
            data: { id: penjualanID },
            success: function(response){
                $('#modal-body-content').html(response);
                $('#detailModal').modal('show');
            }
        });
    });
});
</script>