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

    <form>
        <div>Personal Information</div>
        
        <label>Full Name</label>
        <div >
            <div>Duban Dubi
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <br>

        <label>Email Address</label>
        <div >
            <div>dubi@duban.com
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <div id="edit-email" style="display:none;">
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" required>
            <button type="button" onclick="cancelField('email')">Cancel</button>
        </div>
        <br>

        <label>Phone Number</label>
        <div >
            <div>123454654123
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <br>

        <label>Social Media</label>
        <div >
            <div>www.fakebook.com/dubiduban
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <br>

        
        <label>Password</label>
        <div >
            <div>********
            <button type="button" onclick="editField('fullname')">[Edit]</button></div>
        </div>
        <br>

        <br><br>
        <button>
            Save Changes
        </button>

    </form>
    
    <br>
    <div style="text-align: center;">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>