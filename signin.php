<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT user_id, name, password, level FROM users WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($uid, $name, $hashed, $level);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {

            $_SESSION["user_id"] = $uid;
            $_SESSION["username"] = $email;
            $_SESSION["name"] = $name;
            $_SESSION["level"] = $level;

            // ⭐ THIS is what sends the user to their dashboard
            header("Location: dashboard.php");
            exit;
        }
    }

    header("Location: signin.html?error=invalid");
    exit;
}
?>

