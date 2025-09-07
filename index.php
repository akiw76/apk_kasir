<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Aplikasi Kasir</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url('image/bg.jpeg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    /* overlay hitam */
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }
    .login-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.3);
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 1;
    }
    .login-logo {
      width: 80px;
      height: 80px;
      margin: 0 auto 1rem;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f8f9fc;
      border-radius: 50%;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .login-logo i {
      font-size: 4rem;
      color: #4e73df;
    }
    .form-control {
      border-radius: 10px;
      padding-left: 40px;
    }
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
    }
    .btn-login {
      border-radius: 10px;
      font-weight: 600;
      padding: 0.7rem;
    }
    
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-logo">
      <i class="bi bi-shop"></i>
    </div>
    <h4 class="text-center mb-2 fw-bold">Login</h4>
    <form action="proses/proses_login.php" method="POST">
      <div class="mb-3 position-relative">
        <i class="bi bi-person input-icon"></i>
        <input type="text" class="form-control" name="username" placeholder="Username" required>
      </div>
      <div class="mb-3 position-relative">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100 btn-login">Login</button>
    </form>
  </div>
</body>
</html>
