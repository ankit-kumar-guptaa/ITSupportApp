<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';
?>
<main>
    <section class="auth-section">
        <div class="auth-box" data-aos="fade-up">
            <h2>Sign Up</h2>
            <?php
            // Step 1: Email input and Send OTP
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_otp'])) {
                require_once '../controllers/AuthController.php';
                $auth = new AuthController($pdo);
                $email = $_POST['email'];
                $message = $auth->sendOtp($email);
                echo "<p>$message</p>";
                if ($message == "OTP sent to your email. Please verify.") {
                    $_SESSION['step'] = 'verify_otp';
                }
            }

            // Step 2: OTP Verification
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
                require_once '../controllers/AuthController.php';
                $auth = new AuthController($pdo);
                $otp = $_POST['otp'];
                $message = $auth->verifyOtp($otp);
                echo "<p>$message</p>";
                if ($message == "OTP verified successfully!") {
                    $_SESSION['step'] = 'complete_signup';
                }
            }

            // Step 3: Complete Signup (Name, Mobile, Password)
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_signup'])) {
                require_once '../controllers/AuthController.php';
                $auth = new AuthController($pdo);
                $name = $_POST['name'];
                $mobile = $_POST['mobile'];
                $password = $_POST['password'];
                $message = $auth->completeSignup($name, $mobile, $password);
                echo "<p>$message</p>";
                if ($message == "Signup successful! Please login.") {
                    unset($_SESSION['step']);
                }
            }

            // Display forms based on step
            if (!isset($_SESSION['step']) || $_SESSION['step'] == 'email') {
                // Step 1: Email input
                ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" name="send_otp" class="auth-btn">Send OTP</button>
                </form>
                <?php
            } elseif (isset($_SESSION['step']) && $_SESSION['step'] == 'verify_otp') {
                // Step 2: OTP input
                ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" name="otp" required>
                    </div>
                    <button type="submit" name="verify_otp" class="auth-btn">Verify OTP</button>
                </form>
                <?php
            } elseif (isset($_SESSION['step']) && $_SESSION['step'] == 'complete_signup') {
                // Step 3: Name, Mobile, Password input
                ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" id="mobile" name="mobile" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="complete_signup" class="auth-btn">Complete Signup</button>
                </form>
                <?php
            }
            ?>
            <p>Already have an account? <a href="/ITSupportApp/views/login.php">Login here</a></p>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>