<?php
// FILE: db_connect.php

$servername = "localhost"; 
$username   = "webgroup5";     // Check if this is your exact username
$password   = "judge cheer through supply"; // <--- PUT YOUR REAL PASSWORD HERE
$dbname     = "webgroup5_db";  // Check if this is your exact DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}
?>
