<?php
session_start();
require_once 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['PasswordHash'])) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_login'] = $user['Username'];
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['role'] = $user['Role'];
        
        // --- 1. UPDATE LAST LOGIN TIMESTAMP (Fixes "Never" in Admin Panel) ---
        try {
            $updateSql = "UPDATE Users SET LastLogin = GETDATE() WHERE Id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->execute([$user['Id']]);
        } catch (Exception $e) {
            // Ignore error
        }

        // --- 2. LOG ACTIVITY TO HISTORY TABLE ---
        try {
            $logSql = "INSERT INTO ActivityLog (UserId, Username, UserRole, ActivityType) VALUES (?, ?, ?, 'LOGIN')";
            $logStmt = $conn->prepare($logSql);
            $logStmt->execute([$user['Id'], $user['Username'], $user['Role']]);
        } catch (Exception $e) {
            // Ignore error
        }

        // --- 3. REDIRECT ---
        if ($user['Role'] === 'admin') {
             header("Location: admin.php");
        } else {
             header("Location: dashboard.php");
        }
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elearning</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 { text-align: center; color: #333; margin-bottom: 20px; margin-top: 0; }
        .error { color: #d93025; text-align: center; margin-bottom: 15px; font-size: 0.9rem; }
        
        label { font-weight: 600; color: #555; font-size: 0.9rem; }
        input { width: 100%; padding: 12px; margin: 8px 0 20px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        button { width: 100%; background-color: #007bff; color: white; padding: 12px; margin: 10px 0; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: 600; }
        button:hover { background-color: #0056b3; }
        
        .links { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .links a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        <?php if($message): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Log In</button>
        </form>
        <div class="links">
            Don't have an account? <a href="register.php">Sign up</a>
        </div>
    </div>
</body>
</html>