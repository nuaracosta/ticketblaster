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

<header>
    <nav>
        <img src="img/header-ticketmaster.png" alt="TicketBlaster Logo">
        <ul class="nav-links">
            <li><a href="home.html">Home</a></li>
            <li><a href="signin.php">Sign In</a></li>
            <li><a href="events.php" class="active">Upcoming Events</a></li>
        </ul>
    </nav>
</header>

<div class="events">
    <h2>Upcoming Events</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="event-card">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>

            <img class="pictures"
                 src="img/<?php echo $row['image']; ?>"
                 alt="<?php echo htmlspecialchars($row['name']); ?>">

            <p><strong>Date:</strong>
               <?php echo date("F j, Y", strtotime($row['event_date'])); ?>, NYC
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

</body>
</html>
