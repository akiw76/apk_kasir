<?php
include '../fungsi/autentikasi.php';
cekLogin();
if ($_SESSION['Level'] != 'administrator') {
    header('Location: user.php');
    exit;
}
include '../config/koneksi.php';

include '../template/header.php';
?>

<h2>Tambah User</h2>
<div class="row">
    <div class="col-md-6">
        <form action="../proses/proses_tambah_user.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required>
                    <option value="administrator">Administrator</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="user.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
