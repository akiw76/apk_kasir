<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

// Cek level pengguna
$level_user = $_SESSION['Level'];

// Ambil data pelanggan dari database
$query = "SELECT * FROM pelanggan";
$result = mysqli_query($koneksi, $query);

include '../template/header.php';
?>

<div class="container my-4">
  <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-gradient bg-primary text-white text-center py-3">
      <h3 class="mb-0 fw-bold">👥 Manajemen Pelanggan</h3>
    </div>
    <div class="card-body p-4">

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="dashboard.php" class="btn btn-secondary shadow-sm rounded-3">
          ⬅️ Kembali
        </a>
        <?php if ($level_user == 'petugas'): ?>
          <a href="tambah_pelanggan.php" class="btn btn-primary shadow-sm rounded-3">
            ➕ Tambah Pelanggan
          </a>
        <?php endif; ?>
      </div>

      <!-- Tabel Data Pelanggan -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded-3 overflow-hidden">
          <thead class="table-primary text-center">
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>Alamat</th>
              <th>Nomor Telepon</th>
              <?php if ($level_user == 'petugas'): ?>
              <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while($row = mysqli_fetch_assoc($result)):
              // Jangan tampilkan Pelanggan Umum di daftar
              if ($row['PelangganID'] != 1):
            ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['NamaPelanggan']); ?></td>
              <td><?= htmlspecialchars($row['Alamat']); ?></td>
              <td><?= htmlspecialchars($row['NomorTelepon']); ?></td>
              <?php if ($level_user == 'petugas'): ?>
              <td class="text-center">
                <a href="edit_pelanggan.php?id=<?= $row['PelangganID']; ?>" class="btn btn-warning btn-sm shadow-sm rounded-3 me-1">
                  ✏️ Edit
                </a>
                <a href="../proses/proses_hapus_pelanggan.php?id=<?= $row['PelangganID']; ?>" 
                   class="btn btn-danger btn-sm shadow-sm rounded-3"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
                  🗑️ Hapus
                </a>
              </td>
              <?php endif; ?>
            </tr>
            <?php
              endif;
            endwhile;
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Tombol Back Bawah -->
<div class="container my-3 d-flex justify-content-center">
  <div class="p-3 bg-danger text-white rounded-3 d-flex align-items-center shadow-sm" 
       style="cursor:pointer; max-width:200px;" onclick="history.back()">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 
      3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 
      0-.708l4-4a.5.5 0 1 1 .708.708L3.707 
      7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    <span class="fw-bold">Kembali</span>
  </div>
</div>

<?php include '../template/footer.php'; ?>
