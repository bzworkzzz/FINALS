<?php
require '../db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);

    if ($stmt->rowCount()) {
        $error = "Username or email already exists.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $phone, $password]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FindHire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Christmas Themed Background */
        body {
            height: 100vh;
            background: linear-gradient(to right, #006400, #2e8b57);
            color: white;
            font-family: 'Arial', sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Snowflake Animation for Festivity */
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
            font-size: 1.2rem;
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
        .snowflake:nth-child(2) { left: 25%; animation-duration: 12s; }
        .snowflake:nth-child(3) { left: 45%; animation-duration: 15s; }
        .snowflake:nth-child(4) { left: 65%; animation-duration: 9s; }
        .snowflake:nth-child(5) { left: 85%; animation-duration: 14s; }

        /* Main Centered Registration Card */
        .register-card {
            position: relative;
            z-index: 2;
            max-width: 400px;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            color: #333;
            text-align: center;
        }

        /* Styled Buttons with Christmas theme */
        .btn-primary {
            background: linear-gradient(to right, #d32f2f, #ef5350);
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            color: white;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #ef5350, #b71c1c);
            transform: scale(1.1);
        }

        /* Styled Error Message */
        .alert {
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            .register-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Snowflake Background -->
    <div class="snowflakes-container">
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
    </div>

    <!-- Registration Card UI -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="register-card shadow">
            <div class="text-center mb-3">
                <h4 class="text-dark">🎉 Join the FindHire Family 🎄</h4>
                <p class="text-muted">Start your journey with a simple sign-up</p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>

            <div class="text-center mt-3">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
