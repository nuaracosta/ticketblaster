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
    <<?php include "header.php"; ?>


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
    <?php include 'footer.php'; ?>

</body>

</html>
