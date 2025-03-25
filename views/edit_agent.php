<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}
require '../config/db.php';

$agent_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch agent details
$stmt = $pdo->prepare("SELECT * FROM agents WHERE id = ?");
$stmt->execute([$agent_id]);
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agent) {
    header("Location: /views/admin_dashboard.php?error=Agent not found!");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10}$/', $phone_number) || empty($address) || !in_array($status, ['pending', 'approved', 'rejected'])) {
        $error = "Please fill all fields correctly!";
    } else {
        // Update agent details
        $stmt = $pdo->prepare("UPDATE agents SET name = ?, email = ?, phone_number = ?, address = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone_number, $address, $status, $agent_id]);

        header("Location: /views/admin_dashboard.php?success=Agent updated successfully!");
        exit;
    }
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Edit Agent</h2>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/views/edit_agent.php?id=<?php echo $agent_id; ?>" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($agent['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($agent['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" value="<?php echo htmlspecialchars($agent['phone_number']); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($agent['address'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="pending" <?php echo $agent['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo $agent['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $agent['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                <button type="submit" class="cta-btn">Update</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>