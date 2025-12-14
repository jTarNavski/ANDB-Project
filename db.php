<?php
$serverName = "Dominator\\SQLEXPRESS";
$database = "Elearning";
$uid = "UzytkownikStrony";
$pwd = "SilneHaslo123!";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>