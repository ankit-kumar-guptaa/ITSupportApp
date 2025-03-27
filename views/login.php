<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <div class="logo-container">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="logo-img">
            </div>
            <h2>Login to IT Sahayta</h2>
            <?php if (isset($_GET['success'])): ?>
                <p class="success-message"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <form action="/controllers/AuthController.php?action=login" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <button type="submit" class="cta-btn">Login</button>
            </form>
            <p class="signup-prompt">Don't have an account? <a href="/views/signup.php" class="signup-link">Sign Up</a></p>
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
    max-width: 400px;
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

.form-group input {
    width: 100%;
    padding: 12px 15px 12px 40px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-group input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 8px rgba(26, 115, 232, 0.2);
    outline: none;
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

/* Success Message */
.success-message {
    color: #34c759;
    margin: 10px 0;
    font-size: 14px;
    font-weight: 500;
}

/* Signup Prompt */
.signup-prompt {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

.signup-link {
    color: #ff4d4d;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.signup-link:hover {
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

    .form-group input {
        padding: 10px 15px 10px 35px;
        font-size: 13px;
    }

    .cta-btn {
        padding: 10px 15px;
        font-size: 14px;
    }
}
</style>