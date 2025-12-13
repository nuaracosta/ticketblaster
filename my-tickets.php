<?php
session_start();
require_once "db.php";

// User must be logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Fetch user's purchased tickets
$stmt = $conn->prepare("
    SELECT 
        p.ticket_type,
        p.quantity,
        p.purchased_at,
        p.price_paid,
        e.name,
        e.event_date,
        e.location,
        e.image
    FROM purchases p
    JOIN events e ON p.event_id = e.event_id
    WHERE p.user_id = ?
    ORDER BY p.purchased_at DESC
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

<?php include "header.php"; ?>

<main>
    <h2>My Tickets</h2>

    <div class="events-grid">

        <?php if ($result->num_rows === 0): ?>
            <p>You haven't purchased any tickets yet.</p>
        <?php else: ?>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event-card">

                    <img 
                        src="img/<?= htmlspecialchars($row['image']) ?>" 
                        class="pictures" 
                        alt="<?= htmlspecialchars($row['name']) ?>">

                    <h3><?= htmlspecialchars($row['name']) ?></h3>

                    <p>
                        <strong>Date:</strong>
                        <?= date("F j, Y", strtotime($row['event_date'])) ?>
                    </p>

                    <p>
                        <strong>Venue:</strong>
                        <?= htmlspecialchars($row['location']) ?>
                    </p>

                    <p>
                        <strong>Ticket Type:</strong>
                        <?= ucfirst(htmlspecialchars($row['ticket_type'])) ?>
                    </p>

                    <p>
                        <strong>Quantity:</strong>
                        <?= (int)$row['quantity'] ?>
                    </p>

                    <p>
                        <strong>Total Paid:</strong>
                        $<?= number_format($row['price_paid'] * $row['quantity'], 2) ?>
                    </p>

                    <p class="small">
                        <em>
                            Purchased on:
                            <?= date("F j, Y g:i A", strtotime($row['purchased_at'])) ?>
                        </em>
                    </p>

                </div>
            <?php endwhile; ?>

        <?php endif; ?>

    </div>
</main>

<?php include "footer.php"; 
?>

</body>
</html>

