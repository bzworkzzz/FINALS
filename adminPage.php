<?php
require 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminLogin.php');
    exit;
}

// Fetch job postings
$stmt = $pdo->query("SELECT * FROM job_postings");
$job_postings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire | Manage Jobs</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        /* General Body Styles */
        body {
            background: linear-gradient(to bottom, #f0f8ff, #d0eaff);
            font-family: 'Arial', sans-serif;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Navbar with Christmas Colors */
        .navbar {
            background: linear-gradient(to right, #d32f2f, #ff0000);
            color: white;
        }

        /* Footer Styling with Christmas-Themed Gradient */
        footer {
            background: linear-gradient(to right, #2e7d32, #66bb6a);
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
        }

        /* Main Content Area */
        main {
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            max-width: 1200px;
            margin: 20px auto;
            z-index: 2;
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
            color: #fff;
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

        .snowflake:nth-child(1) { left: 5%; animation-duration: 12s; }
        .snowflake:nth-child(2) { left: 20%; animation-duration: 10s; }
        .snowflake:nth-child(3) { left: 40%; animation-duration: 14s; }
        .snowflake:nth-child(4) { left: 60%; animation-duration: 9s; }
        .snowflake:nth-child(5) { left: 80%; animation-duration: 15s; }

        /* Job Table Styles */
        table {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Button Animations */
        .btn-info:hover,
        .btn-danger:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }

        /* Search Bar Styling */
        #search {
            border-radius: 20px;
        }

    </style>
</head>

<body>
    <!-- Snowflakes Animation -->
    <div class="snowflakes-container">
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❄</div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">FindHire 🎄</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../adminLogout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <main>
        <div class="text-center mb-4">
            <h2 style="color:#d32f2f;">💼 Manage Job Postings - Christmas Edition 🎅</h2>
            <p>View, edit, or delete job postings with ease.</p>
        </div>

        <!-- Search Box -->
        <div class="input-group mb-4">
            <input type="text" id="search" class="form-control" placeholder="Search for jobs...">
            <button class="btn btn-outline-danger" type="button">Search</button>
        </div>

        <!-- Jobs Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Salary</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($job_postings as $job) { ?>
                        <tr>
                            <td><?= htmlspecialchars($job['job_title']); ?></td>
                            <td><?= htmlspecialchars($job['job_description']); ?></td>
                            <td><?= htmlspecialchars($job['location']); ?></td>
                            <td><?= htmlspecialchars($job['salary']); ?></td>
                            <td><?= htmlspecialchars($job['last_updated']); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $job['job_id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="delete.php?id=<?= $job['job_id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; <?= date('Y'); ?> FindHire - All rights reserved. 🎉</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
