<?php
$host = "localhost";
$user = "webgroup5";          // your TopHat username
$pass = "missing summer dictator strong";   // your 4-word password
$dbname = "webgroup5_default";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
