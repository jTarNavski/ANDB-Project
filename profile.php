<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>
<body>

<div class="container">
    <h2>Manage Account Details</h2>

    <?php if ($message): ?>
        <div class="alert <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" id="profileForm">
        <div class="section-title">Personal Information</div>
        
        <label>Full Name</label>
        <div id="view-fullname">
            <div>Duban Dubi
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <div id="edit-fullname" style="display:none;">
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['FullName'] ?? ''); ?>">
            <button type="button" onclick="cancelField('fullname')">Cancel</button>
        </div>
        <br>

        <label>Email Address</label>
        <div id="view-email">
            <div>dubi@duban.com
            <button type="button" onclick="editField('email')">[Edit]</button></div>
        </div>
        <div id="edit-email" style="display:none;">
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" required>
            <button type="button" onclick="cancelField('email')">Cancel</button>
        </div>
        <br>

        <label>Phone Number</label>
        <div id="view-phone">
            <div>123454654123
            <button type="button" onclick="editField('phone')">[Edit]</button></div>
        </div>
        <div id="edit-phone" style="display:none;">
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['Phone'] ?? ''); ?>">
            <button type="button" onclick="cancelField('phone')">Cancel</button>
        </div>
        <br>

        <label>Social Media</label>
        <div id="view-social">
            <div>www.fakebook.com/dubiduban
            <button type="button" onclick="editField('social')">[Edit]</button></div>
        </div>
        <div id="edit-social" style="display:none;">
            <input type="text" name="social" value="<?php echo htmlspecialchars($user['SocialMedia'] ?? ''); ?>">
            <button type="button" onclick="cancelField('social')">Cancel</button>
        </div>
        <br>

        <div class="section-title">Security</div>
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