<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);      // NEW
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $level = 0;

    // Insert new user with name field
    $stmt = $conn->prepare("INSERT INTO users (name, username, password, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $hashed, $level);

    if ($stmt->execute()) {

        // AUTO LOGIN
        $_SESSION["user_id"] = $stmt->insert_id;  
        $_SESSION["username"] = $email;           
        $_SESSION["name"] = $name;                // NEW
        $_SESSION["level"] = $level;

        header("Location: dashboard.php");
        exit;
    } 
    else {
        header("Location: signup.html?error=username-taken");
        exit;
    }
}
?>

