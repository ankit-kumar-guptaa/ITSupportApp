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
$stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone FROM issues i LEFT JOIN agents a ON i.agent_id = a.id WHERE i.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
                            <th>Agent Phone</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($issues)): ?>
                            <tr>
                                <td colspan="7">No issues reported yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($issues as $issue): ?>
                                <tr>
                                    <td><?php echo $issue['id']; ?></td>
                                    <td><?php echo htmlspecialchars($issue['description']); ?></td>
                                    <td><?php echo $issue['category']; ?></td>
                                    <td><?php echo $issue['status']; ?></td>
                                    <td>
                                        <?php
                                        if ($issue['show_agent_details'] && $issue['agent_name']) {
                                            echo htmlspecialchars($issue['agent_name']);
                                        } else {
                                            echo 'Not Assigned';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($issue['show_agent_details'] && $issue['agent_phone']) {
                                            echo htmlspecialchars($issue['agent_phone']);
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $issue['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Quick Links -->
                <h3>Quick Links</h3>
                <a href="/views/report_issue.php" class="cta-btn">Report New Issue</a>
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

<?php include 'footer.php'; ?>