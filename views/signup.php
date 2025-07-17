<?php
// Start session at the very top before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Sign Up | Enterprise IT Support Portal</title>
    <meta name="description" content="Register for enterprise IT support services and access our technical expertise">
    <?php include "assets.php"?>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --success: #4cc9f0;
            --danger: #f72585;
            --dark: #212529;
            --light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light);
            color: var(--dark);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        
        .signup-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        /* Left Side - Creative Visual */
        .signup-visual {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: none;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        @media (min-width: 992px) {
            .signup-visual {
                display: flex;
            }
        }
        
        .visual-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            opacity: 0.15;
        }
        
        .visual-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            max-width: 500px;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 16px;
            backdrop-filter: blur(5px);
        }
        
        .visual-content h2 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .visual-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .tech-icons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .tech-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: var(--transition);
        }
        
        .tech-icon:hover {
            transform: translateY(-5px) scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Right Side - Modern Signup Form */
        .signup-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }
        
        .signup-form-box {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 500px;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }
        
        .form-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            opacity: 0.1;
        }
        
        .decoration-1 {
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
        }
        
        .decoration-2 {
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, var(--success) 0%, transparent 70%);
        }
        
        .form-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-logo img {
            height: 65px;
            transition: transform 0.3s ease;
        }
        
        .form-logo img:hover {
            transform: scale(1.05);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-header h1 {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: var(--dark);
            font-size: 0.95rem;
            opacity: 0.8;
        }
        
        .form-group {
            margin-bottom: 1.75rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--dark);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: -25px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        .textarea-icon {
            top: 1.25rem;
            transform: none;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3.25rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: var(--transition);
            background-color: var(--light);
        }
        
        .form-textarea {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3.25rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: var(--transition);
            background-color: var(--light);
            height: 100px;
            resize: none;
        }
        
        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            outline: none;
            background-color: var(--white);
        }
        
        /* Password Strength Indicator */
        .password-strength {
            display: flex;
            align-items: center;
            margin-top: 0.75rem;
        }
        
        .strength-bar {
            flex: 1;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin-right: 0.75rem;
            overflow: hidden;
        }
        
        .strength-progress {
            height: 100%;
            width: 0;
            transition: var(--transition);
        }
        
        .strength-text {
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .strength-weak {
            background-color: var(--danger);
        }
        
        .strength-moderate {
            background-color: #ffb703;
        }
        
        .strength-strong {
            background-color: var(--accent);
        }
        
        .strength-very-strong {
            background-color: #2ec4b6;
        }
        
        .signup-btn {
            width: 100%;
            padding: 1.1rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.75rem;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .signup-btn:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--secondary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: var(--dark);
        }
        
        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .form-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .signup-form-box {
                padding: 2.5rem 2rem;
            }
            
            .form-header h1 {
                font-size: 1.6rem;
            }
        }
        
        @media (max-width: 576px) {
            .signup-form-box {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }
            
            .form-input,
            .form-textarea {
                padding: 0.9rem 1rem 0.9rem 3rem;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="signup-wrapper">
    <!-- Creative Visual Section -->
    <div class="signup-visual">
        <div class="visual-overlay"></div>
        <div class="visual-content">
            <h2>Enterprise IT Solutions</h2>
            <p>Join our network of professionals and get access to premium IT support services</p>
            <img src="https://cdn-icons-png.flaticon.com/512/2885/2885253.png" alt="IT Support" style="width: 180px; margin: 0 auto 1.5rem;">
            
            <div class="tech-icons">
                <div class="tech-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="tech-icon"><i class="fas fa-server"></i></div>
                <div class="tech-icon"><i class="fas fa-cloud"></i></div>
                <div class="tech-icon"><i class="fas fa-network-wired"></i></div>
                <div class="tech-icon"><i class="fas fa-database"></i></div>
            </div>
        </div>
    </div>
    
    <!-- Modern Signup Form -->
    <div class="signup-form-container">
        <div class="signup-form-box">
            <div class="form-decoration decoration-1"></div>
            <div class="form-decoration decoration-2"></div>
            
            <div class="form-logo">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo">
            </div>
            
            <div class="form-header">
                <h1>Create Account</h1>
                <p>Register to access our IT support services</p>
            </div>
            
            <form action="/controllers/AuthController.php?action=signup" method="POST" onsubmit="return validatePassword()">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" id="phone_number" name="phone_number" class="form-input" placeholder="Enter 10-digit phone number" required pattern="[0-9]{10}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt input-icon textarea-icon"></i>
                        <textarea id="address" name="address" class="form-textarea" placeholder="Enter your address" required></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Create a password" required onkeyup="checkPasswordStrength()">
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-progress" id="strength-progress"></div>
                        </div>
                        <span class="strength-text" id="strength-text">Weak</span>
                    </div>
                </div>
                
                <button type="submit" class="signup-btn">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Create Account
                </button>
            </form>
            
            <div class="form-footer">
                Already have an account? <a href="/views/login.php" class="login-link">Sign In</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthProgress = document.getElementById('strength-progress');
    const strengthText = document.getElementById('strength-text');
    let strength = 0;

    // Check password length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Check for uppercase letters
    if (/[A-Z]/.test(password)) strength++;
    
    // Check for numbers
    if (/[0-9]/.test(password)) strength++;
    
    // Check for special characters
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Update UI
    const width = (strength / 5) * 100;
    strengthProgress.style.width = width + '%';

    if (strength <= 1) {
        strengthText.textContent = 'Weak';
        strengthText.style.color = '#f72585';
        strengthProgress.className = 'strength-progress strength-weak';
    } else if (strength <= 3) {
        strengthText.textContent = 'Moderate';
        strengthText.style.color = '#ffb703';
        strengthProgress.className = 'strength-progress strength-moderate';
    } else if (strength === 4) {
        strengthText.textContent = 'Strong';
        strengthText.style.color = '#4895ef';
        strengthProgress.className = 'strength-progress strength-strong';
    } else {
        strengthText.textContent = 'Very Strong';
        strengthText.style.color = '#2ec4b6';
        strengthProgress.className = 'strength-progress strength-very-strong';
    }
}

function validatePassword() {
    const password = document.getElementById('password').value;
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    if (strength < 2 || password.length < 8) {
        alert('Password must be at least 8 characters long and include a mix of uppercase letters, numbers, and special characters.');
        return false;
    }
    return true;
}
</script>
</body>
</html>