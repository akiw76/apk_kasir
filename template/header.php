<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand me-auto" href="../halaman/dashboard.php">Aplikasi Kasir</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../halaman/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../halaman/penjualan.php">Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../halaman/produk.php">Produk</a>
                    </li>
                    <?php if (isset($_SESSION['Level']) && $_SESSION['Level'] == 'petugas'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../halaman/pelanggan.php">Pelanggan</a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['Level']) && $_SESSION['Level'] == 'administrator'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../halaman/user.php">Manajemen User</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <a class="btn btn-outline-light ms-auto d-none d-lg-block" href="../proses/proses_logout.php">Logout</a>
        </div>
    </nav>
    
    <div class="container mt-4">