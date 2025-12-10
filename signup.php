<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Email = username in the DB
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Hash password securely
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Default user level = 0 (normal user)
    $level = 0;

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $email, $hashed, $level);

    if ($stmt->execute()) {
        // Success → send user to sign in page
        header("Location: signin.html?signup=success");
        exit;
    } else {
        // If username already exists or DB error
        header("Location: signup.html?error=username-taken");
        exit;
    }
}
?>
