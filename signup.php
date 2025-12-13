<?php
session_start();
require_once "db.php"; // DB connection

$error = "";
$success = "";

// If form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Check if email already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "This email is already registered.";
    } else {

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (username, password, name, level) VALUES (?, ?, ?, ?)"
        );

        $level = "user";

        $stmt->bind_param("ssss", $email, $hashedPassword, $name, $level);


        if ($stmt->execute()) {
            // redirect to signin page
            header("Location: signin.php?registered=1");
            exit;
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp | TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php include "header.php"; ?>

<div class="signup-container">
    <form class="signup-form" action="signup.php" method="POST">
        <h2>Create Account</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red; font-weight:bold;"><?= $error ?></p>
        <?php endif; ?>

        <div class="input-group">
            <label for="name">Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                placeholder="Enter your name"
                required>
        </div>

        <div class="input-group">
            <label for="email">E-mail</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="Enter your email"
                required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Create a password"
                required>
        </div>

        <button type="submit" class="btn">Sign Up</button>

        <p class="signup-text">
            Already have an account?
            <a href="signin.php">Log in</a>
        </p>
    </form>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
