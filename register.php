<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Elearning</title>
    <style>

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