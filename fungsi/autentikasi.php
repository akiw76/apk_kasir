<?php
session_start();

function cekLogin() {
    if (!isset($_SESSION['UserID'])) {
        header("Location: ../index.php");
        exit();
    }
}

function cekHakAkses($level) {
    if ($_SESSION['Level'] != $level) {
        // Arahkan ke halaman error atau dashboard jika tidak memiliki hak akses
        header("Location: dashboard.php");
        exit();
    }
}
?>