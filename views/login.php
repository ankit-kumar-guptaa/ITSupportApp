<?php include 'header.php'; ?>
<style>
    /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Signup Section */
.signup-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(to right, #6a11cb, #2575fc);
}

.signup-box {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

.signup-box h2 {
    margin-bottom: 20px;
    color: #333;
}

.signup-box p {
    margin: 10px 0;
    font-size: 14px;
}

/* Form Group */
.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.form-group input:focus {
    border-color: #6a11cb;
    outline: none;
}

/* Button */
.cta-btn {
    background-color: #6a11cb;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.cta-btn:hover {
    background-color: #2575fc;
}

/* Success Message */
.success-message {
    color: green;
    margin: 10px 0;
}
</style>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Login</h2>
            <?php if (isset($_GET['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <form action="/controllers/AuthController.php?action=login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="cta-btn">Login</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>