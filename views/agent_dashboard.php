<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

// Fetch agent details using email from users table
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ? AND role = 'agent'");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    // If user not found, redirect to login
    header("Location: /views/login.php?error=Agent not found");
    exit;
}

$agent_email = $user['email'];

// Fetch agent details from agents table using email
$stmt = $pdo->prepare("SELECT * FROM agents WHERE email = ?");
$stmt->execute([$agent_email]);
$agent = $stmt->fetch();

// Fetch agent ID for assigned issues
$agent_id = $agent ? $agent['id'] : null;

if (!$agent_id) {
    // If agent not found in agents table, show error
    $issues = [];
} else {
    // Fetch assigned issues with user details
    $stmt = $pdo->prepare("SELECT i.*, u.name as user_name, u.email as user_email, u.phone_number as user_phone, u.address as user_address FROM issues i JOIN users u ON i.user_id = u.id WHERE i.agent_id = ?");
    $stmt->execute([$agent_id]);
    $issues = $stmt->fetchAll();
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Welcome, Agent!</h2>
            <h3>Assigned Issues</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>User Email</th>
                        <th>User Phone</th>
                        <th>User Address</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($issues)): ?>
                        <tr>
                            <td colspan="9">No issues assigned to you yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($issues as $issue): ?>
                            <tr>
                                <td><?php echo $issue['id']; ?></td>
                                <td>
                                    <?php
                                    if ($issue['show_user_details']) {
                                        echo htmlspecialchars($issue['user_name']);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($issue['show_user_details']) {
                                        echo htmlspecialchars($issue['user_email']);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($issue['show_user_details']) {
                                        echo htmlspecialchars($issue['user_phone']);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($issue['show_user_details']) {
                                        echo htmlspecialchars($issue['user_address']);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($issue['description']); ?></td>
                                <td><?php echo $issue['category']; ?></td>
                                <td><?php echo $issue['status']; ?></td>
                                <td>
                                    <form action="/controllers/AgentController.php?action=update_status" method="POST">
                                        <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                        <select name="status">
                                            <option value="Pending" <?php echo $issue['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="In Progress" <?php echo $issue['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Resolved" <?php echo $issue['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                        <button type="submit" class="cta-btn">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Extra Functionality: View Profile -->
            <h3>Your Profile</h3>
            <?php if ($agent): ?>
                <p>Name: <?php echo htmlspecialchars($agent['name']); ?></p>
                <p>Specialization: <?php echo htmlspecialchars($agent['specialization']); ?></p>
            <?php else: ?>
                <p>Profile details not found.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>