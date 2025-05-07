<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

// Fetch user details
$stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, password, role, is_verified FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    // If user not found, redirect to login
    session_unset();
    session_destroy();
    header("Location: /views/login.php?error=User not found");
    exit;
}

// Fetch total reported issues
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_issues = $stmt->fetch()['total'];

// Fetch reported issues with agent details
// $stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone FROM issues i LEFT JOIN agents a ON i.agent_id = a.id WHERE i.user_id = ?");
// $stmt->execute([$_SESSION['user_id']]);
// $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone 
                       FROM issues i 
                       LEFT JOIN agents a ON i.agent_id = a.id 
                       WHERE i.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$reported_issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - User Dashboard | Manage Your IT Support</title>
    <meta name="description" content="Access your user dashboard at IT Sahayta to manage your profile, report issues, and track your IT support requests.">
    <?php include "assets.php"?>
  
</head>
<body>


<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Welcome, <?php echo htmlspecialchars($userData['name']); ?>!</h2>

            <?php if (isset($_GET['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            
            <!-- Add Report Issue Button Above Tabs -->
<div style="margin-bottom: 20px;">
    <a href="/views/report_issue.php" class="cta-btn" style="background-color: #4CAF50; padding: 10px 20px; border-radius: 5px; text-decoration: none; color: white;">
        Report New Issue
    </a>
</div
            <!-- Tabs Navigation -->
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'details')">Your Details</button>
                <button class="tablinks" onclick="openTab(event, 'update')">Update Profile</button>
                <button class="tablinks" onclick="openTab(event, 'issues')">Reported Issues</button>
                <button class="tablinks" onclick="openTab(event, 'settings')">Settings</button>
            </div>

            <!-- Tab Content: Your Details -->
            <div id="details" class="tab-content active">
                <h3>Your Details</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email'] ?? 'Not provided'); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userData['phone_number'] ?? 'Not provided'); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($userData['address'] ?? 'Not provided'); ?></p>
                <p><strong>Total Reported Issues:</strong> <?php echo $total_issues; ?></p>
            </div>

            <!-- Tab Content: Update Profile -->
            <div id="update" class="tab-content">
                <!-- Update Email -->
                <h3>Update Email</h3>
                <form action="/controllers/UserController.php?action=update_email_request" method="POST">
                    <div class="form-group">
                        <label for="email">New Email</label>
                        <input type="email" id="email" name="email" required placeholder="Enter new email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="cta-btn">Send OTP</button>
                </form>

                <!-- Update Phone Number -->
                <h3>Update Phone Number</h3>
                <form action="/controllers/UserController.php?action=update_phone" method="POST">
                    <div class="form-group">
                        <label for="phone_number">New Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" value="<?php echo htmlspecialchars($userData['phone_number'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="cta-btn">Update</button>
                </form>

                <!-- Update Address -->
                <h3>Update Address</h3>
                <form action="/controllers/UserController.php?action=update_address" method="POST">
                    <div class="form-group">
                        <label for="address">New Address</label>
                        <textarea id="address" name="address" required placeholder="Enter new address"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="cta-btn">Update</button>
                </form>
            </div>

           <!-- Tab Content: Reported Issues -->
<div id="issues" class="tab-content">
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
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reported_issues)): ?>
                <tr>
                    <td colspan="7">No issues reported yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reported_issues as $issue): ?>
                    <tr>
                        <td><?php echo $issue['id']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($issue['description']); ?>
                            
                            <?php if (!empty($issue['image_path'])): ?>
                                <div class="issue-image">
                                    <a href="<?php echo $issue['image_path']; ?>" target="_blank">
                                        <img src="<?php echo $issue['image_path']; ?>" alt="Issue Image" style="max-width: 100px; max-height: 100px;">
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($issue['attached_file'])): ?>
                                <div class="issue-file">
                                    <a href="<?php echo $issue['attached_file']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-pdf"></i> View File
                                    </a>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($issue['category']); ?></td>
                        <td>
                            <?php 
                                $status_class = '';
                                switch($issue['status']) {
                                    case 'Pending':
                                        $status_class = 'status-pending';
                                        break;
                                    case 'In Progress':
                                        $status_class = 'status-progress';
                                        break;
                                    case 'Resolved':
                                        $status_class = 'status-resolved';
                                        break;
                                    default:
                                        $status_class = 'status-default';
                                }
                            ?>
                            <span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($issue['status']); ?></span>
                        </td>
                        <td>
                            <?php if ($issue['agent_id']): ?>
                                <?php echo htmlspecialchars($issue['agent_name']); ?><br>
                                <small><?php echo htmlspecialchars($issue['agent_phone']); ?></small>
                            <?php else: ?>
                                Not assigned yet
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('Y-m-d H:i', strtotime($issue['created_at'])); ?></td>
                        <td>
                            <?php if ($issue['status'] == 'Resolved'): ?>
                                <?php
                                // Check if feedback already submitted
                                $stmt = $pdo->prepare("SELECT * FROM feedback WHERE issue_id = ? AND user_id = ?");
                                $stmt->execute([$issue['id'], $_SESSION['user_id']]);
                                $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if ($feedback): ?>
                                    <p>Rating: <?php echo $feedback['rating']; ?>/5<br>Comments: <?php echo htmlspecialchars($feedback['comments']); ?></p>
                                <?php else: ?>
                                    <form action="/controllers/UserController.php?action=submit_feedback" method="POST">
                                        <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                        <div class="form-group">
                                            <label for="rating_<?php echo $issue['id']; ?>">Rating (1-5):</label>
                                            <select name="rating" id="rating_<?php echo $issue['id']; ?>" required>
                                                <option value="">Select Rating</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="comments_<?php echo $issue['id']; ?>">Comments:</label>
                                            <textarea name="comments" id="comments_<?php echo $issue['id']; ?>" placeholder="Your comments" required></textarea>
                                        </div>
                                        <button type="submit" class="cta-btn">Submit Feedback</button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Feedback available after resolution.</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

            

            <!-- Tab Content: Settings -->
            <div id="settings" class="tab-content">
                <!-- Change Password -->
                <h3>Change Password</h3>
                <form action="/controllers/UserController.php?action=change_password" method="POST">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                    </div>
                    <button type="submit" class="cta-btn">Change Password</button>
                </form>

                <!-- Delete Account -->
                <h3>Delete Account</h3>
                <p style="color: red;">Warning: This action cannot be undone. All your data, including reported issues, will be permanently deleted.</p>
                <form action="/controllers/UserController.php?action=delete_account" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    <button type="submit" class="cta-btn" style="background-color: red;">Delete Account</button>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
function openTab(evt, tabName) {
    // Hide all tab content
    var tabcontent = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }

    // Remove active class from all tab buttons
    var tablinks = document.getElementsByClassName("tablinks");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show the current tab and add active class to the button
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<style>
    .status-badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

.status-pending {
    background-color: #ffc107;
}

.status-progress {
    background-color: #17a2b8;
}

.status-resolved {
    background-color: #28a745;
}

.status-default {
    background-color: #6c757d;
}
</style>

<?php include 'footer.php'; ?>