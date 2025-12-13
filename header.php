<header>
    <nav>
        <img src="img/header-ticketmaster.png" alt="TicketBlaster Logo">
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="events.php">Upcoming Events</a></li>

            <?php if (isset($_SESSION["user_id"])): ?>
				<li><a href="dashboard.php">Dashboard</a></li>
				<li><a href="my-tickets.php">My Tickets</a></li>
                <li><a href="logout.php">Logout</a></li>

            <?php else: ?>
                <li><a href="signin.php">Sign In / Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

