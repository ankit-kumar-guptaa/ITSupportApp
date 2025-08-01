<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    header("Location: /views/agent_login.php?error=Please login as an agent!");
    exit;
}
require '../config/db.php';

// Fetch agent details
$stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, status FROM agents WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$agentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agentData) {
    session_unset();
    session_destroy();
    header("Location: /views/agent_login.php?error=Agent not found");
    exit;
}

// Check if agent is approved
if ($agentData['status'] !== 'approved') {
    session_unset();
    session_destroy();
    header("Location: /views/agent_login.php?error=Your account is not approved yet. Please wait for admin approval.");
    exit;
}
// AgentController.php (Snippet for sending message)
if ($action === 'send_message') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Save message to database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_role, recipient_id, recipient_role, message, created_at) 
                               VALUES (?, 'agent', 1, 'admin', ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $message]);

        header("Location: /views/agent_dashboard.php?success=Message sent to admin successfully!");
        exit;
    }
}

// Fetch assigned issues
$stmt = $pdo->prepare("SELECT i.*, u.name as user_name, u.phone_number as user_phone, u.address as user_address 
                       FROM issues i 
                       JOIN users u ON i.user_id = u.id 
                       WHERE i.agent_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$assigned_issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch issue history
$stmt = $pdo->prepare("SELECT i.*, u.name as user_name 
                       FROM issues i 
                       JOIN users u ON i.user_id = u.id 
                       WHERE i.agent_id = ? AND i.status = 'resolved'");
$stmt->execute([$_SESSION['user_id']]);
$issue_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages from admin
$stmt = $pdo->prepare("SELECT * FROM messages WHERE recipient_id = ? AND recipient_role = 'agent'");
$stmt->execute([$_SESSION['user_id']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Agent Dashboard | Manage Your IT Support Tasks</title>
    <meta name="description" content="Access your agent dashboard at IT Sahayta to manage assigned issues, view history, and communicate with admin. Enhance your IT support efficiency.">
    <?php include "assets.php"?>
  
</head>
<body>



<?php include 'header.php'; ?>

   <?php include 'loader.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Welcome, <?php echo htmlspecialchars($agentData['name']); ?>!</h2>

            <?php if (isset($_GET['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'profile')">Profile</button>
                <button class="tablinks" onclick="openTab(event, 'issues')">Assigned Issues</button>
                <button class="tablinks" onclick="openTab(event, 'history')">Issue History</button>
                <button class="tablinks" onclick="openTab(event, 'messages')">Messages</button>
            </div>

            <!-- Tab Content: Profile -->
            <div id="profile" class="tab-content active">
                <h3>Your Profile</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($agentData['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($agentData['email']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($agentData['phone_number']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($agentData['address'] ?? 'Not provided'); ?>
                </p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($agentData['status']); ?></p>
            </div>


            <!-- Tab Content: Assigned Issues -->
            <div id="issues" class="tab-content">
                <h3>Assigned Issues</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            <th>User Address</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($assigned_issues)): ?>
                            <tr>
                                <td colspan="8">No issues assigned yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($assigned_issues as $issue): ?>
                                <tr>
                                    <td><?php echo $issue['id']; ?></td>
                                    <td><?php echo htmlspecialchars($issue['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['user_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['user_address']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['description']); ?></td>
                                    <td><?php echo $issue['category']; ?></td>
                                    <td><?php echo $issue['status']; ?></td>
                                    <td>
                                        <form action="/controllers/AgentController.php?action=update_issue_status"
                                            method="POST">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <select name="status">
                                                <option value="in_progress">In Progress</option>
                                                <option value="resolved">Resolved</option>
                                                <option value="escalated">Escalated</option>
                                            </select>
                                            <textarea name="note" placeholder="Add a note (e.g., resolution details)"
                                                required></textarea>
                                            <button type="submit" class="cta-btn">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Content: Issue History -->
            <div id="history" class="tab-content">
                <h3>Issue History</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Resolved At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($issue_history)): ?>
                            <tr>
                                <td colspan="7">No resolved issues yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($issue_history as $issue): ?>
                                <tr>
                                    <td><?php echo $issue['id']; ?></td>
                                    <td><?php echo htmlspecialchars($issue['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($issue['description']); ?></td>
                                    <td><?php echo $issue['category']; ?></td>
                                    <td><?php echo $issue['status']; ?></td>
                                    <td><?php echo $issue['created_at']; ?></td>
                                    <td><?php echo $issue['updated_at']; ?></td>
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

                <!-- Messages from Admin -->
                <h4>Messages from Admin</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($messages)): ?>
                            <tr>
                                <td colspan="2">No messages from admin.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Message History (Sent Messages) -->
                <h4>Sent Messages</h4>
                <?php
                // Fetch sent messages by agent
                $stmt = $pdo->prepare("SELECT m.* FROM messages m WHERE m.sender_id = ? AND m.sender_role = 'agent'");
                $stmt->execute([$_SESSION['user_id']]);
                $sent_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sent_messages)): ?>
                            <tr>
                                <td colspan="2">No sent messages.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sent_messages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo $message['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Send Message to Admin -->
                <h4>Send Message to Admin</h4>
                <form action="/controllers/AgentController.php?action=send_message" method="POST">
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

<?php include 'footer.php'; ?>