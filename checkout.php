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
        <div class="checkout-container">
            <h2>Checkout</h2>
            <form id="paymentForm">
                
                <p class="signin-text">
                    Already have an account?
                <a href="signin.html">Log in</a>
                </p>
                
                
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
