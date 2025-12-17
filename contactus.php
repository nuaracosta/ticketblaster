<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | TicketBlaster</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include "header.php"; ?>

    <main>
        <section class="contact-us">
            <h2>Contact Us</h2>
            <p class="contact-intro">
                Have questions or need help with your tickets? Reach out to us — we're here to help.
            </p>

            <div class="contact-wrapper">
                <div class="contact-form">
                    <h3>Email Us</h3>
                    <form id="contactForm">
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Your name" required>
                        </div>

                        <div class="input-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" placeholder="Your email" required>
                        </div>

                        <div class="input-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="How can we help?" required></textarea>
                        </div>

                        <button type="button" class="btn" id="submitBtn">Send Message</button>
                    </form>
                </div>

                <div class="contact-phone">
                    <h3>Call Our Support Center</h3>
                    <p>📞 <strong>1-800-555-BLST</strong></p>
                    <p>
                        Available Monday - Friday<br>
                        9:00 AM - 6:00 PM (ET)
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');

            submitBtn.addEventListener('click', function() {
                
                // 1. Check if the form is filled out
                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // 2. Visual feedback (Loading state)
                const originalText = submitBtn.innerText;
                submitBtn.innerText = 'Sending...';
                submitBtn.style.opacity = '0.7';
                submitBtn.disabled = true;

                setTimeout(() => {
                    // Success Pop-up
                    Swal.fire({
                        title: 'Message Sent!',
                        text: 'Thank you for contacting TicketBlaster. We will get back to you soon.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Great!'
                    });

                    form.reset();
                    submitBtn.innerText = originalText;
                    submitBtn.style.opacity = '1';
                    submitBtn.disabled = false;
                }, 1500); 
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
