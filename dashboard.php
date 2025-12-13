<?php
session_start();
require_once "db.php";

// User must be logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.php");
    exit;
}


// Get username from session
$username = $_SESSION["username"];

// Fetch user's next upcoming event
$stmt = $conn->prepare("
    SELECT 
        e.name,
        e.event_date,
        e.location,
        e.image,
        p.ticket_type,
        p.quantity,
        p.price_paid
    FROM purchases p
    JOIN events e ON p.event_id = e.event_id
    WHERE p.user_id = ?
      AND e.event_date >= CURDATE()
    ORDER BY e.event_date ASC
    LIMIT 1
");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$nextEvent = $stmt->get_result()->fetch_assoc();

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

     <?php if ($nextEvent): ?>
<section class="next-event">
    <h3>Next Event</h3>

    <div class="event-card featured">
        <img 
            src="img/<?= htmlspecialchars($nextEvent['image']) ?>" 
            class="pictures"
            alt="<?= htmlspecialchars($nextEvent['name']) ?>">

        <h3><?= htmlspecialchars($nextEvent['name']) ?></h3>

        <p>
            <?= date("D · M j, Y · g:i A", strtotime($nextEvent['event_date'])) ?>
        </p>

        <p><?= htmlspecialchars($nextEvent['location']) ?></p>

        <p>
            <strong><?= ucfirst($nextEvent['ticket_type']) ?></strong> · 
            Qty: <?= $nextEvent['quantity'] ?>
        </p>

        <p>
            <strong>Total Paid:</strong>
            $<?= number_format($nextEvent['price_paid'] * $nextEvent['quantity'], 2) ?>
        </p>

        <a href="my-tickets.php" class="btn">
            View All Tickets →
        </a>
    </div>
</section>
<?php else: ?>
    <p>You don’t have any upcoming events yet.</p>
<?php endif; ?>

        <section class="user-actions">
            <h2>My Actions</h2>

        <div class="actions">

            <a href="events.php" class="btn">Purchase Tickets</a>
            <a href="logout.php" class="btn">Logout</a>

        </div>
    </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>
