
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Sign Up | Join Our IT Support Community</title>
    <meta name="description" content="Sign up for IT Sahayta to access expert IT support services. Join our community and enhance your tech experience.">
    <?php include "assets.php"?>
  
</head>
<body>



<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <div class="logo-container">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="logo-img">
            </div>
            <h2>Sign Up for IT Sahayta</h2>
            <form action="/controllers/AuthController.php?action=signup" method="POST" onsubmit="return validatePassword()">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user icon"></i>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone icon"></i>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Enter 10-digit phone number" required pattern="[0-9]{10}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt icon textarea-icon"></i>
                        <textarea id="address" name="address" placeholder="Enter your address" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" id="password" name="password" placeholder="Create a password" required onkeyup="checkPasswordStrength()">
                    </div>
                    <div id="password-strength" class="password-strength">
                        <span class="strength-bar"></span>
                        <span class="strength-text"></span>
                    </div>
                </div>
                <button type="submit" class="cta-btn">Sign Up</button>
            </form>
            <p class="login-prompt">Already have an account? <a href="/views/login.php" class="login-link">Login</a></p>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>

<style>
/* Signup Section */
.signup-section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #6b48ff 0%, #00ddeb 100%);
    padding: 20px;
}

/* Signup Box */
.signup-box {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 450px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.signup-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, #1a73e8, #ff4d4d);
}

/* Logo Container */
.logo-container {
    margin-bottom: 20px;
}

.logo-img {
    height: 60px;
    transition: transform 0.3s ease;
}

.logo-img:hover {
    transform: scale(1.1);
}

/* Heading */
.signup-box h2 {
    margin-bottom: 20px;
    color: #1a73e8;
    font-size: 24px;
    font-weight: 600;
}

/* Form Group */
.form-group {
    margin-bottom: 25px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
    font-size: 14px;
}

.input-wrapper {
    position: relative;
}

.input-wrapper .icon {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #6b48ff;
    font-size: 16px;
}

.input-wrapper .textarea-icon {
    top: 20px;
    transform: none;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 15px 12px 40px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-group textarea {
    height: 80px;
    resize: none;
    padding-top: 20px;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 8px rgba(26, 115, 232, 0.2);
    outline: none;
}

/* Password Strength Indicator */
.password-strength {
    display: flex;
    align-items: center;
    margin-top: 8px;
    font-size: 14px;
}

.strength-bar {
    width: 50px;
    height: 5px;
    background: #ddd;
    border-radius: 5px;
    margin-right: 10px;
    position: relative;
    overflow: hidden;
}

.strength-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background 0.3s ease;
}

.strength-text {
    font-weight: 500;
}

/* Button */
.cta-btn {
    background: linear-gradient(to right, #1a73e8, #6b48ff);
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    width: 100%;
    transition: all 0.3s ease;
}

.cta-btn:hover {
    background: linear-gradient(to right, #6b48ff, #1a73e8);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
}

/* Login Prompt */
.login-prompt {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

.login-link {
    color: #ff4d4d;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.login-link:hover {
    color: #1a73e8;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 480px) {
    .signup-box {
        padding: 30px 20px;
        max-width: 90%;
    }

    .signup-box h2 {
        font-size: 20px;
    }

    .form-group input,
    .form-group textarea {
        padding: 10px 15px 10px 35px;
        font-size: 13px;
    }

    .cta-btn {
        padding: 10px 15px;
        font-size: 14px;
    }
}
</style>

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    switch (strength) {
        case 0:
        case 1:
            strengthText.textContent = 'Weak';
            strengthText.style.color = 'red';
            strengthBar.style.width = '25%';
            strengthBar.style.background = 'red';
            break;
        case 2:
            strengthText.textContent = 'Moderate';
            strengthText.style.color = 'orange';
            strengthBar.style.width = '50%';
            strengthBar.style.background = 'orange';
            break;
        case 3:
            strengthText.textContent = 'Strong';
            strengthText.style.color = 'blue';
            strengthBar.style.width = '75%';
            strengthBar.style.background = 'blue';
            break;
        case 4:
            strengthText.textContent = 'Very Strong';
            strengthText.style.color = 'green';
            strengthBar.style.width = '100%';
            strengthBar.style.background = 'green';
            break;
    }

    strengthBar.style.width = (strength * 25) + '%';
    strengthBar.style.background = strengthText.style.color;
}

function validatePassword() {
    const password = document.getElementById('password').value;
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    if (strength < 2) {
        alert('Password is too weak! It should be at least 8 characters long, with uppercase, numbers, and special characters.');
        return false;
    }
    return true;
}
</script>