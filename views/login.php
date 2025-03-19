<?php include 'header.php'; ?>
<main>
    <section class="auth-section">
        <div class="auth-box" data-aos="fade-up">
            <h2>Login</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                require_once '../controllers/AuthController.php';
                $auth = new AuthController($pdo);
                $email = $_POST['email'];
                $password = $_POST['password'];
                $message = $auth->login($email, $password);
                echo "<p>$message</p>";
                if ($message == "Login successful!") {
                    header("Location: /ITSupportApp/");
                    exit();
                }
            }
            ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="auth-btn">Login</button>
            </form>
            <p>Don't have an account? <a href="/ITSupportApp/views/signup.php">Sign up here</a></p>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>