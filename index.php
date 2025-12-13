<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elearning</title>
    <style>
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