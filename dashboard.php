<?php
session_start();

// If user is not logged in, send them to the sign in page
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.html");
    exit;
}

// Get username from session
$username = $_SESSION["username"];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TicketBlaster</title>

    <!-- Link to your CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Header / Navigation -->
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


    <!-- Main Content -->
    <main>
         <!-- Upcoming Events Section -->
     <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
     



        <section class="user-actions">
            <h2>My Actions</h2>

        <div class="actions">
            <a href="my-tickets.php" class="btn">View My Tickets</a>
            <a href="events.php" class="btn">Purchase Tickets</a>
            <a href="logout.php" class="btn">Logout</a>

        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer>
        <a href="aboutus.html" class="btn">About Us</a>
        <a href="contactus.html" class="btn">Contact Us</a>
        <a href="faq.html" class="btn">FAQ</a>

        <p>&copy; 2025 TicketBlaster. All rights reserved.</p>
    </footer>

</body>

</html>
