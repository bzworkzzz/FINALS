<?php
require 'db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['admin_id'];
        header("Location: adminPage.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Christmas Edition 🎄</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Background with Christmas Theme */
    body {
      height: 100vh;
      background: linear-gradient(to bottom, #0d6efd, #004085);
      color: white;
      font-family: 'Arial', sans-serif;
      position: relative;
      overflow: hidden;
    }

    /* Snowflakes Animation for Festivity */
    .snowflakes-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }

    .snowflake {
      position: absolute;
      color: white;
      font-size: 1.5rem;
      animation: snow linear infinite;
      opacity: 0.8;
    }

    @keyframes snow {
      0% {
        transform: translateY(-100px);
        opacity: 0.9;
      }

      100% {
        transform: translateY(100vh);
        opacity: 0.3;
      }
    }

    .snowflake:nth-child(1) { left: 5%; animation-duration: 10s; }
    .snowflake:nth-child(2) { left: 20%; animation-duration: 12s; }
    .snowflake:nth-child(3) { left: 40%; animation-duration: 15s; }
    .snowflake:nth-child(4) { left: 60%; animation-duration: 9s; }
    .snowflake:nth-child(5) { left: 80%; animation-duration: 14s; }

    /* Card Styling - Centered Login Form */
    .login-card {
      position: relative;
      z-index: 2;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
      padding: 20px;
      max-width: 400px;
      text-align: center;
    }

    /* Login Card Header */
    .login-card h3 {
      margin-bottom: 10px;
      color: #333;
    }

    /* Input Styling */
    input[type="text"],
    input[type="password"] {
      border: 1px solid #d32f2f;
      border-radius: 8px;
      transition: border-color 0.2s ease-in-out;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #ff0000;
      outline: none;
    }

    /* Styled Button with Christmas Theme */
    .btn-primary {
      background: linear-gradient(to right, #d32f2f, #ef5350);
      border: none;
      border-radius: 20px;
      color: white;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(to right, #ef5350, #b71c1c);
      transform: scale(1.1);
    }

    /* Error Messages */
    .alert {
      color: #d9534f;
      font-size: 14px;
    }

    /* Responsive UI */
    @media (max-width: 768px) {
      .login-card {
        max-width: 90%;
      }
    }
  </style>
</head>

<body>
  <!-- Animated Snowflakes Background -->
  <div class="snowflakes-container">
    <div class="snowflake">❄</div>
    <div class="snowflake">❄</div>
    <div class="snowflake">❄</div>
    <div class="snowflake">❄</div>
    <div class="snowflake">❄</div>
  </div>

  <!-- Login Card UI -->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-card shadow">
      <!-- Header Section -->
      <h3>🎄 Welcome Admin 🎅</h3>
      <p class="text-muted">Login to your control panel</p>

      <!-- Error Message -->
      <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <!-- Login Form -->
      <form method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <!-- Additional Register Prompt -->
      <div class="text-center mt-3">
        <small>Not yet registered? <a href="adminReg.php" style="color: #d32f2f;">Register here</a></small>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
