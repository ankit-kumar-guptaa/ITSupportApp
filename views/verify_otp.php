<?php include 'header.php'; ?>
<main class="otp-verification">
    <section class="otp-section">
        <div class="otp-card" data-aos="fade-up">
            <div class="otp-header">
                <div class="otp-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h2>Verify Your Identity</h2>
                <p class="otp-subtext">We've sent a 6-digit code to <span class="highlight"><?php echo htmlspecialchars($_GET['email']); ?></span></p>
            </div>

            <form class="otp-form" action="/controllers/AuthController.php?action=verify_otp" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                
                <div class="otp-input-group">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Code expires in: <strong>04:59</strong></span>
                    </div>
                </div>

                <button type="submit" class="verify-btn">
                    Verify & Continue
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </form>

            <div class="otp-footer">
                <p>Didn't receive code? <a href="#" class="resend-link">Resend OTP</a></p>
            </div>
        </div>
    </section>
</main>

<style>
/* OTP Verification Styles */
.otp-verification {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e9f2f9 100%);
    padding: 20px;
}

.otp-section {
    width: 100%;
    max-width: 440px;
}

.otp-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    padding: 40px;
    text-align: center;
    transition: transform 0.3s ease;
}

.otp-card:hover {
    transform: translateY(-5px);
}

.otp-header {
    margin-bottom: 32px;
}

.otp-icon {
    width: 64px;
    height: 64px;
    background: rgba(74, 108, 247, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.otp-icon svg {
    color: #4a6cf7;
    width: 28px;
    height: 28px;
}

.otp-header h2 {
    color: #2d3748;
    font-size: 1.8rem;
    margin-bottom: 8px;
    font-weight: 700;
}

.otp-subtext {
    color: #718096;
    font-size: 1rem;
    line-height: 1.5;
}

.highlight {
    color: #2d3748;
    font-weight: 600;
}

.otp-input-group {
    margin-bottom: 32px;
}

.otp-inputs {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}

.otp-inputs input {
    width: 48px;
    height: 56px;
    text-align: center;
    font-size: 1.4rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.3s ease;
    background-color: #f8fafc;
}

.otp-inputs input:focus {
    border-color: #4a6cf7;
    box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
    outline: none;
    background-color: white;
}

.otp-timer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    color: #718096;
    font-size: 0.9rem;
}

.otp-timer svg {
    width: 16px;
    height: 16px;
}

.otp-timer strong {
    color: #e53e3e;
    font-weight: 600;
}

.verify-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #4a6cf7 0%, #254eda 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.verify-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 108, 247, 0.3);
}

.verify-btn:active {
    transform: translateY(0);
}

.otp-footer {
    margin-top: 24px;
    color: #718096;
    font-size: 0.95rem;
}

.resend-link {
    color: #4a6cf7;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.resend-link:hover {
    color: #254eda;
    text-decoration: underline;
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .otp-card {
        padding: 30px 24px;
    }
    
    .otp-inputs input {
        width: 42px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .otp-icon {
        width: 56px;
        height: 56px;
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
    const timerElement = document.querySelector('.otp-timer strong');
    
    const timer = setInterval(function() {
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (seconds === 0) {
            if (minutes === 0) {
                clearInterval(timer);
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