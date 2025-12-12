<?php
session_start();
require_once "db.php";

// User must be logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.html");
    exit;
}

$user_id = $_SESSION["user_id"];

// Fetch user's tickets
$stmt = $conn->prepare("
    SELECT 
        purchases.tier,
        purchases.quantity,
        purchases.purchase_date,
        events.name,
        events.event_date,
        events.location,
        events.image
    FROM purchases
    JOIN events ON purchases.event_id = events.event_id
    WHERE purchases.user_id = ?
    ORDER BY purchases.purchase_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets | TicketBlaster</title>
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

<main>
    <h2>My Tickets</h2>

    <div class="events-grid">

        <?php if ($result->num_rows === 0): ?>
            <p>You haven't purchased any tickets yet.</p>
        <?php else: ?>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event-card">
                    <img src="img/<?= htmlspecialchars($row['image']) ?>" class="pictures" alt="Event Image">
                    
                    <h3><?= htmlspecialchars($row['name']) ?></h3>

                    <p><strong>Date:</strong> <?= htmlspecialchars($row['event_date']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>

                    <p><strong>Tier:</strong> <?= ucfirst($row['tier']) ?></p>
                    <p><strong>Quantity:</strong> <?= $row['quantity'] ?></p>

                    <p class="small"><em>Purchased on: <?= $row['purchase_date'] ?></em></p>
                </div>
            <?php endwhile; ?>

        <?php endif; ?>

    </div>
</main>

<?php include "footer.php"; ?>


</body>
</html>
