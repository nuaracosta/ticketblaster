<?php
session_start();
require_once "db.php";

// Fetch the first 4 upcoming events for the homepage
$sql = "SELECT event_id, name, event_date, location, image 
        FROM events 
        ORDER BY event_date ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketBlaster</title>

    <link rel="stylesheet" href="styles.css">
</head>

<body>

<?php include "header.php"; ?>

<section class="events">
    <h2>Upcoming Events</h2>
    <br><br>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="event-card">
            <h3><?php echo htmlspecialchars($row["name"]); ?></h3>

            <img class="pictures"
                 src="img/<?php echo htmlspecialchars($row["image"]); ?>"
                 alt="<?php echo htmlspecialchars($row["name"]); ?>">

            <p><strong>Date:</strong>
               <?php echo date("F j, Y", strtotime($row["event_date"])); ?>
            </p>

            <p><strong>Venue:</strong>
               <?php echo htmlspecialchars($row["location"]); ?>
            </p>

            <a href="event-details.php?event_id=<?php echo $row['event_id']; ?>" class="btn">
                View Event
            </a>
        </div>
    <?php endwhile; ?>

</section>

<?php include 'footer.php'; ?>

</body>
</html>

