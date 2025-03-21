<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

$stmt = $pdo->prepare("SELECT i.*, a.name as agent_name FROM issues i LEFT JOIN agents a ON i.agent_id = a.id WHERE i.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$issues = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Welcome, User!</h2>
            <a href="/views/report_issue.php" class="cta-btn">Report New Issue</a>
            <h3>Your Reported Issues</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($issues as $issue): ?>
                        <tr>
                            <td><?php echo $issue['id']; ?></td>
                            <td><?php echo htmlspecialchars($issue['description']); ?></td>
                            <td><?php echo $issue['category']; ?></td>
                            <td><?php echo $issue['status']; ?></td>
                            <td><?php echo $issue['agent_name'] ?: 'Not Assigned'; ?></td>
                            <td><?php echo $issue['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Extra Functionality: Profile Update -->
            <h3>Update Profile</h3>
            <form action="/controllers/UserController.php?action=update_profile" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <button type="submit" class="cta-btn">Update</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>