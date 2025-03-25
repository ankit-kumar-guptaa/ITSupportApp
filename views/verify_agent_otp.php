<?php
session_start();
require '../config/db.php';

// Set time zone
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['pending_agent_registration'])) {
    header("Location: /views/register_agent.php?error=Invalid request!");
    exit;
}

$email = $_SESSION['pending_agent_registration']['email'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['resend_otp'])) {
        // Resend OTP
        $otp = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Delete old OTPs for this email and action
        $stmt = $pdo->prepare("DELETE FROM otps WHERE email = ? AND action = 'agent_registration'");
        $stmt->execute([$email]);

        // Save new OTP to database
        $stmt = $pdo->prepare("INSERT INTO otps (email, otp, expires_at, action) VALUES (?, ?, ?, 'agent_registration')");
        $stmt->execute([$email, $otp, $expires_at]);

        // Send OTP via email
        $subject = "New OTP for Agent Registration - IT Support Hub";
        $body = "Dear {$_SESSION['pending_agent_registration']['name']},<br><br>Your new OTP for agent registration is: <b>$otp</b>. It is valid for 5 minutes.<br><br>Thank you,<br>IT Support Hub Team";
        if (sendEmail($email, $subject, $body)) {
            $success = "A new OTP has been sent to your email!";
        } else {
            $error = "Failed to send OTP. Please try again.";
        }
    } else {
        // Verify OTP
        $otp = trim($_POST['otp']); // Trim to remove any spaces

        // Debug: Check what OTPs are in the database
        $stmt = $pdo->prepare("SELECT * FROM otps WHERE email = ? AND action = 'agent_registration'");
        $stmt->execute([$email]);
        $otp_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("OTP Records: " . print_r($otp_records, true)); // Log for debugging

        // Check OTP
        $stmt = $pdo->prepare("SELECT * FROM otps WHERE email = ? AND otp = ? AND expires_at > NOW() AND action = 'agent_registration'");
        $stmt->execute([$email, $otp]);
        $otp_record = $stmt->fetch();

        if ($otp_record) {
            // OTP verified, save agent to database
            $stmt = $pdo->prepare("INSERT INTO agents (name, email, phone_number, address, govt_id_type, govt_id_number, govt_id_front, govt_id_back, password, status) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->execute([
                $_SESSION['pending_agent_registration']['name'],
                $_SESSION['pending_agent_registration']['email'],
                $_SESSION['pending_agent_registration']['phone_number'],
                $_SESSION['pending_agent_registration']['address'],
                $_SESSION['pending_agent_registration']['govt_id_type'],
                $_SESSION['pending_agent_registration']['govt_id_number'],
                $_SESSION['pending_agent_registration']['govt_id_front'],
                $_SESSION['pending_agent_registration']['govt_id_back'],
                $_SESSION['pending_agent_registration']['password']
            ]);

            // Delete OTP
            $stmt = $pdo->prepare("DELETE FROM otps WHERE email = ? AND action = 'agent_registration'");
            $stmt->execute([$email]);

            // Clear session
            unset($_SESSION['pending_agent_registration']);

            header("Location: /views/login.php?success=Registration successful! Please wait for admin approval.");
            exit;
        } else {
            $error = "Invalid or expired OTP!";
        }
    }
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Verify OTP for Agent Registration</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <p>An OTP has been sent to your email: <strong><?php echo htmlspecialchars($_SESSION['pending_agent_registration']['email']); ?></strong>. Please enter the OTP below to complete your registration. The OTP is valid for 5 minutes.</p>

            <form action="/views/verify_agent_otp.php" method="POST">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" required placeholder="Enter 6-digit OTP">
                </div>
                <button type="submit" class="cta-btn">Verify OTP</button>
            </form>

            <form action="/views/verify_agent_otp.php" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="resend_otp" value="1">
                <button type="submit" class="cta-btn" style="background-color: #007bff;">Resend OTP</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>