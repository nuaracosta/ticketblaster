<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$event_id = (int) $_POST["event_id"];
$ticket_type = $_POST["ticket_type"];
$quantity = (int) $_POST["quantity"];
$price_paid = (float) $_POST["price_paid"];

$stmt = $conn->prepare(
    "INSERT INTO purchases 
     (user_id, event_id, ticket_type, quantity, price_paid) 
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param("iisid", $user_id, $event_id, $ticket_type, $quantity, $price_paid);
$stmt->execute();

header("Location: dashboard.php");
exit;
?>