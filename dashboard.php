<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['user_login'];
$role = $_SESSION['role'] ?? 'user'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Elearning</title>
    <style>
        body { font-family: 'Segoe UI'; background-color: #f4f6f8; color: #333; padding: 20px }
    </style>
</head>
<body>

<div>
    
    <header>
        <div>E-Learning Platform</div>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <aside>
        <a href="#">Dashboard</a>
        <a href="#">My Courses</a>
        <a href="#">Assignments</a>
        <a href="profile.php">Profile Settings</a>
        
        <?php if($role === 'admin'): ?>
            <a href="admin.php" style="background-color: #d35400; color: white">Admin Panel</a>
        <?php endif; ?>
    </aside>

    <main>
        
        <div>
            <h1>Hello, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Welcome back to your learning dashboard. Here is an overview of your activity.</p>
        </div>

        <div>
            <div>
                <h3>Courses Enrolled</h3>
                <div>4</div>
            </div>
            
            <div>
                <h3>Pending Tasks</h3>
                <div>12</div>
            </div>
            
            <div>
                <h3>Average Score</h3>
                <div>85%</div>
            </div>

             <div>
                <h3>Messages</h3>
                <div>2</div>
            </div>
        </div>

    </main>

</div>

</body>
</html>