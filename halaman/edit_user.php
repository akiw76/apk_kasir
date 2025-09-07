<?php
include '../fungsi/autentikasi.php';
cekLogin();
if ($_SESSION['Level'] != 'administrator') {
    header('Location: user.php');
    exit;
}
include '../config/koneksi.php';

$id_user = $_GET['id'];
$query = "SELECT UserID, Username, Level FROM user WHERE UserID = $id_user";
$result = mysqli_query($koneksi, $query);
$data_user = mysqli_fetch_assoc($result);

include '../template/header.php';
?>

<h2>Edit User</h2>
<div class="row">
    <div class="col-md-6">
        <form action="../proses/proses_edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?= $data_user['UserID']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $data_user['Username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required>
                    <option value="administrator" <?= ($data_user['Level'] == 'administrator') ? 'selected' : ''; ?>>Administrator</option>
                    <option value="petugas" <?= ($data_user['Level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="user.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
