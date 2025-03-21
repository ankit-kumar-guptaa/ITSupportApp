<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Verify OTP</h2>
            <p>An OTP has been sent to your email. Please enter it below.</p>
            <form action="/controllers/AuthController.php?action=verify_otp" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" required>
                </div>
                <button type="submit" class="cta-btn">Verify</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>