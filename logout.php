<?php
session_start();



// Destroy session and redirect
session_destroy();
header("Location: index.php");
exit;
?>