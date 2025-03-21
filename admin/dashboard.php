<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

$issues = $pdo->query("SELECT i.*, u.name as user_name, a.name as agent_name FROM issues i JOIN users u ON i.user_id = u.id LEFT JOIN agents a ON i.agent_id = a.id")->fetchAll();
$agents = $pdo->query("SELECT * FROM agents")->fetchAll();
$users = $pdo->query("SELECT * FROM users WHERE role = 'user'")->fetchAll();
$all_agents = $pdo->query("SELECT * FROM agents")->fetchAll();
?>

<?php include '../views/header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Admin Dashboard</h2>

            <!-- All Issues -->
            <h3>All Issues</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Assign Agent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($issues as $issue): ?>
                        <tr>
                            <td><?php echo $issue['id']; ?></td>
                            <td><?php echo htmlspecialchars($issue['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($issue['description']); ?></td>
                            <td><?php echo $issue['category']; ?></td>
                            <td><?php echo $issue['status']; ?></td>
                            <td><?php echo $issue['agent_name'] ?: 'Not Assigned'; ?></td>
                            <td>
                                <form action="/controllers/AdminController.php?action=assign_agent" method="POST">
                                    <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                    <select name="agent_id">
                                        <option value="">Select Agent</option>
                                        <?php foreach ($agents as $agent): ?>
                                            <option value="<?php echo $agent['id']; ?>" <?php echo $issue['agent_id'] == $agent['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($agent['name']) . " (" . $agent['specialization'] . ")"; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="cta-btn">Assign</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- All Users -->
            <h3>All Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form action="/controllers/AdminController.php?action=delete_user" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="cta-btn" style="background: #EF4444;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- All Agents -->
            <h3>All Agents</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_agents as $agent): ?>
                        <tr>
                            <td><?php echo $agent['id']; ?></td>
                            <td><?php echo htmlspecialchars($agent['name']); ?></td>
                            <td><?php echo htmlspecialchars($agent['email']); ?></td>
                            <td><?php echo htmlspecialchars($agent['specialization']); ?></td>
                            <td>
                                <form action="/controllers/AdminController.php?action=delete_agent" method="POST" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                    <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                    <button type="submit" class="cta-btn" style="background: #EF4444;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include '../views/footer.php'; ?>