<?php
require_once 'db.php';

echo "<h2>Generating Users...</h2>";

$adminUser = "admin";
$adminPass = "admin";
$adminHash = password_hash($adminPass, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO Users (Username, PasswordHash, Role, Email) VALUES (?, ?, 'admin', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$adminUser, $adminHash, 'admin@test.com']);
    
    echo "Created: <b>$adminUser</b> (Password: $adminPass)<br>";
    
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<span style='color:orange'>Skipped: $adminUser (Already exists)</span><br>";
    } else {
        echo "<span style='color:red'>Error: " . $e->getMessage() . "</span><br>";
    }
}

for ($i = 1; $i <= 10; $i++) {
    $username = "user" . $i;
    $rawPassword = "user" . $i; 
    
    $hash = password_hash($rawPassword, PASSWORD_DEFAULT);
    
    try {
        $sql = "INSERT INTO Users (Username, PasswordHash, Role, Email) VALUES (?, ?, 'user', ?)";
        $stmt = $conn->prepare($sql);
        
        $email = $username . "@test.com";
        $stmt->execute([$username, $hash, $email]);
        
        echo "Created: <b>$username</b> (Password: $rawPassword)<br>";
        
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<span style='color:orange'>Skipped: $username (Already exists)</span><br>";
        } else {
            echo "<span style='color:red'>Error: " . $e->getMessage() . "</span><br>";
        }
    }
}

echo "<br><h3>Done! <a href='index.php'>Go to Login</a></h3>";
?>