<?php
session_start();
require '../config/db.php';
require '../config/email.php';

// Set time zone
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['pending_agent_registration'])) {
    header("Location: /views/register_agent.php?error=Invalid request!");
    exit;
}

$email = $_SESSION['pending_agent_registration']['email'];
$error = '';
$success = '';

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
        $otp = trim($_POST['otp']);

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

<main class="otp-verification-page">
    <div class="otp-container">
        <div class="otp-card">
            <div class="otp-header">
                <div class="otp-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
    <polyline points="22,6 12,13 2,6"></polyline>
</svg>
                </div>
                <h2>Verify OTP</h2>
                <p class="otp-subtext">Enter the 6-digit code sent to <span class="otp-email"><?php echo htmlspecialchars($email); ?></span></p>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
            </div>

            <form class="otp-form" method="POST" action="/views/verify_agent_otp.php">
                <div class="otp-inputs">
                    <input type="text" name="otp1" maxlength="1" pattern="\d" required autofocus>
                    <input type="text" name="otp2" maxlength="1" pattern="\d" required>
                    <input type="text" name="otp3" maxlength="1" pattern="\d" required>
                    <input type="text" name="otp4" maxlength="1" pattern="\d" required>
                    <input type="text" name="otp5" maxlength="1" pattern="\d" required>
                    <input type="text" name="otp6" maxlength="1" pattern="\d" required>
                    <input type="hidden" name="otp" id="full-otp">
                </div>

                <div class="otp-timer">
                    <span>OTP valid for: </span>
                    <span class="timer">05:00</span>
                </div>

                <button type="submit" class="otp-button verify-btn">Verify OTP</button>
            </form>

            <form class="otp-resend-form" method="POST" action="/views/verify_agent_otp.php">
                <input type="hidden" name="resend_otp" value="1">
                <button type="submit" class="otp-button resend-btn">Resend OTP</button>
            </form>
        </div>
    </div>
</main>

<style>
/* OTP Verification Styles */
.otp-verification-page {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
    padding: 20px;
}

.otp-container {
    width: 100%;
    max-width: 420px;
}

.otp-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 40px;
    text-align: center;
    transition: transform 0.3s ease;
}

.otp-card:hover {
    transform: translateY(-5px);
}

.otp-header {
    margin-bottom: 30px;
}

.otp-icon {
    width: 60px;
    height: 60px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}

.otp-icon svg {
    width: 24px;
    height: 24px;
    color: #3498db;
}

.otp-header h2 {
    color: #2c3e50;
    font-size: 1.8rem;
    margin-bottom: 10px;
    font-weight: 700;
}

.otp-subtext {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin-bottom: 0;
}

.otp-email {
    color: #2c3e50;
    font-weight: 600;
}

.alert {
    padding: 12px 15px;
    border-radius: 8px;
    margin: 20px 0;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-error {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border-left: 3px solid #e74c3c;
}

.alert-success {
    background: rgba(46, 204, 113, 0.1);
    color: #2ecc71;
    border-left: 3px solid #2ecc71;
}

.alert i {
    margin-right: 8px;
}

.otp-form {
    margin-bottom: 20px;
}

.otp-inputs {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    gap: 10px;
}

.otp-inputs input {
    width: 45px;
    height: 55px;
    text-align: center;
    font-size: 1.4rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.otp-inputs input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    outline: none;
    background-color: white;
}

.otp-timer {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.timer {
    color: #e74c3c;
    font-weight: 600;
}

.otp-button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
}

.verify-btn {
    background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
    color: white;
}

.verify-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.resend-btn {
    background: white;
    color: #3498db;
    border: 2px solid #3498db;
}

.resend-btn:hover {
    background: rgba(52, 152, 219, 0.05);
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .otp-card {
        padding: 30px 20px;
    }
    
    .otp-inputs input {
        width: 40px;
        height: 50px;
        font-size: 1.2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus first OTP input
    const otpInputs = document.querySelectorAll('.otp-inputs input');
    otpInputs[0].focus();
    
    // Handle OTP input navigation
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value.length === 0) {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });
    });
    
    // Combine OTP digits before form submission
    const otpForm = document.querySelector('.otp-form');
    otpForm.addEventListener('submit', function(e) {
        const fullOtp = Array.from(otpInputs).map(input => input.value).join('');
        document.getElementById('full-otp').value = fullOtp;
    });
    
    // Timer countdown
    let minutes = 4;
    let seconds = 59;
    const timerElement = document.querySelector('.timer');
    
    const timer = setInterval(function() {
        if (seconds < 10) {
            timerElement.textContent = `0${minutes}:0${seconds}`;
        } else {
            timerElement.textContent = `0${minutes}:${seconds}`;
        }
        
        if (seconds === 0) {
            if (minutes === 0) {
                clearInterval(timer);
                timerElement.textContent = "00:00";
                timerElement.style.color = "#e74c3c";
                return;
            }
            minutes--;
            seconds = 59;
        } else {
            seconds--;
        }
    }, 1000);
});
</script>

<?php include 'footer.php'; ?>