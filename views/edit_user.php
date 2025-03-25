<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}
require '../config/db.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: /views/admin_dashboard.php?error=User not found!");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10}$/', $phone_number) || empty($address)) {
        $error = "Please fill all fields correctly!";
    } else {
        // Update user details
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone_number = ?, address = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone_number, $address, $user_id]);

        header("Location: /views/admin_dashboard.php?success=User updated successfully!");
        exit;
    }
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Edit User</h2>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/views/edit_user.php?id=<?php echo $user_id; ?>" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="cta-btn">Update</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>