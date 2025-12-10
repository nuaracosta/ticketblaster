<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: signin.html");
    exit;
}
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h1>
<p>Your purchased tickets will appear here.</p>
