<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $social = $_POST['social'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (!empty($newPassword) && ($newPassword !== $confirmPassword)) {
        $message = "Passwords do not match!";
        $messageType = "error";
    } else {
        try {
            if (!empty($newPassword)) {
                $hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE Users SET FullName=?, Email=?, Phone=?, SocialMedia=?, PasswordHash=? WHERE Id=?";
                $params = [$fullName, $email, $phone, $social, $hash, $userId];
            } else {
                $sql = "UPDATE Users SET FullName=?, Email=?, Phone=?, SocialMedia=? WHERE Id=?";
                $params = [$fullName, $email, $phone, $social, $userId];
            }

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            
            $logSql = "INSERT INTO ActivityLog (UserId, Username, UserRole, ActivityType) VALUES (?, ?, ?, 'PROFILE_UPDATE')";
            $logStmt = $conn->prepare($logSql);
            $logStmt->execute([$userId, $_SESSION['user_login'], $_SESSION['role']]);
            
            $message = "Profile updated successfully!";
            $messageType = "success";
            
        } catch (PDOException $e) {
            $message = "Error updating profile: " . $e->getMessage();
            $messageType = "error";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM Users WHERE Id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f6f8; padding: 20px; }
        .success { color: #28d00eff; padding: 20px; font-weight: bold;}
        .error { color: #db061cff; padding: 20px; font-weight: bold;} 
    </style>
</head>
<body>

<div>
    <h2>Manage Account Details</h2>

    <?php if ($message): ?>
        <div class="<?php echo $messageType; ?>">
            <bold><?php echo $message; ?></bold>
        </div>
    <?php endif; ?>

    <form method="post" id="profileForm">
        <div>Personal Information</div>
        
        <label>Full Name</label>
        <div id="view-fullname">
            <?php echo htmlspecialchars($user['FullName'] ?? 'Not set'); ?>
            <button type="button" onclick="editField('fullname')">[Edit]</button>
        </div>
        <div id="edit-fullname" style="display:none;">
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['FullName'] ?? ''); ?>">
            <button type="button" onclick="cancelField('fullname')">Cancel</button>
        </div>
        <br>

        <label>Email Address</label>
        <div id="view-email">
            <?php echo htmlspecialchars($user['Email'] ?? 'Not set'); ?>
            <button type="button" onclick="editField('email')">[Edit]</button>
        </div>
        <div id="edit-email" style="display:none;">
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" required>
            <button type="button" onclick="cancelField('email')">Cancel</button>
        </div>
        <br>

        <label>Phone Number</label>
        <div id="view-phone">
            <?php echo htmlspecialchars($user['Phone'] ?? 'Not set'); ?>
            <button type="button" onclick="editField('phone')">[Edit]</button>
        </div>
        <div id="edit-phone" style="display:none;">
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['Phone'] ?? ''); ?>">
            <button type="button" onclick="cancelField('phone')">Cancel</button>
        </div>
        <br>

        <label>Social Media</label>
        <div id="view-social">
            <?php echo htmlspecialchars($user['SocialMedia'] ?? 'Not set'); ?>
            <button type="button" onclick="editField('social')">[Edit]</button>
        </div>
        <div id="edit-social" style="display:none;">
            <input type="text" name="social" value="<?php echo htmlspecialchars($user['SocialMedia'] ?? ''); ?>">
            <button type="button" onclick="cancelField('social')">Cancel</button>
        </div>
        <br>

        <div>Security</div>
        <div id="view-password">
            <span>********</span>
            <button type="button" onclick="editField('password')">Change Password</button>
        </div>
        
        <div id="edit-password" style="display:none; border:1px solid #ccc; padding:10px;">
            <label>New Password</label><br>
            <input type="password" name="password" placeholder="New Password"><br><br>
            
            <label>Confirm Password</label><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password"><br><br>
            
            <button type="button" onclick="cancelField('password')">Cancel</button>
        </div>

        <br><br>
        <button type="submit" id="mainSaveBtn" style="display:none; font-size: 1.2em; padding: 10px 20px;">
            Save Changes
        </button>

    </form>
    
    <br>
    <div style="text-align: center;">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

<script>
    function editField(fieldName) {
        document.getElementById('view-' + fieldName).style.display = 'none';
        document.getElementById('edit-' + fieldName).style.display = 'block';
        
        document.getElementById('mainSaveBtn').style.display = 'block';
    }

    function cancelField(fieldName) {
        document.getElementById('edit-' + fieldName).style.display = 'none';
        document.getElementById('view-' + fieldName).style.display = 'block';
    }
</script>

</body>
</html>