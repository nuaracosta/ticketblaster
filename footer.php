<footer>
    <a href="aboutus.php" class="btn">About Us</a>
    <a href="contactus.php" class="btn">Contact Us</a>
    <a href="faq.php" class="btn">FAQ</a>

    <p>&copy; 2025 TicketBlaster. All rights reserved.</p>
</footer>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    $(document).ready(function() {
        $('nav ul li').click(function(e) { 
            window.location = $(this).find("a").attr('href');
        });
    });
</script>

</body>
</html>
