<?php
session_start();
require_once "db.php";

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
    <title>Upcoming Events - TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

 <?php include "header.php"; ?>

<div class="events">
    <h2>Upcoming Events</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="event-card">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>

            <img class="pictures"
                 src="img/<?php echo $row['image']; ?>"
                 alt="<?php echo htmlspecialchars($row['name']); ?>">

            <p><strong>Date:</strong>
               <?php echo date("F j, Y", strtotime($row['event_date'])); ?>
            </p>

            <p><strong>Venue:</strong>
               <?php echo htmlspecialchars($row['location']); ?>
            </p>

            <a href="event-details.php?event_id=<?php echo $row['event_id']; ?>" 
               class="btn">View Event</a>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>
        <?php include 'footer.php'; ?>
</body>
</html>
