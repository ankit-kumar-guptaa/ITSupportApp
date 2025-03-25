<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (empty($password)) {
        $error = "Password is required!";
    } else {
        // Check if agent exists
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE email = ?");
        $stmt->execute([$email]);
        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agent) {
            // Verify password
            if (password_verify($password, $agent['password'])) {
                // Check if agent is approved
                if ($agent['status'] !== 'approved') {
                    $error = "Your account is not approved yet. Please wait for admin approval.";
                } else {
                    // Set session variables
                    $_SESSION['user_id'] = $agent['id'];
                    $_SESSION['role'] = 'agent';
                    $_SESSION['name'] = $agent['name'];

                    // Redirect to agent dashboard
                    header("Location: /views/agent_dashboard.php?success=Login successful!");
                    exit;
                }
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Agent Login</h2>

            <?php if (isset($_GET['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/views/agent_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="cta-btn">Login</button>
            </form>

            <p style="margin-top: 20px;">Don't have an account? <a href="/views/register_agent.php">Register as an Agent</a></p>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>