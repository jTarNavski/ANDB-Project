<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

$message = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newRole = $_POST['role'];
    $userId = $_POST['id'];
    $newPhone = $_POST['phone'];
    $newSocial = $_POST['social'];
    $newFullName = $_POST['fullname'];

    try {
        $sql = "UPDATE Users SET FullName=?, Username = ?, Email = ?, Phone=?, SocialMedia=?, Role = ? WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$newFullName, $newUsername, $newEmail,  $newPhone, $newSocial, $newRole, $userId]);
        $message = "User updated successfully!";
    } catch (PDOException $e) {
        $message = "Error updating user: " . $e->getMessage();
    }
}

$stmt = $conn->prepare("SELECT * FROM Users WHERE Id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit User</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f6f8; padding: 20px; }
        .success { color: #28d00eff; padding: 20px; font-weight: bold;}
        .error { color: #db061cff; padding: 20px; font-weight: bold;} 
    </style>
</head>
<body>
    <h2>Edit User: <?php echo htmlspecialchars($user['Username']); ?></h2>
    
    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $user['Id']; ?>">
        
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required><br><br>
        
        <label>Full name:</label><br>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['FullName']); ?>" required><br><br>   
        
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>"><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>"><br><br>

        <label>Social media:</label><br>
        <input type="text" name="social" value="<?php echo htmlspecialchars($user['SocialMedia']); ?>" required><br><br>   
        
        <label>Role:</label><br>
        <select name="role">
            <option value="user" <?php if($user['Role'] == 'user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if($user['Role'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br><br>
        
        <button type="submit">Save Changes</button>
    </form>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>