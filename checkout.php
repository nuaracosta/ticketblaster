<?php
session_start();
require_once "db.php";

// Login wall
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.php");
    exit;
}

// Validate incoming data
if (!isset($_POST["event_id"], $_POST["ticket_type"], $_POST["quantity"])) {
    die("Invalid checkout request.");
}

$user_id = $_SESSION["user_id"];
$event_id = (int) $_POST["event_id"];
$ticket_type = $_POST["ticket_type"];
$quantity = (int) $_POST["quantity"];


$stmt = $conn->prepare(
    "SELECT name, event_date, location, 
            price_general, price_premium, price_vip 
     FROM events 
     WHERE event_id = ?"
);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

switch ($ticket_type) {
    case "general":
        $price = $event["price_general"];
        $ticket_label = "General Admission";
        break;
    case "premium":
        $price = $event["price_premium"];
        $ticket_label = "Premium";
        break;
    case "vip":
        $price = $event["price_vip"];
        $ticket_label = "VIP";
        break;
    default:
        die("Invalid ticket type.");
}

$total = $price * $quantity;

?>

<!-- added stuff above -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <?php include "header.php"; ?>

    <main>
        <div class="checkout-summary">
    <h3>Order Summary</h3>

    <p><strong>Event:</strong> <?= htmlspecialchars($event["name"]) ?></p>
    <p><strong>Date:</strong> <?= date("F j, Y", strtotime($event["event_date"])) ?></p>
    <p><strong>Venue:</strong> <?= htmlspecialchars($event["location"]) ?></p>

    <p><strong>Ticket Type:</strong> <?= $ticket_label ?></p>
    <p><strong>Quantity:</strong> <?= $quantity ?></p>
    <p><strong>Price per ticket:</strong> $<?= number_format($price, 2) ?></p>

    <hr>
    <p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
</div>



        <div class="checkout-container">
            <h2>Checkout</h2>
            <form id="paymentForm" method="POST" action="process-purchase.php">

            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <input type="hidden" name="ticket_type" value="<?= $ticket_type ?>">
            <input type="hidden" name="quantity" value="<?= $quantity ?>">
            <input type="hidden" name="price_paid" value="<?= $price ?>">
                
                <!-- <p class="signin-text">
                    Already have an account?
                <a href="signin.html">Log in</a>
                </p>
                 -->
                
                <div class="form-group">
                    <label>Card Number (16 digits)</label>
                    <input type="text" id="cardNumber" placeholder="1234567812345678" maxlength="16">
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Expiry (MM/YY)</label>
                        <input type="text" id="expiryDate" placeholder="12/25" maxlength="5">
                    </div>
                    <div class="col form-group">
                        <label>CVV</label>
                        <input type="text" id="cvv" placeholder="123" maxlength="3">
                    </div>
                </div>

                <div class="form-group">
                    <label>Name on Card</label>
                    <input type="text" id="cardName" placeholder="John Doe">
                </div>

                <button type="submit" class="btn-submit">Pay Now</button>
            </form>
        </div>
    </main>



    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var cardNum = document.getElementById('cardNumber').value;
            var expiry = document.getElementById('expiryDate').value;
            var cvv = document.getElementById('cvv').value;
            var name = document.getElementById('cardName').value;

            if (cardNum.length !== 16 || isNaN(cardNum)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Card Number',
                    text: 'Please enter a valid 16-digit card number (no spaces).',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (expiry.length !== 5 || !expiry.includes('/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date',
                    text: 'Please enter a valid date in MM/YY format.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (cvv.length !== 3 || isNaN(cvv)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid CVV',
                    text: 'CVV must be exactly 3 digits.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (name.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Name',
                    text: 'Please enter the name on the card.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: 'Your transaction has been approved.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Great!'
            });
        });
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>
