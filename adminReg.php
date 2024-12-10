<?php
require '../db.php';
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username exists
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount()) {
        $error = "❄ Username already taken! ❄";
    } else {
        // Insert new user into database
        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        
        header("Location: adminLogin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/logorss.png" type="image/x-icon">
    <title>FindHire | Admin Register</title>
    
    <!-- Load CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* General Body & Background */
        body {
            background: linear-gradient(to bottom, #e0f7fa, #ffffff);
            font-family: Arial, sans-serif;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Snowflakes Animation */
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
            color: #ffffff;
            font-size: 1.2rem;
            animation: snow linear infinite;
            opacity: 0.8;
        }

        @keyframes snow {
            0% {
                transform: translateY(-100px);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh);
                opacity: 0.2;
            }
        }

        /* Snowflakes Random Positions */
        .snowflake:nth-child(1) { left: 10%; animation-duration: 12s; }
        .snowflake:nth-child(2) { left: 20%; animation-duration: 15s; }
        .snowflake:nth-child(3) { left: 30%; animation-duration: 18s; }
        .snowflake:nth-child(4) { left: 50%; animation-duration: 9s; }
        .snowflake:nth-child(5) { left: 70%; animation-duration: 10s; }
        .snowflake:nth-child(6) { left: 90%; animation-duration: 13s; }

        /* Main Form Styling */
        .container {
            position: relative;
            z-index: 2;
            max-width: 500px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            color: #d32f2f;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        /* Buttons - Christmas Style */
        .btn-primary {
            background-color: #d32f2f;
            border: none;
            transition: transform 0.2s ease-in-out;
        }

        .btn-primary:hover {
            transform: scale(1.1);
        }

        .btn-link {
            color: #00695c;
            transition: transform 0.2s ease-in-out;
        }

        .btn-link:hover {
            transform: scale(1.1);
        }

        /* Error message style */
        .alert-danger {
            background-color: #ffccbc;
            color: #d32f2f;
            border: none;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        <div class="snowflake">❄</div>
    </div>

    <!-- Registration Form -->
    <div class="container">
        <h1>🎄 Register Admin Account 🎅</h1>
        
        <!-- Display error if any -->
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Form to register admin -->
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="adminLogin.php" class="btn btn-link">Go to Login</a>
            </div>
        </form>
    </div>

    <!-- Load JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
