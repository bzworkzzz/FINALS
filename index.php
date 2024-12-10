<?php
require 'db.php';
session_start();

// Redirect if the user isn't logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login/login.php');
    exit;
}

// Fetch all job postings
$job_postings = $pdo->query("SELECT * FROM job_postings")->fetchAll();

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $stmt = $pdo->prepare("INSERT INTO job_applications 
                             (firstname, lastname, email, phone, cover_letter, job_title, resume, username) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $resumePath = '';
    if ($_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $resumePath = 'uploads/' . $_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
    }

    $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], 
                     $_POST['cover_letter'], $_POST['job_title'], $_FILES['resume']['name'], $_SESSION['username']]);

    header('Location: /appli/ty.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Christmas-Themed Styles -->
    <style>
        /* Background with snow and gradient */
        body {
            background: linear-gradient(to bottom, #a1d2ff, #ffffff);
            font-family: 'Arial', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        /* Snowflakes animation effect */
        .snowflake {
            position: absolute;
            color: #ffffff;
            font-size: 1.5rem;
            animation: snow 10s linear infinite;
            opacity: 0.8;
        }

        @keyframes snow {
            0% {
                transform: translateY(-100px);
            }
            100% {
                transform: translateY(100vh);
            }
        }

        /* Random positions for snowflakes */
        .snowflake:nth-child(1) { left: 5%; animation-duration: 12s; }
        .snowflake:nth-child(2) { left: 15%; animation-duration: 14s; }
        .snowflake:nth-child(3) { left: 25%; animation-duration: 10s; }
        .snowflake:nth-child(4) { left: 35%; animation-duration: 15s; }
        .snowflake:nth-child(5) { left: 50%; animation-duration: 8s; }
        .snowflake:nth-child(6) { left: 70%; animation-duration: 12s; }

        /* Navbar */
        nav.navbar {
            background: linear-gradient(to right, #d32f2f, #ff5722);
            color: white;
        }

        /* Modal Design */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            background: #ffccbc;
        }

        /* Button animations */
        .btn-primary:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Table hover effects */
        table.table-hover tbody tr:hover {
            background-color: #d4edda;
        }

        /* Footer design */
        footer {
            background: #6a1b9a;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 16px;
            border-top: 2px solid #ffccbc;
        }
    </style>
</head>

<body>
    <!-- Snowflake Animation Layer -->
    <div class="snowflakes-container">
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand">FindHire 🎄</span>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="viewapp.php">View Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Job Listings Section -->
    <div class="container mt-4">
        <h3 class="text-center mb-3 text-danger">🎅 Job Listings 🎄</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($job_postings as $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#applicationModal"
                                    onclick="setJobTitle('<?php echo htmlspecialchars($job['job_title']); ?>')">Apply</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        ❤️ Made with Love | FindHire © 2023
    </footer>

    <script>
        function setJobTitle(jobTitle) {
            document.getElementById('job_title').value = jobTitle;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
