<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. You do not have permission to view this page. <a href='index.php'>Go Home</a>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
</head>
<body>

    <div>
        <h2>Admin Panel: User Management</h2>
        <div>
            <a href="admin_logs.php" >View System Logs</a>
            <a href="dashboard.php">User Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <form>
        <input type="text" name="search" placeholder="Search username..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <a href="admin.php">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th><a href="?sort=Id">ID</a></th>
                <th><a href="?sort=Username">Username</a></th>
                <th><a href="?sort=Email">Email</a></th>
                <th><a href="?sort=Role">Role</a></th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</body>
</html>