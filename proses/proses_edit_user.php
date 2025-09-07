<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id'];
    $username = $_POST['username'];
    $level = $_POST['level'];

    $query = "UPDATE user SET Username = '$username', Level = '$level' WHERE UserID = $id_user";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../halaman/user.php?pesan=edit_sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    header('Location: ../halaman/user.php');
}
?>
