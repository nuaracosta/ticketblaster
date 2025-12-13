<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | TicketBlaster</title>
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

            submitBtn.addEventListener('click', function(e) {
                
                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const originalText = submitBtn.innerText;
                submitBtn.innerText = 'Sending...';
                submitBtn.style.opacity = '0.7';
                submitBtn.disabled = true;

                const formData = new FormData(form);

                fetch('contact.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Message Sent!',
                            text: 'We have received your message.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Great!'
                        });
                        form.reset();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Could not save message.',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error'
                    });
                })
                .finally(() => {
                    submitBtn.innerText = originalText;
                    submitBtn.style.opacity = '1';
                    submitBtn.disabled = false;
                });
            });
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
