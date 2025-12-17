<?php
require_once 'db.php';
$message = "";
$messageType = ""; // To distinguish between success (green) and error (red)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $messageType = "error";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Default role is 'user'
            $sql = "INSERT INTO Users (Username, PasswordHash, Role) VALUES (?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hash]);
            $message = "Account created successfully! <a href='index.php'>Log in now</a>";
            $messageType = "success";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                $message = "This username is already taken.";
            } else {
                $message = "Database error: " . $e->getMessage();
            }
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Elearning</title>
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
        .register-card {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 { text-align: center; color: #333; margin-bottom: 20px; margin-top: 0; }
        
        .alert { padding: 10px; margin-bottom: 15px; text-align: center; border-radius: 4px; font-size: 0.9rem; }
        .error { background-color: #fce8e6; color: #d93025; border: 1px solid #fad2cf; }
        .success { background-color: #e6f4ea; color: #1e8e3e; border: 1px solid #ceead6; }
        .success a { color: #1e8e3e; font-weight: bold; }

        label { font-weight: 600; color: #555; font-size: 0.9rem; }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus { border-color: #007bff; outline: none; }
        
        button {
            width: 100%;
            background-color: #28a745; /* Green for registration */
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
        }
        button:hover { background-color: #218838; }
        
        .links { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .links a { color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="register-card">
        <h2>Create Account</h2>
        
        <?php if($message): ?>
            <div class="alert <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
            
            <button type="submit">Register</button>
        </form>
        
        <div class="links">
            Already have an account? <a href="index.php">Log in</a>
        </div>
    </div>

</body>
</html>