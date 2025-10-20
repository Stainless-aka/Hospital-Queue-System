<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $result = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
  if ($result->num_rows > 0) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Invalid username or password!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login | Hospital Queue</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f5f7fa;
      background-image: url('https://www.transparenttextures.com/patterns/clean-gray-paper.png');
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    .login-card {
      background: #ffffff;
      padding: 2.5rem;
      border-radius: 1rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 420px;
      position: relative;
      animation: fadeIn 0.6s ease-in-out;
      border-top: 5px solid #0d6efd;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-card h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 700;
      color: #0d6efd;
    }

    .form-control {
      border-radius: 0.5rem;
      padding: 0.75rem;
    }

    .btn-primary {
      width: 100%;
      border-radius: 0.5rem;
      font-weight: 600;
      padding: 0.75rem;
      background-color: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
      transform: scale(1.01);
      transition: 0.2s;
    }

    .error-text {
      color: #dc3545;
      text-align: center;
      margin-top: 1rem;
      font-weight: 500;
    }

    .back-btn {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #0d6efd;
      font-weight: 600;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .back-btn:hover {
      text-decoration: underline;
      color: #084298;
    }
  </style>
</head>

<body>
  <div class="login-card">
    <a href="index.php" class="back-btn">
      <i class="bi bi-arrow-left-circle"></i> Back
    </a>

    <h2><i class="bi bi-person-lock"></i> Admin Login</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <button type="submit" name="login" class="btn btn-primary">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </button>

      <?php if (isset($error)): ?>
        <p class="error-text mt-3">
          <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
        </p>
      <?php endif; ?>
    </form>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
