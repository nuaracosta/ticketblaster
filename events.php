<?php
session_start();
require_once "db.php"; // your real DB connection file

$sql = "SELECT event_id, name, event_date, location, price_general, price_premium, price_vip, image 
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

<!-- HEADER -->
<header>
    <nav>
        <img src="img/header-ticketmaster.png" alt="TicketBlaster Logo">
        <ul class="nav-links">
            <li><a href="home.html" class="active">Home</a></li>
            <li><a href="signin.php">Sign In</a></li>
            <li><a href="events.php">Upcoming Events</a></li>
        </ul>
    </nav>
</header>

<h1 class="events-title">Upcoming Events</h1>

<!-- container that matches your layout -->
<div class="artists-container">

<?php while ($row = $result->fetch_assoc()): ?>

    <!-- EACH EVENT CARD — EXACT STRUCTURE YOU ALREADY USE -->
    <div class="artist-container">
        <h2><?php echo htmlspecialchars($row['name']); ?></h2>

        <img src="img/<?php echo $row['image']; ?>" 
             alt="<?php echo htmlspecialchars($row['name']); ?>">

        <p><strong>Date:</strong> 
            <?php echo date("F j, Y", strtotime($row['event_date'])); ?>, NYC
        </p>

        <p><strong>Venue:</strong> 
            <?php echo htmlspecialchars($row['location']); ?>
        </p>

        <a href="event-details.php?event_id=<?php echo $row['event_id']; ?>" 
           class="btn">
            View Event
        </a>
    </div>

<?php endwhile; ?>

</div>

</body>
</html>
