<?php
session_start();
require_once "db_login.php"; // your professor’s DB connection

// 1. Check if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form values
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // 2. Hash password securely
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // 3. Insert into database
    // If your DB uses `username` instead of `email`, this still works:
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $hashed);

    if ($stmt->execute()) {
        // Redirect user to sign in
        header("Location: signin.html?success=1");
        exit;
    } else {
        echo "Error creating account: " . $stmt->error;
    }
}
?>
