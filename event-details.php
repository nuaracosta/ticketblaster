<?php
session_start();
require_once "db.php";

// Ensure an event_id was passed
if (!isset($_GET["event_id"])) {
    die("No event selected.");
}

$event_id = $_GET["event_id"];

// Get event info from DB
$stmt = $conn->prepare("
    SELECT name, event_date, location, price_general, price_premium, price_vip, image
    FROM events 
    WHERE event_id = ?
");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Event not found.");
}

$event = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event["name"]); ?> | TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php include "header.php"; ?>

<!-- ARTIST SECTION (Matches your Ariana layout) -->
<div class="artist-container">
    <h2>
        <?php 
            echo htmlspecialchars($event["name"]) . "<br>";
            echo date("F j, Y", strtotime($event["event_date"])); 
        ?>
    </h2>

    <img src="img/<?php echo htmlspecialchars($event["image"]); ?>" 
         alt="<?php echo htmlspecialchars($event["name"]); ?>">

    <div class="prices">
        <h2>Prices</h2>

        <select name="price" id="price">
            <option value="">Select Ticket Type</option>

            <option value="general">
                General Admission - $<?php echo $event["price_general"]; ?>
            </option>

            <option value="premium">
                Premium - $<?php echo $event["price_premium"]; ?>
            </option>

            <option value="vip">
                VIP - $<?php echo $event["price_vip"]; ?>
            </option>
        </select>

        <label for="quantity">Quantity</label>
        <input 
            type="number" 
            id="quantity" 
            name="quantity" 
            min="1" 
            max="10" 
            value="1">

        <a href="checkout.php?event_id=<?php echo $event_id; ?>" 
           class="btn buy-btn">Purchase</a>
    </div>
</div>

<!-- Ticket Tiers Description -->
<main>
    <section class="tickets-info">
        <h3>Ticket tiers and info</h3>

        <p>
            General Admission - <b>$<?php echo $event["price_general"]; ?></b><br>
            Standard admission to the venue.
        </p>

        <p>
            Premium - <b>$<?php echo $event["price_premium"]; ?></b><br>
            Preferred viewing / early entry (if applicable).
        </p>

        <p>
            VIP - <b>$<?php echo $event["price_vip"]; ?></b><br>
            VIP experience, priority access, and exclusive perks.
        </p>
    </section>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
