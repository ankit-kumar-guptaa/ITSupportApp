<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}
require '../config/db.php';

// Fetch all users
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all agents
$stmt = $pdo->prepare("SELECT * FROM agents");
$stmt->execute();
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch pending agents
$stmt = $pdo->prepare("SELECT * FROM agents WHERE status = 'pending'");
$stmt->execute();
$pending_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all issues
$stmt = $pdo->prepare("SELECT i.*, u.name as user_name, a.name as agent_name 
                       FROM issues i 
                       LEFT JOIN users u ON i.user_id = u.id 
                       LEFT JOIN agents a ON i.agent_id = a.id");
$stmt->execute();
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages from agents
$stmt = $pdo->prepare("SELECT m.*, a.name as agent_name 
                       FROM messages m 
                       JOIN agents a ON m.sender_id = a.id 
                       WHERE m.recipient_role = 'admin' AND m.recipient_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../views/header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Admin Dashboard</h2>

            <?php if (isset($_GET['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'users')">Users</button>
                <button class="tablinks" onclick="openTab(event, 'agents')">Agents</button>
                <button class="tablinks" onclick="openTab(event, 'pending_agents')">Pending Agents</button>
                <button class="tablinks" onclick="openTab(event, 'issues')">Issues</button>
                <button class="tablinks" onclick="openTab(event, 'messages')">Messages</button>
            </div>

            <!-- Tab Content: Users -->
            <div id="users" class="tab-content active">
                <h3>Manage Users</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone_number'] ?? 'Not provided'); ?></td>
                                    <td><?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?></td>
                                    <td>
                                        <a href="/views/edit_user.php?id=<?php echo $user['id']; ?>" class="cta-btn">Edit</a>
                                        <form action="/controllers/AdminController.php?action=delete_user" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="cta-btn" style="background-color: red;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Content: Agents -->
            <div id="agents" class="tab-content">
                <h3>Manage Agents</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($agents)): ?>
                            <tr>
                                <td colspan="7">No agents found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($agents as $agent): ?>
                                <tr>
                                    <td><?php echo $agent['id']; ?></td>
                                    <td><?php echo htmlspecialchars($agent['name']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['email']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['address'] ?? 'Not provided'); ?></td>
                                    <td><?php echo htmlspecialchars($agent['status']); ?></td>
                                    <td>
                                        <a href="/views/edit_agent.php?id=<?php echo $agent['id']; ?>" class="cta-btn">Edit</a>
                                        <form action="/controllers/AdminController.php?action=delete_agent" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <button type="submit" class="cta-btn" style="background-color: red;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Content: Pending Agents -->
            <div id="pending_agents" class="tab-content">
                <h3>Pending Agents</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Govt ID Type</th>
                            <th>Govt ID Number</th>
                            <th>Govt ID Front</th>
                            <th>Govt ID Back</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pending_agents)): ?>
                            <tr>
                                <td colspan="10">No pending agents.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pending_agents as $agent): ?>
                                <tr>
                                    <td><?php echo $agent['id']; ?></td>
                                    <td><?php echo htmlspecialchars($agent['name']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['email']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['address']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['govt_id_type']); ?></td>
                                    <td><?php echo htmlspecialchars($agent['govt_id_number']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($agent['govt_id_front']); ?>" target="_blank">View</a></td>
                                    <td><a href="<?php echo htmlspecialchars($agent['govt_id_back']); ?>" target="_blank">View</a></td>
                                    <td>
                                        <form action="/controllers/AdminController.php?action=approve_agent" method="POST" style="display:inline;">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <button type="submit" class="cta-btn">Approve</button>
                                        </form>
                                        <form action="/controllers/AdminController.php?action=reject_agent" method="POST" style="display:inline;">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <input type="text" name="reason" placeholder="Reason for rejection" required>
                                            <button type="submit" class="cta-btn" style="background-color: red;">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Content: Issues -->
            <div id="issues" class="tab-content">
                <h3>Manage Issues</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Agent</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($issues)): ?>
                            <tr>
                                <td colspan="8">No issues found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($issues as $issue): ?>
                                <tr>
                                    <td><?php echo $issue['id']; ?></td>
                                    <td><?php echo htmlspecialchars($issue['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['description']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['category']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['status']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['agent_name'] ?? 'Not Assigned'); ?></td>
                                    <td><?php echo $issue['created_at']; ?></td>
                                    <td>
                                        <!-- Assign Agent -->
                                        <form action="/controllers/AdminController.php?action=assign_issue" method="POST" style="display:inline;">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <select name="agent_id">
                                                <option value="">Select Agent</option>
                                                <?php foreach ($agents as $agent): ?>
                                                    <?php if ($agent['status'] === 'approved'): ?>
                                                        <option value="<?php echo $agent['id']; ?>" <?php echo $issue['agent_id'] == $agent['id'] ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($agent['name']); ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="cta-btn">Assign</button>
                                        </form>
                                        <!-- Update Status -->
                                        <form action="/controllers/AdminController.php?action=update_issue_status" method="POST" style="display:inline;">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <select name="status">
                                                <option value="pending" <?php echo $issue['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="in_progress" <?php echo $issue['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                                <option value="resolved" <?php echo $issue['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                                <option value="escalated" <?php echo $issue['status'] == 'escalated' ? 'selected' : ''; ?>>Escalated</option>
                                            </select>
                                            <button type="submit" class="cta-btn">Update</button>
                                        </form>
                                        <!-- Delete Issue -->
                                        <form action="/controllers/AdminController.php?action=delete_issue" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this issue?');">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <button type="submit" class="cta-btn" style="background-color: red;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Content: Messages -->
            <div id="messages" class="tab-content">
                <h3>Messages</h3>
                <h4>Messages from Agents</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Agent Name</th>
                            <th>Message</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($messages)): ?>
                            <tr>
                                <td colspan="3">No messages from agents.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['agent_name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo $message['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h4>Send Message to Agent</h4>
                <form action="/controllers/AdminController.php?action=send_message" method="POST">
                    <div class="form-group">
                        <label for="agent_id">Select Agent</label>
                        <select id="agent_id" name="agent_id" required>
                            <option value="">Select Agent</option>
                            <?php foreach ($agents as $agent): ?>
                                <?php if ($agent['status'] === 'approved'): ?>
                                    <option value="<?php echo $agent['id']; ?>"><?php echo htmlspecialchars($agent['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="cta-btn">Send</button>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
function openTab(evt, tabName) {
    var tabcontent = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }

    var tablinks = document.getElementsByClassName("tablinks");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<?php include '../views/footer.php'; ?>