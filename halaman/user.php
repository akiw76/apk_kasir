<?php
include '../fungsi/autentikasi.php';
cekLogin();
if ($_SESSION['Level'] != 'administrator') {
    header('Location: dashboard.php');
    exit;
}
include '../config/koneksi.php';

// Ambil data user dari database
$query = "SELECT UserID, Username, Level FROM user";
$result = mysqli_query($koneksi, $query);

include '../template/header.php';
?>

<div class="container my-4">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-people-fill me-2"></i> Manajemen User
        </h2>
        <div>
            <a href="dashboard.php" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="tambah_user.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah User
            </a>
        </div>
    </div>

    <!-- Alert Pesan -->
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> Data user berhasil disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit_sukses'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-pencil-square me-2"></i> Data user berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus_sukses'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-trash me-2"></i> Data user berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Card Tabel User -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Username</th>
                            <th scope="col">Level</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-semibold"><?= $row['Username']; ?></td>
                            <td>
                                <span class="badge bg-<?= $row['Level'] == 'administrator' ? 'danger' : 'info'; ?>">
                                    <?= ucfirst($row['Level']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="edit_user.php?id=<?= $row['UserID']; ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="../proses/proses_hapus_user.php?id=<?= $row['UserID']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>
