<?php
session_start();

// 1. Security Check: Redirect if not logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

// 2. Get User Info
$username = $_SESSION['user_login'];
$role = $_SESSION['role'] ?? 'user'; // Default to 'user' if role is missing
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Elearning</title>
    <style>
        /* --- 1. RESET & BASIC STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; color: #333; }
        a { text-decoration: none; color: inherit; }

        /* --- 2. GRID LAYOUT (The Skeleton) --- */
        .dashboard-container {
            display: grid;
            grid-template-areas: 
                "header header"
                "sidebar main";
            grid-template-columns: 250px 1fr; /* Sidebar width | Main content width */
            grid-template-rows: 60px 1fr;     /* Header height | Content height */
            height: 100vh;
        }

        /* --- 3. HEADER --- */
        .header {
            grid-area: header;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            z-index: 10;
        }
        .logo { font-size: 1.2rem; font-weight: bold; color: #007bff; }
        .user-menu { font-size: 0.9rem; }
        .user-menu span { margin-right: 15px; font-weight: bold; }
        .btn-logout { background: #dc3545; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.8rem; }

        /* --- 4. SIDEBAR --- */
        .sidebar {
            grid-area: sidebar;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar a {
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
            transition: background 0.3s;
        }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; border-bottom: none; }

        /* --- 5. MAIN CONTENT --- */
        .main-content {
            grid-area: main;
            padding: 30px;
            overflow-y: auto; /* Allows scrolling if content is long */
        }

        /* --- 6. WIDGETS (The Cards) --- */
        .welcome-banner {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        .card h3 { font-size: 1rem; color: #777; margin-bottom: 10px; }
        .card .number { font-size: 2rem; font-weight: bold; color: #2c3e50; }

        /* Mobile Response */
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-areas: "header" "main"; /* Hide sidebar on mobile for now */
                grid-template-columns: 1fr;
                grid-template-rows: 60px 1fr;
            }
            .sidebar { display: none; } /* Hide sidebar on small screens */
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    
    <header class="header">
        <div class="logo">E-Learning Platform</div>
        <div class="user-menu">
            <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </header>

    <aside class="sidebar">
        <a href="#" class="active">Dashboard</a>
        <a href="#">My Courses</a>
        <a href="#">Assignments</a>
        <a href="profile.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">Profile Settings</a>
        
        <?php if($role === 'admin'): ?>
            <a href="admin.php" style="background-color: #d35400;">⚙ Admin Panel</a>
        <?php endif; ?>
    </aside>

    <main class="main-content">
        
        <div class="welcome-banner">
            <h1>Hello, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Welcome back to your learning dashboard. Here is an overview of your activity.</p>
        </div>

        <div class="stats-grid">
            <div class="card">
                <h3>Courses Enrolled</h3>
                <div class="number">4</div>
            </div>
            
            <div class="card">
                <h3>Pending Tasks</h3>
                <div class="number">12</div>
            </div>
            
            <div class="card">
                <h3>Average Score</h3>
                <div class="number">85%</div>
            </div>

             <div class="card">
                <h3>Messages</h3>
                <div class="number">2</div>
            </div>
        </div>

    </main>

</div>

</body>
</html>