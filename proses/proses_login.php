<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hindari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    $query = "SELECT * FROM user WHERE Username='$username' AND Password='$password'"; // CATATAN: Ini tidak aman, akan diperbaiki di tahap selanjutnya
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['Username'] = $data['Username'];
        $_SESSION['Level'] = $data['Level'];
        
        // Arahkan ke dashboard berdasarkan level
        header("Location: ../halaman/dashboard.php");
        exit();
    } else {
        echo "Username atau password salah!";
    }
}
?>