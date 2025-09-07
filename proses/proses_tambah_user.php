<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hashing password
    $level = $_POST['level'];

    $query = "INSERT INTO user (Username, Password, Level) VALUES ('$username', '$password', '$level')";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../halaman/user.php?pesan=sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    header('Location: ../halaman/user.php');
}
?>