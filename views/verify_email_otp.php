<?php
session_start();
if (!isset($_SESSION['pending_email_update'])) {
    header("Location: /views/user_dashboard.php?error=Invalid request!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Verify Email OTP | Secure Your Account</title>
    <meta name="description" content="Verify your OTP for email update at IT Sahayta. Ensure secure and successful email verification with our easy OTP process.">
    <?php include "assets.php"?>
  
</head>
<body>


<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Verify OTP for Email Update</h2>

            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <p>An OTP has been sent to your current email: <strong><?php echo htmlspecialchars($_SESSION['pending_email_update']['current_email']); ?></strong>. Please enter the OTP below to verify your email update.</p>

            <form action="/controllers/UserController.php?action=verify_email_otp" method="POST">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" required placeholder="Enter 6-digit OTP">
                </div>
                <button type="submit" class="cta-btn">Verify OTP</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>