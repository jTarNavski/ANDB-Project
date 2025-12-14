<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connection Status</title>

</head>
<body class="<?php echo $conn ? 'success-bg' : 'error-bg'; ?>">

    <div class="box">
        <?php if ($conn): ?>
            <h1>Connection Valid</h1>
            <p>Successfully connected to database: <strong><?php echo $database; ?></strong></p>
        <?php else: ?>
            <h1>Connection Failed</h1>
            <p>Error details: <br> <?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>