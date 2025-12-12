<?php
session_start();
require_once "db.php"; // your DB connection

$error = "";

// When user submits the form:
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, username, password, name FROM users WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify password with password_verify()
        if (password_verify($password, $row["password"])) {

            // Store user session
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["name"] = $row["name"];   // ADD THIS


            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<header>
    <nav>
        <img src="img/header-ticketmaster.png" alt="TicketBlaster Logo">
        <ul class="nav-links">
            <li><a href="home.php" class="active">Home</a></li>
            <li><a href="signin.php">Sign In</a></li>
            <li><a href="events.php">Upcoming Events</a></li>
            <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </nav>
</header>

<form class="login-form" action="signin.php" method="POST">
    <h2>Sign In</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red; font-weight:bold;"><?= $error ?></p>
    <?php endif; ?>

    <div class="input-group">
        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" required>
    </div>

    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn">Login</button>
</form>

<p style="text-align:center; margin-top:20px;">
    Don't have an account? <a href="signup.php">Sign Up</a>
</p>

<footer>
    <a href="aboutus.html" class="btn">About Us</a>
    <a href="contactus.html" class="btn">Contact Us</a>
    <a href="faq.html" class="btn">FAQ</a>

    <p>&copy; 2025 TicketBlaster. All rights reserved.</p>
</footer>

</body>
</html>