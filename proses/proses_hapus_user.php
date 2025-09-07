<?php
include '../fungsi/autentikasi.php';
cekLogin();

// Cek apakah user admin
if ($_SESSION['Level'] != 'administrator') {
    header('Location: ../halaman/dashboard.php');
    exit;
}

include '../config/koneksi.php';

// Validasi ID User
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_user = intval($_GET['id']);

    // Hindari admin menghapus dirinya sendiri
    if ($id_user == $_SESSION['UserID']) {
        header("Location: ../halaman/user.php?pesan=error_self_delete");
        exit;
    }

    // Hapus user dari database
    $query = "DELETE FROM user WHERE UserID = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_user);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../halaman/user.php?pesan=hapus_sukses");
    } else {
        header("Location: ../halaman/user.php?pesan=hapus_gagal");
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: ../halaman/user.php?pesan=invalid_id");
}
exit;
