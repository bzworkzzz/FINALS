<?php
require '../db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['loginUsername']);
    $password = trim($_POST['loginPassword']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../index.php");
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
    <title>Login - FindHire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Fullscreen Christmas Animated Background */
        body,
        html {
            height: 100%;
            font-family: 'Arial', sans-serif;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            z-index: -1;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Christmas-themed animations */
        @keyframes snow {
            0% {
                transform: translateY(-100%);
                opacity: 1;
            }

            100% {
                transform: translateY(100%);
                opacity: 0;
            }
        }

        .snowflake {
            position: absolute;
            top: -10px;
            color: #fff;
            font-size: 1.2rem;
            animation: snow linear infinite;
        }

        /* Login card design */
        .login-card {
            max-width: 450px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            text-align: center;
        }

        /* Add Christmas-themed colors */
        h4 {
            color: #d32f2f;
        }

        /* Styled input fields with festive colors */
        input[type="text"],
        input[type="password"] {
            border-radius: 20px;
            border: 1px solid #d32f2f;
        }

        input[type="text"]:hover,
        input[type="password"]:hover {
            transform: scale(1.05);
        }

        /* Styled Login Button with Christmas spirit */
        .btn-primary {
            background: linear-gradient(90deg, #b71c1c, #ef5350);
            border: none;
            border-radius: 20px;
            padding: 10px 25px;
            color: white;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #ef5350, #b71c1c);
            transform: scale(1.1);
        }

        /* Snowflakes animation */
        .snowflake:nth-child(1) {
            left: 10%;
            animation-duration: 10s;
        }

        .snowflake:nth-child(2) {
            left: 30%;
            animation-duration: 12s;
        }

        .snowflake:nth-child(3) {
            left: 50%;
            animation-duration: 15s;
        }

        .snowflake:nth-child(4) {
            left: 70%;
            animation-duration: 9s;
        }

        .snowflake:nth-child(5) {
            left: 90%;
            animation-duration: 14s;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: 15px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .login-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Snowflake Animation -->
    <div class="snowflakes-container">
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
    </div>

    <!-- Login UI -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="login-card">
            <div class="text-center">
                <!-- Logo with Christmas Flair -->
                <img src="https://via.placeholder.com/100/ff0000/ffffff?text=🎄" alt="logo" class="logo mb-3">
                <h4 class="text-dark">Welcome to FindHire</h4>
                <p class="text-muted">Find exciting opportunities this holiday season</p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="loginUsername" class="form-control text-center" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="loginPassword" class="form-control text-center" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0">Don't have an account? <a href="register.php">Sign Up</a></p>
                <p><a href="forgot_password.php">Forgot your password?</a></p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.snowflake').forEach(function(el) {
            el.style.top = Math.random() * window.innerHeight + 'px';
            el.style.left = Math.random() * window.innerWidth + 'px';
        });
    </script>
</body>
</html>
