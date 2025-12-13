<?php
session_start();

// Check if a user was actually logged in before logging them out
if (isset($_SESSION['user_id'])) {
    try {
        $userId = $_SESSION['user_id'];
        $username = $_SESSION['user_login'];
        $role = $_SESSION['role'];

        // Insert LOGOUT event
        $sql = "INSERT INTO ActivityLog (UserId, Username, UserRole, ActivityType) VALUES (?, ?, ?, 'LOGOUT')";
        $stmt->execute([$userId, $username, $role]);
    } catch (Exception $e) {
    }
}

// Destroy session and redirect
session_destroy();
header("Location: index.php");
exit;
?>