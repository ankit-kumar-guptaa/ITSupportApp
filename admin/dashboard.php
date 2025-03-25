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
// Check for filtered users from search/sort
$users = isset($_SESSION['filtered_users']) ? $_SESSION['filtered_users'] : $users;

// Fetch all agents
$stmt = $pdo->prepare("SELECT * FROM agents");
$stmt->execute();
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered agents from search/sort
$agents = isset($_SESSION['filtered_agents']) ? $_SESSION['filtered_agents'] : $agents;

// Fetch pending agents
$stmt = $pdo->prepare("SELECT * FROM agents WHERE status = 'pending'");
$stmt->execute();
$pending_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered pending agents from search/sort
$pending_agents = isset($_SESSION['filtered_pending_agents']) ? $_SESSION['filtered_pending_agents'] : $pending_agents;

// Fetch all issues
$stmt = $pdo->prepare("SELECT i.*, u.name as user_name, a.name as agent_name 
                       FROM issues i 
                       LEFT JOIN users u ON i.user_id = u.id 
                       LEFT JOIN agents a ON i.agent_id = a.id");
$stmt->execute();
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered issues from search/sort
$issues = isset($_SESSION['filtered_issues']) ? $_SESSION['filtered_issues'] : $issues;

// Fetch messages from agents
$stmt = $pdo->prepare("SELECT m.*, a.name as agent_name 
                       FROM messages m 
                       JOIN agents a ON m.sender_id = a.id 
                       WHERE m.recipient_role = 'admin' AND m.recipient_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered messages from search/sort
$messages = isset($_SESSION['filtered_messages']) ? $_SESSION['filtered_messages'] : $messages;

// Fetch activity logs
$stmt = $pdo->prepare("SELECT al.*, u.name as user_name 
                       FROM activity_logs al 
                       LEFT JOIN users u ON al.user_id = u.id AND al.role = 'user' 
                       LEFT JOIN agents a ON al.user_id = a.id AND al.role = 'agent'");
$stmt->execute();
$activity_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered activity logs from search/sort
$activity_logs = isset($_SESSION['filtered_activity_logs']) ? $_SESSION['filtered_activity_logs'] : $activity_logs;

// Fetch feedback
$stmt = $pdo->prepare("SELECT f.*, i.description as issue_description, u.name as user_name 
                       FROM feedback f 
                       JOIN issues i ON f.issue_id = i.id 
                       JOIN users u ON f.user_id = u.id");
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Check for filtered feedback from search/sort
$feedbacks = isset($_SESSION['filtered_feedbacks']) ? $_SESSION['filtered_feedbacks'] : $feedbacks;

// Clear session variables after use (optional, to avoid stale data)
unset($_SESSION['filtered_users']);
unset($_SESSION['filtered_agents']);
unset($_SESSION['filtered_pending_agents']);
unset($_SESSION['filtered_issues']);
unset($_SESSION['filtered_messages']);
unset($_SESSION['filtered_activity_logs']);
unset($_SESSION['filtered_feedbacks']);
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
                <button class="tablinks" onclick="openTab(event, 'activity_logs')">Activity Logs</button>
                <button class="tablinks" onclick="openTab(event, 'feedback')">Feedback</button>
                <button class="tablinks" onclick="openTab(event, 'statistics')">Statistics</button>
</div>
           

            <!-- Tab Content: Users -->
            <!-- Tab Content: Users -->
            <div id="users" class="tab-content active">
                <h3>Manage Users</h3>

                <!-- Search and Sort -->
               <!-- Search and Sort -->
<form method="GET" action="../controllers/AdminController.php" style="margin-bottom: 20px;">
    <input type="hidden" name="action" value="search_sort_users">
    <div class="form-group" style="display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search_users" placeholder="Search by name or email" value="<?php echo isset($_GET['search_users']) ? htmlspecialchars($_GET['search_users']) : ''; ?>">
        <select name="sort_users">
            <option value="name_asc" <?php echo isset($_GET['sort_users']) && $_GET['sort_users'] == 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
            <option value="name_desc" <?php echo isset($_GET['sort_users']) && $_GET['sort_users'] == 'name_desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
            <option value="created_at_asc" <?php echo isset($_GET['sort_users']) && $_GET['sort_users'] == 'created_at_asc' ? 'selected' : ''; ?>>Created At (Oldest First)</option>
            <option value="created_at_desc" <?php echo isset($_GET['sort_users']) && $_GET['sort_users'] == 'created_at_desc' ? 'selected' : ''; ?>>Created At (Newest First)</option>
        </select>
        <button type="submit" class="cta-btn">Search/Sort</button>
    </div>
</form>

                <?php
                // Fetch users with search and sort
                $search_users = isset($_GET['search_users']) ? $_GET['search_users'] : '';
                $sort_users = isset($_GET['sort_users']) ? $_GET['sort_users'] : 'name_asc';

                $query = "SELECT * FROM users WHERE 1=1";
                $params = [];

                if (!empty($search_users)) {
                    $query .= " AND (name LIKE ? OR email LIKE ?)";
                    $params[] = "%$search_users%";
                    $params[] = "%$search_users%";
                }

                if ($sort_users == 'name_asc') {
                    $query .= " ORDER BY name ASC";
                } elseif ($sort_users == 'name_desc') {
                    $query .= " ORDER BY name DESC";
                } elseif ($sort_users == 'created_at_asc') {
                    $query .= " ORDER BY created_at ASC";
                } elseif ($sort_users == 'created_at_desc') {
                    $query .= " ORDER BY created_at DESC";
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

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
                                        <form action="/controllers/AdminController.php?action=delete_user" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                                        <form action="/controllers/AdminController.php?action=delete_agent" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this agent?');">
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
                                    <td><a href="<?php echo htmlspecialchars($agent['govt_id_front']); ?>"
                                            target="_blank">View</a></td>
                                    <td><a href="<?php echo htmlspecialchars($agent['govt_id_back']); ?>"
                                            target="_blank">View</a></td>
                                    <td>
                                        <form action="/controllers/AdminController.php?action=approve_agent" method="POST"
                                            style="display:inline;">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <button type="submit" class="cta-btn">Approve</button>
                                        </form>
                                        <form action="/controllers/AdminController.php?action=reject_agent" method="POST"
                                            style="display:inline;">
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
            <!-- Tab Content: Issues -->
            <div id="issues" class="tab-content">
                <h3>Manage Issues</h3>

                <!-- Search and Sort -->
                <form method="GET" action="/views/admin_dashboard.php" style="margin-bottom: 20px;">
                    <div class="form-group" style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" name="search_issues" placeholder="Search by description or user name"
                            value="<?php echo isset($_GET['search_issues']) ? htmlspecialchars($_GET['search_issues']) : ''; ?>">
                        <select name="sort_issues">
                            <option value="created_at_desc" <?php echo isset($_GET['sort_issues']) && $_GET['sort_issues'] == 'created_at_desc' ? 'selected' : ''; ?>>Created At (Newest First)
                            </option>
                            <option value="created_at_asc" <?php echo isset($_GET['sort_issues']) && $_GET['sort_issues'] == 'created_at_asc' ? 'selected' : ''; ?>>Created At (Oldest First)
                            </option>
                            <option value="status_asc" <?php echo isset($_GET['sort_issues']) && $_GET['sort_issues'] == 'status_asc' ? 'selected' : ''; ?>>Status (A-Z)</option>
                            <option value="status_desc" <?php echo isset($_GET['sort_issues']) && $_GET['sort_issues'] == 'status_desc' ? 'selected' : ''; ?>>Status (Z-A)</option>
                        </select>
                        <button type="submit" class="cta-btn">Search/Sort</button>
                    </div>
                </form>

                <?php
                // Fetch issues with search and sort
                $search_issues = isset($_GET['search_issues']) ? $_GET['search_issues'] : '';
                $sort_issues = isset($_GET['sort_issues']) ? $_GET['sort_issues'] : 'created_at_desc';

                $query = "SELECT i.*, u.name as user_name, a.name as agent_name 
              FROM issues i 
              LEFT JOIN users u ON i.user_id = u.id 
              LEFT JOIN agents a ON i.agent_id = a.id 
              WHERE 1=1";
                $params = [];

                if (!empty($search_issues)) {
                    $query .= " AND (i.description LIKE ? OR u.name LIKE ?)";
                    $params[] = "%$search_issues%";
                    $params[] = "%$search_issues%";
                }

                if ($sort_issues == 'created_at_desc') {
                    $query .= " ORDER BY i.created_at DESC";
                } elseif ($sort_issues == 'created_at_asc') {
                    $query .= " ORDER BY i.created_at ASC";
                } elseif ($sort_issues == 'status_asc') {
                    $query .= " ORDER BY i.status ASC";
                } elseif ($sort_issues == 'status_desc') {
                    $query .= " ORDER BY i.status DESC";
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

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
                                        <form action="/controllers/AdminController.php?action=assign_issue" method="POST"
                                            style="display:inline;">
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
                                        <form action="/controllers/AdminController.php?action=update_issue_status" method="POST"
                                            style="display:inline;">
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
                                        <form action="/controllers/AdminController.php?action=delete_issue" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this issue?');">
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
            <!-- Tab Content: Messages -->
            <div id="messages" class="tab-content">
                <h3>Messages</h3>

                <!-- Messages from Agents -->
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

                <!-- Message History (Sent Messages) -->
                <h4>Sent Messages</h4>
                <?php
                // Fetch sent messages by admin
                $stmt = $pdo->prepare("SELECT m.*, a.name as agent_name 
                           FROM messages m 
                           JOIN agents a ON m.recipient_id = a.id 
                           WHERE m.sender_role = 'admin' AND m.sender_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $sent_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Agent Name</th>
                            <th>Message</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sent_messages)): ?>
                            <tr>
                                <td colspan="3">No sent messages.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sent_messages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['agent_name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo $message['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Send Message to Agent -->
                <h4>Send Message to Agent</h4>
                <form action="/controllers/AdminController.php?action=send_message" method="POST">
                    <div class="form-group">
                        <label for="agent_id">Select Agent</label>
                        <select id="agent_id" name="agent_id" required>
                            <option value="">Select Agent</option>
                            <?php foreach ($agents as $agent): ?>
                                <?php if ($agent['status'] === 'approved'): ?>
                                    <option value="<?php echo $agent['id']; ?>"><?php echo htmlspecialchars($agent['name']); ?>
                                    </option>
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


            <!-- Tab Content: Activity Logs -->
            <div id="activity_logs" class="tab-content">
                <h3>Activity Logs</h3>

                <!-- Search and Sort -->
                <form method="GET" action="/views/admin_dashboard.php" style="margin-bottom: 20px;">
                    <div class="form-group" style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" name="search_logs" placeholder="Search by action or role"
                            value="<?php echo isset($_GET['search_logs']) ? htmlspecialchars($_GET['search_logs']) : ''; ?>">
                        <select name="sort_logs">
                            <option value="created_at_desc" <?php echo isset($_GET['sort_logs']) && $_GET['sort_logs'] == 'created_at_desc' ? 'selected' : ''; ?>>Created At (Newest First)
                            </option>
                            <option value="created_at_asc" <?php echo isset($_GET['sort_logs']) && $_GET['sort_logs'] == 'created_at_asc' ? 'selected' : ''; ?>>Created At (Oldest First)
                            </option>
                            <option value="role_asc" <?php echo isset($_GET['sort_logs']) && $_GET['sort_logs'] == 'role_asc' ? 'selected' : ''; ?>>Role (A-Z)</option>
                            <option value="role_desc" <?php echo isset($_GET['sort_logs']) && $_GET['sort_logs'] == 'role_desc' ? 'selected' : ''; ?>>Role (Z-A)</option>
                        </select>
                        <button type="submit" class="cta-btn">Search/Sort</button>
                    </div>
                </form>

                <?php
                // Fetch activity logs with search and sort
                $search_logs = isset($_GET['search_logs']) ? $_GET['search_logs'] : '';
                $sort_logs = isset($_GET['sort_logs']) ? $_GET['sort_logs'] : 'created_at_desc';

                $query = "SELECT al.*, u.name as user_name 
              FROM activity_logs al 
              LEFT JOIN users u ON al.user_id = u.id AND al.role = 'user' 
              LEFT JOIN agents a ON al.user_id = a.id AND al.role = 'agent' 
              WHERE 1=1";
                $params = [];

                if (!empty($search_logs)) {
                    $query .= " AND (al.action LIKE ? OR al.role LIKE ?)";
                    $params[] = "%$search_logs%";
                    $params[] = "%$search_logs%";
                }

                if ($sort_logs == 'created_at_desc') {
                    $query .= " ORDER BY al.created_at DESC";
                } elseif ($sort_logs == 'created_at_asc') {
                    $query .= " ORDER BY al.created_at ASC";
                } elseif ($sort_logs == 'role_asc') {
                    $query .= " ORDER BY al.role ASC";
                } elseif ($sort_logs == 'role_desc') {
                    $query .= " ORDER BY al.role DESC";
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $activity_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User/Agent Name</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>IP Address</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($activity_logs)): ?>
                            <tr>
                                <td colspan="6">No activity logs found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($activity_logs as $log): ?>
                                <tr>
                                    <td><?php echo $log['id']; ?></td>
                                    <td>
                                        <?php
                                        if ($log['role'] == 'user') {
                                            echo htmlspecialchars($log['user_name']);
                                        } elseif ($log['role'] == 'agent') {
                                            $stmt = $pdo->prepare("SELECT name FROM agents WHERE id = ?");
                                            $stmt->execute([$log['user_id']]);
                                            $agent = $stmt->fetch();
                                            echo htmlspecialchars($agent['name']);
                                        } else {
                                            echo 'Admin';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($log['role']); ?></td>
                                    <td><?php echo htmlspecialchars($log['action']); ?></td>
                                    <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                                    <td><?php echo $log['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>



            <!-- Tab Content: Feedback -->
            <div id="feedback" class="tab-content">
                <h3>User Feedback</h3>

                <!-- Search and Sort -->
                <form method="GET" action="/views/admin_dashboard.php" style="margin-bottom: 20px;">
                    <div class="form-group" style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" name="search_feedback" placeholder="Search by comments or user name"
                            value="<?php echo isset($_GET['search_feedback']) ? htmlspecialchars($_GET['search_feedback']) : ''; ?>">
                        <select name="sort_feedback">
                            <option value="created_at_desc" <?php echo isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == 'created_at_desc' ? 'selected' : ''; ?>>Created At (Newest
                                First)</option>
                            <option value="created_at_asc" <?php echo isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == 'created_at_asc' ? 'selected' : ''; ?>>Created At (Oldest First)
                            </option>
                            <option value="rating_desc" <?php echo isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == 'rating_desc' ? 'selected' : ''; ?>>Rating (High to Low)
                            </option>
                            <option value="rating_asc" <?php echo isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == 'rating_asc' ? 'selected' : ''; ?>>Rating (Low to High)</option>
                        </select>
                        <button type="submit" class="cta-btn">Search/Sort</button>
                    </div>
                </form>

                <?php
                // Fetch feedback with search and sort
                $search_feedback = isset($_GET['search_feedback']) ? $_GET['search_feedback'] : '';
                $sort_feedback = isset($_GET['sort_feedback']) ? $_GET['sort_feedback'] : 'created_at_desc';

                $query = "SELECT f.*, i.description as issue_description, u.name as user_name 
              FROM feedback f 
              JOIN issues i ON f.issue_id = i.id 
              JOIN users u ON f.user_id = u.id 
              WHERE 1=1";
                $params = [];

                if (!empty($search_feedback)) {
                    $query .= " AND (f.comments LIKE ? OR u.name LIKE ?)";
                    $params[] = "%$search_feedback%";
                    $params[] = "%$search_feedback%";
                }

                if ($sort_feedback == 'created_at_desc') {
                    $query .= " ORDER BY f.created_at DESC";
                } elseif ($sort_feedback == 'created_at_asc') {
                    $query .= " ORDER BY f.created_at ASC";
                } elseif ($sort_feedback == 'rating_desc') {
                    $query .= " ORDER BY f.rating DESC";
                } elseif ($sort_feedback == 'rating_asc') {
                    $query .= " ORDER BY f.rating ASC";
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Issue Description</th>
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Comments</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($feedbacks)): ?>
                            <tr>
                                <td colspan="6">No feedback found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($feedbacks as $feedback): ?>
                                <tr>
                                    <td><?php echo $feedback['id']; ?></td>
                                    <td><?php echo htmlspecialchars($feedback['issue_description']); ?></td>
                                    <td><?php echo htmlspecialchars($feedback['user_name']); ?></td>
                                    <td><?php echo $feedback['rating']; ?>/5</td>
                                    <td><?php echo htmlspecialchars($feedback['comments']); ?></td>
                                    <td><?php echo $feedback['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <!-- Tab Content: Statistics -->
            <div id="statistics" class="tab-content">
                <h3>System Statistics</h3>

                <?php
                // Total Users
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users");
                $stmt->execute();
                $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                // Total Agents
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM agents");
                $stmt->execute();
                $total_agents = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                // Total Approved Agents
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM agents WHERE status = 'approved'");
                $stmt->execute();
                $total_approved_agents = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                // Total Issues
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues");
                $stmt->execute();
                $total_issues = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                // Total Resolved Issues
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues WHERE status = 'resolved'");
                $stmt->execute();
                $total_resolved_issues = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                // Average Feedback Rating
                $stmt = $pdo->prepare("SELECT AVG(rating) as avg_rating FROM feedback");
                $stmt->execute();
                $avg_rating = round($stmt->fetch(PDO::FETCH_ASSOC)['avg_rating'], 2);
                ?>

                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Total Users</h4>
                        <p><?php echo $total_users; ?></p>
                    </div>
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Total Agents</h4>
                        <p><?php echo $total_agents; ?></p>
                    </div>
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Approved Agents</h4>
                        <p><?php echo $total_approved_agents; ?></p>
                    </div>
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Total Issues</h4>
                        <p><?php echo $total_issues; ?></p>
                    </div>
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Resolved Issues</h4>
                        <p><?php echo $total_resolved_issues; ?></p>
                    </div>
                    <div
                        style="background-color: #f4f7fa; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
                        <h4>Average Feedback Rating</h4>
                        <p><?php echo $avg_rating ? $avg_rating . '/5' : 'N/A'; ?></p>
                    </div>
                </div>
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