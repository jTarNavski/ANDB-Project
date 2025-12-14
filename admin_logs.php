<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

$sql = "SELECT TOP 50 * FROM ActivityLog ORDER BY LogDate DESC";
$stmt = $conn->query($sql);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Activity Logs</title>
</head>
<body>
    <div>
        <h2>System Activity Logs</h2>
        <a href="admin.php">Back to Users</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Username</th>
                <th>Role</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo $log['LogDate']; ?></td>
                <td><?php echo htmlspecialchars($log['Username']); ?></td>
                <td><?php echo htmlspecialchars($log['UserRole']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>