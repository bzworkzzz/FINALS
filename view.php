<?php
include 'db.php';

// Redirect if admin isn't logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminLogin.php');
    exit;
}

// Handle search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = $searchQuery 
    ? "SELECT * FROM job_applications WHERE 
          id LIKE :search OR 
          firstname LIKE :search OR 
          lastname LIKE :search OR 
          email LIKE :search OR 
          username LIKE :search OR 
          job_title LIKE :search 
          ORDER BY id DESC"
    : "SELECT * FROM job_applications ORDER BY id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$searchQuery%"]);
$applications = $stmt->fetchAll();
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Job Title</th>
            <th>Cover Letter</th>
            <th>Resume</th>
            <th>Actions</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($applications): ?>
            <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?= $app['id'] ?></td>
                    <td><?= htmlspecialchars($app['username']) ?></td>
                    <td><?= htmlspecialchars($app['firstname']) ?></td>
                    <td><?= htmlspecialchars($app['lastname']) ?></td>
                    <td><?= htmlspecialchars($app['email']) ?></td>
                    <td><?= htmlspecialchars($app['phone']) ?></td>
                    <td><?= htmlspecialchars($app['job_title']) ?></td>
                    <td><?= htmlspecialchars($app['cover_letter']) ?></td>
                    <td>
                        <?php if (!empty($app['resume'])): ?>
                            <div class="btn-group">
                                <a href="../uploads/<?= htmlspecialchars($app['resume']) ?>" target="_blank" class="btn btn-outline-primary me-2" title="View Resume">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="../uploads/<?= htmlspecialchars($app['resume']) ?>" download class="btn btn-outline-primary" title="Download Resume">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">No Resume</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="../appli/delete.php?id=<?= $app['id'] ?>" class="btn btn-outline-danger" title="Delete Application">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <td>
                        <a href="../appli/status.php?action=accept&application_id=<?= $app['id'] ?>" class="btn btn-outline-success me-2" title="Accept Application">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </a>
                        <a href="../appli/status.php?action=reject&application_id=<?= $app['id'] ?>" class="btn btn-outline-danger" title="Reject Application">
                            <i class="fa-solid fa-ban"></i>
                        </a>
                    </td>
                    <td>
                        <?php 
                        $statusIcons = [
                            'Accepted' => '<i class="fa-solid fa-check-circle" style="color: green;" title="Accepted"></i>',
                            'Rejected' => '<i class="fa-solid fa-circle-xmark" style="color: red;" title="Rejected"></i>',
                            'Pending' => '<i class="fa-solid fa-clock" style="color: orange;" title="Pending"></i>'
                        ];
                        echo $statusIcons[$app['status']] ?? $statusIcons['Pending'];
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="11" class="text-center">No results found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
