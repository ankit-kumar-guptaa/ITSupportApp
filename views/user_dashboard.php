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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <div class="user-welcome">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="welcome-text">
                        <h2>Welcome, <?php echo htmlspecialchars($userData['name']); ?>!</h2>
                        <p class="user-role"><i class="fas fa-shield-alt"></i> User Account</p>
                    </div>
                </div>
                
                <div class="dashboard-actions">
                    <a href="/views/report_issue.php" class="action-button report-btn">
                        <i class="fas fa-plus-circle"></i> Report New Issue
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['success']) || isset($_GET['error'])): ?>
                <div class="notification-container">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="notification success">
                            <i class="fas fa-check-circle"></i>
                            <p><?php echo htmlspecialchars($_GET['success']); ?></p>
                            <button class="close-notification"><i class="fas fa-times"></i></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['error'])): ?>
                        <div class="notification error">
                            <i class="fas fa-exclamation-circle"></i>
                            <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                            <button class="close-notification"><i class="fas fa-times"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_issues; ?></h3>
                        <p>Total Issues</p>
                    </div>
                </div>
                
                <?php
                // Count issues by status
                $pending = 0;
                $inProgress = 0;
                $resolved = 0;
                
                foreach ($reported_issues as $issue) {
                    if ($issue['status'] == 'Pending') $pending++;
                    if ($issue['status'] == 'In Progress') $inProgress++;
                    if ($issue['status'] == 'Resolved') $resolved++;
                }
                ?>
                
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $pending; ?></h3>
                        <p>Pending</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon progress">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $inProgress; ?></h3>
                        <p>In Progress</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon resolved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $resolved; ?></h3>
                        <p>Resolved</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
                <!-- Tabs Navigation -->
                <div class="tabs-container">
                    <div class="tabs-nav">
                        <button class="tab-btn active" data-tab="details">
                            <i class="fas fa-user"></i> Your Details
                        </button>
                        <button class="tab-btn" data-tab="update">
                            <i class="fas fa-edit"></i> Update Profile
                        </button>
                        <button class="tab-btn" data-tab="issues">
                            <i class="fas fa-ticket-alt"></i> Reported Issues
                        </button>
                        <button class="tab-btn" data-tab="settings">
                            <i class="fas fa-cog"></i> Settings
                        </button>
                    </div>

                    <!-- Tab Content: Your Details -->
                    <div id="details" class="tab-content active">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-id-card"></i> Your Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="user-details">
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="detail-info">
                                            <h4>Name</h4>
                                            <p><?php echo htmlspecialchars($userData['name']); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="detail-info">
                                            <h4>Email</h4>
                                            <p><?php echo htmlspecialchars($userData['email'] ?? 'Not provided'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="detail-info">
                                            <h4>Phone Number</h4>
                                            <p><?php echo htmlspecialchars($userData['phone_number'] ?? 'Not provided'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="detail-info">
                                            <h4>Address</h4>
                                            <p><?php echo htmlspecialchars($userData['address'] ?? 'Not provided'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Update Profile -->
                    <div id="update" class="tab-content">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-envelope"></i> Update Email</h3>
                            </div>
                            <div class="card-body">
                                <form action="/controllers/UserController.php?action=update_email_request" method="POST" class="form-modern">
                                    <div class="form-group">
                                        <label for="email">New Email</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" id="email" name="email" required placeholder="Enter new email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="form-button">
                                        <i class="fas fa-paper-plane"></i> Send OTP
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-phone"></i> Update Phone Number</h3>
                            </div>
                            <div class="card-body">
                                <form action="/controllers/UserController.php?action=update_phone" method="POST" class="form-modern">
                                    <div class="form-group">
                                        <label for="phone_number">New Phone Number</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-phone"></i>
                                            <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" value="<?php echo htmlspecialchars($userData['phone_number'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="form-button">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-map-marker-alt"></i> Update Address</h3>
                            </div>
                            <div class="card-body">
                                <form action="/controllers/UserController.php?action=update_address" method="POST" class="form-modern">
                                    <div class="form-group">
                                        <label for="address">New Address</label>
                                        <div class="input-with-icon textarea">
                                            <i class="fas fa-home"></i>
                                            <textarea id="address" name="address" required placeholder="Enter new address"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="form-button">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Reported Issues -->
                    <div id="issues" class="tab-content">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-ticket-alt"></i> Your Reported Issues</h3>
                            </div>
                            <div class="card-body">
                                <?php if (empty($reported_issues)): ?>
                                    <div class="empty-state">
                                        <i class="fas fa-ticket-alt fa-4x"></i>
                                        <p>You haven't reported any issues yet.</p>
                                        <a href="/views/report_issue.php" class="form-button">
                                            <i class="fas fa-plus-circle"></i> Report Your First Issue
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="issues-container">
                                        <?php foreach ($reported_issues as $issue): ?>
                                            <div class="issue-card">
                                                <div class="issue-header">
                                                    <div class="issue-id">#<?php echo $issue['id']; ?></div>
                                                    <?php 
                                                        $status_class = '';
                                                        $status_icon = '';
                                                        switch($issue['status']) {
                                                            case 'Pending':
                                                                $status_class = 'status-pending';
                                                                $status_icon = 'clock';
                                                                break;
                                                            case 'In Progress':
                                                                $status_class = 'status-progress';
                                                                $status_icon = 'spinner';
                                                                break;
                                                            case 'Resolved':
                                                                $status_class = 'status-resolved';
                                                                $status_icon = 'check-circle';
                                                                break;
                                                            default:
                                                                $status_class = 'status-default';
                                                                $status_icon = 'info-circle';
                                                        }
                                                    ?>
                                                    <div class="status-badge <?php echo $status_class; ?>">
                                                        <i class="fas fa-<?php echo $status_icon; ?>"></i> <?php echo htmlspecialchars($issue['status']); ?>
                                                    </div>
                                                </div>
                                                <div class="issue-body">
                                                    <div class="issue-category">
                                                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($issue['category']); ?>
                                                    </div>
                                                    <div class="issue-description">
                                                        <?php echo htmlspecialchars($issue['description']); ?>
                                                    </div>
                                                    
                                                    <?php if (!empty($issue['image_path'])): ?>
                                                        <div class="issue-attachment">
                                                            <a href="<?php echo $issue['image_path']; ?>" target="_blank" class="image-preview">
                                                                <img src="<?php echo $issue['image_path']; ?>" alt="Issue Image">
                                                                <div class="preview-overlay">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($issue['attached_file'])): ?>
                                                        <div class="issue-attachment">
                                                            <a href="<?php echo $issue['attached_file']; ?>" target="_blank" class="file-link">
                                                                <i class="fas fa-file-pdf"></i> View Attached File
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="issue-footer">
                                                    <div class="issue-date">
                                                        <i class="fas fa-calendar-alt"></i> <?php echo date('Y-m-d H:i', strtotime($issue['created_at'])); ?>
                                                    </div>
                                                    <div class="issue-agent">
                                                        <i class="fas fa-user-tie"></i> 
                                                        <?php if ($issue['agent_id']): ?>
                                                            <span class="agent-name"><?php echo htmlspecialchars($issue['agent_name']); ?></span>
                                                            <span class="agent-phone"><?php echo htmlspecialchars($issue['agent_phone']); ?></span>
                                                        <?php else: ?>
                                                            <span class="no-agent">Not assigned yet</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <?php if ($issue['status'] == 'Resolved'): ?>
    <div class="feedback-section">
        <?php
        // Check if feedback already submitted
        $stmt = $pdo->prepare("SELECT * FROM feedback WHERE issue_id = ? AND user_id = ?");
        $stmt->execute([$issue['id'], $_SESSION['user_id']]);
        $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        
        <?php if ($feedback): ?>
            <div class="feedback-header">
                <span><i class="fas fa-star"></i> Your Feedback</span>
                <span><?php echo date('d M Y', strtotime($feedback['created_at'])); ?></span>
            </div>
            <div class="feedback-submitted">
                <div class="feedback-rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= $feedback['rating']): ?>
                            <i class="fas fa-star"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                
                <div class="feedback-comments">
                    <?php echo htmlspecialchars($feedback['comments']); ?>
                </div>
                
                <div class="feedback-thanks">
                    <i class="fas fa-check-circle"></i> Thank you! Your feedback is important to us
                </div>
            </div>
        <?php else: ?>
            <div class="feedback-header">
                <span><i class="fas fa-star"></i> Please Share Your Feedback</span>
            </div>
            <form action="/controllers/UserController.php?action=submit_feedback" method="POST" class="feedback-form">
                <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                
                <div class="rating-stars">
                    <input type="radio" id="star5_<?php echo $issue['id']; ?>" name="rating" value="5" required />
                    <label for="star5_<?php echo $issue['id']; ?>"></label>
                    <input type="radio" id="star4_<?php echo $issue['id']; ?>" name="rating" value="4" />
                    <label for="star4_<?php echo $issue['id']; ?>"></label>
                    <input type="radio" id="star3_<?php echo $issue['id']; ?>" name="rating" value="3" />
                    <label for="star3_<?php echo $issue['id']; ?>"></label>
                    <input type="radio" id="star2_<?php echo $issue['id']; ?>" name="rating" value="2" />
                    <label for="star2_<?php echo $issue['id']; ?>"></label>
                    <input type="radio" id="star1_<?php echo $issue['id']; ?>" name="rating" value="1" />
                    <label for="star1_<?php echo $issue['id']; ?>"></label>
                </div>
                
                <div class="feedback-textarea">
                    <textarea name="comments" placeholder="Tell us about your experience..." required></textarea>
                    <div class="emoji-picker">
                        <span class="emoji" onclick="addEmoji('😊')">😊</span>
                        <span class="emoji" onclick="addEmoji('👍')">👍</span>
                        <span class="emoji" onclick="addEmoji('🙏')">🙏</span>
                    </div>
                </div>
                
                <div class="feedback-submit">
                    <button type="submit" class="feedback-btn">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Settings -->
                    <div id="settings" class="tab-content">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-lock"></i> Change Password</h3>
                            </div>
                            <div class="card-body">
                                <form action="/controllers/UserController.php?action=change_password" method="POST" class="form-modern">
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                                            <button type="button" class="toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-key"></i>
                                            <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                                            <button type="button" class="toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="form-button">
                                        <i class="fas fa-save"></i> Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="content-card danger-zone">
                            <div class="card-header">
                                <h3><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
                            </div>
                            <div class="card-body">
                                <div class="warning-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p>Warning: This action cannot be undone. All your data, including reported issues, will be permanently deleted.</p>
                                </div>
                                <form action="/controllers/UserController.php?action=delete_account" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                    <button type="submit" class="form-button danger">
                                        <i class="fas fa-trash-alt"></i> Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>



<style>
    /* Main Dashboard Styles */
    .dashboard-section {
        padding: 30px 0;
        background-color: #f0f4f8;
        min-height: calc(100vh - 80px);
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 20px;
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .user-welcome {
        display: flex;
        align-items: center;
    }

    .user-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #3498db, #1a5276);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        border: 3px solid #fff;
    }

    .user-avatar i {
        font-size: 32px;
        color: #fff;
    }

    .welcome-text h2 {
        margin: 0 0 5px 0;
        font-size: 26px;
        color: #2c3e50;
        font-weight: 600;
    }

    .user-role {
        display: flex;
        align-items: center;
        margin: 0;
        color: #7f8c8d;
        font-size: 15px;
    }

    .user-role i {
        margin-right: 5px;
        color: #3498db;
    }

    .dashboard-actions {
        display: flex;
        gap: 10px;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .report-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    }

    .report-btn:hover {
        background: linear-gradient(135deg, #2980b9, #1a5276);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
    }

    .action-button i {
        margin-right: 8px;
    }

    /* Notification Styles */
    .notification-container {
        margin-bottom: 20px;
    }

    .notification {
        display: flex;
        align-items: center;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .notification.success {
        background-color: #e8f5e9;
        border-left: 4px solid #2ecc71;
    }

    .notification.error {
        background-color: #ffebee;
        border-left: 4px solid #e74c3c;
    }

    .notification i {
        font-size: 22px;
        margin-right: 15px;
    }

    .notification.success i {
        color: #2ecc71;
    }

    .notification.error i {
        color: #e74c3c;
    }

    .notification p {
        margin: 0;
        flex-grow: 1;
        color: #333;
        font-size: 15px;
    }

    .close-notification {
        background: none;
        border: none;
        color: #95a5a6;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-notification:hover {
        background-color: rgba(0, 0, 0, 0.05);
        color: #2c3e50;
    }

    /* Stats Cards */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        box-shadow: 0 5px 10px rgba(52, 152, 219, 0.2);
    }

    .stat-icon i {
        font-size: 26px;
        color: #fff;
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #f39c12, #d35400);
        box-shadow: 0 5px 10px rgba(243, 156, 18, 0.2);
    }

    .stat-icon.progress {
        background: linear-gradient(135deg, #3498db, #2980b9);
        box-shadow: 0 5px 10px rgba(52, 152, 219, 0.2);
    }

    .stat-icon.resolved {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        box-shadow: 0 5px 10px rgba(46, 204, 113, 0.2);
    }

    .stat-info h3 {
        margin: 0 0 5px 0;
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
    }

    .stat-info p {
        margin: 0;
        color: #7f8c8d;
        font-size: 15px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card:nth-child(1):hover {
        border-bottom: 3px solid #3498db;
    }

    .stat-card:nth-child(2):hover {
        border-bottom: 3px solid #f39c12;
    }

    .stat-card:nth-child(3):hover {
        border-bottom: 3px solid #3498db;
    }

    .stat-card:nth-child(4):hover {
        border-bottom: 3px solid #2ecc71;
    }

    /* Dashboard Content Styles */
    .dashboard-content {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        overflow: hidden;
    }

    /* Tabs Navigation */
    .tabs-container {
        width: 100%;
    }

    .tabs-nav {
        display: flex;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        overflow-x: auto;
        scrollbar-width: thin;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .tabs-nav::-webkit-scrollbar {
        height: 5px;
    }

    .tabs-nav::-webkit-scrollbar-thumb {
        background-color: #bdc3c7;
        border-radius: 5px;
    }

    .tab-btn {
        padding: 18px 25px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        color: #7f8c8d;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        position: relative;
    }

    .tab-btn i {
        margin-right: 10px;
        font-size: 18px;
    }

    .tab-btn:hover {
        color: #3498db;
        background-color: rgba(52, 152, 219, 0.05);
    }

    .tab-btn.active {
        color: #3498db;
        background-color: #fff;
        font-weight: 600;
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

    /* Tab Content */
    .tab-content {
        display: none;
        padding: 25px;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Content Card */
    .content-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .content-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        padding: 18px 25px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    .card-header h3 {
        margin: 0;
        font-size: 18px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .card-header h3 i {
        margin-right: 12px;
        color: #3498db;
        font-size: 20px;
    }

    .card-body {
        padding: 25px;
    }

    /* User Details */
    .user-details {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .detail-item:hover {
        background-color: #f0f4f8;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-left: 3px solid #3498db;
    }

    .detail-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
    }

    .detail-icon i {
        color: #fff;
        font-size: 18px;
    }

    .detail-info h4 {
        margin: 0 0 8px 0;
        font-size: 15px;
        color: #7f8c8d;
        font-weight: 500;
    }

    .detail-info p {
        margin: 0;
        font-size: 18px;
        color: #2c3e50;
        word-break: break-word;
        font-weight: 500;
    }

    /* Form Styles */
    .form-modern {
        max-width: 100%;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: #2c3e50;
        font-size: 15px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
        font-size: 18px;
    }

    .input-with-icon.textarea i {
        top: 20px;
        transform: none;
    }

    .input-with-icon input,
    .input-with-icon textarea,
    .input-with-icon select {
        padding-left: 45px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 14px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        color: #2c3e50;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #3498db;
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.2);
        outline: none;
        background-color: #fff;
    }

    .form-button {
        display: inline-block;
        padding: 14px 28px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 10px;
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    }

    .form-button:hover {
        background: linear-gradient(135deg, #2980b9, #1a5276);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
    }

    .form-button i {
        margin-right: 8px;
    }

    /* Issues Container */
    .issues-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
    }

    .issue-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .issue-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .issue-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    .issue-id {
        font-weight: 700;
        color: #2c3e50;
        font-size: 16px;
        background: #e0e0e0;
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .status-badge i {
        margin-right: 5px;
    }

    .status-pending {
        background-color: #fff3e0;
        color: #f39c12;
    }

    .status-progress {
        background-color: #e3f2fd;
        color: #3498db;
    }

    .status-resolved {
        background-color: #e8f5e9;
        color: #2ecc71;
    }

    .status-default {
        background-color: #f5f5f5;
        color: #7f8c8d;
    }

    .issue-body {
        padding: 20px;
    }

    .issue-category {
        display: inline-flex;
        align-items: center;
        background-color: #f0f4f8;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 14px;
        color: #2c3e50;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .issue-category i {
        margin-right: 8px;
        color: #3498db;
    }

    .issue-description {
        margin-bottom: 20px;
        color: #2c3e50;
        line-height: 1.6;
        font-size: 15px;
    }

    .issue-attachment {
        margin-top: 15px;
    }

    .image-preview {
        display: block;
        position: relative;
        width: 100%;
        max-width: 200px;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .image-preview img {
        width: 100%;
        height: auto;
        display: block;
        transition: all 0.3s ease;
    }

    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .preview-overlay i {
        color: white;
        font-size: 24px;
    }

    .image-preview:hover .preview-overlay {
        opacity: 1;
    }

    .image-preview:hover img {
        transform: scale(1.05);
    }

    .file-link {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        background-color: #f0f4f8;
        border-radius: 50px;
        color: #2c3e50;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .file-link i {
        margin-right: 8px;
        color: #3498db;
    }

    .file-link:hover {
        background-color: #e0e6ed;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .issue-footer {
        display: flex;
        justify-content: space-between;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
        font-size: 14px;
        color: #7f8c8d;
    }

    .issue-date, .issue-agent {
        display: flex;
        align-items: center;
    }

    .issue-date i, .issue-agent i {
        margin-right: 8px;
        color: #3498db;
    }

    .agent-name {
        font-weight: 600;
        margin-right: 5px;
        color: #2c3e50;
    }

    .agent-phone {
        color: #7f8c8d;
    }

    .no-agent {
        color: #95a5a6;
        font-style: italic;
    }

    /* Feedback Section */
    .feedback-section {
        padding: 20px;
        border-top: 1px solid #eee;
        background-color: #f8f9fa;
    }

    .feedback-header {
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }

    .feedback-header i {
        margin-right: 8px;
        color: #f1c40f;
    }

    .feedback-submitted {
        background-color: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .rating-display {
        margin: 10px 0;
    }

    .rating-display i.fas.fa-star {
        color: #f1c40f;
        font-size: 18px;
    }

    .rating-display i.far.fa-star {
        color: #ddd;
        font-size: 18px;
    }

    .feedback-comments {
        margin-top: 10px;
        font-style: italic;
        color: #7f8c8d;
        line-height: 1.5;
    }

    .stars-container {
        margin-top: 10px;
        font-size: 22px;
    }

    /* Empty State Styles */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #7f8c8d;
    }

    .empty-state i {
        color: #bdc3c7;
        margin-bottom: 20px;
        font-size: 60px;
    }

    .empty-state p {
        margin-bottom: 25px;
        font-size: 18px;
    }

    /* Password Strength Meter */
    .password-strength {
        margin-top: 12px;
    }

    .strength-meter {
        height: 6px;
        background-color: #eee;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }

    .strength-meter::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        transition: width 0.3s ease;
    }

    .strength-meter.weak::before {
        width: 25%;
        background-color: #e74c3c;
    }

    .strength-meter.medium::before {
        width: 50%;
        background-color: #f39c12;
    }

    .strength-meter.strong::before {
        width: 75%;
        background-color: #2ecc71;
    }

    .strength-meter.very-strong::before {
        width: 100%;
        background-color: #27ae60;
    }

    .strength-text {
        font-size: 13px;
        margin-top: 8px;
        color: #7f8c8d;
    }

    .strength-text.weak {
        color: #e74c3c;
    }

    .strength-text.medium {
        color: #f39c12;
    }

    .strength-text.strong {
        color: #2ecc71;
    }

    .strength-text.very-strong {
        color: #27ae60;
    }

    /* Lightbox */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        animation: fadeIn 0.3s forwards;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 5px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        transform: scale(0.95);
        animation: scaleIn 0.3s forwards;
    }

    @keyframes scaleIn {
        to { transform: scale(1); }
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-stats {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .issues-container {
            grid-template-columns: 1fr;
        }

        .user-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .tabs-nav {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 12px 15px;
            font-size: 14px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
        }

        .stat-info h3 {
            font-size: 22px;
        }
    }
</style>

<style>
    /* Feedback Section Styles */
.feedback-section {
    padding: 0;
    border-top: 1px solid #e0e0e0;
    background: linear-gradient(to right, #f8f9fa, #e8f4fd);
    border-radius: 0 0 12px 12px;
    overflow: hidden;
}

.feedback-header {
    background: #3498db;
    color: white;
    padding: 15px 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.feedback-header i {
    margin-right: 8px;
    color: #f1c40f;
    font-size: 18px;
}

.feedback-form {
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    margin: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.feedback-form:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    margin: 20px 0;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    font-size: 30px;
    color: #ddd;
    transition: all 0.2s ease;
    margin: 0 5px;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input:checked ~ label {
    color: #f1c40f;
    transform: scale(1.2);
}

.rating-stars label:hover:before,
.rating-stars label:hover ~ label:before,
.rating-stars input:checked ~ label:before {
    content: '\f005';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
}

.rating-stars label:before {
    content: '\f005';
    font-family: 'Font Awesome 5 Free';
    font-weight: 400;
}

.feedback-textarea {
    position: relative;
    margin-bottom: 20px;
}

.feedback-textarea textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background-color: #fff;
    min-height: 100px;
    resize: vertical;
}

.feedback-textarea textarea:focus {
    border-color: #3498db;
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.2);
    outline: none;
}

.feedback-textarea .emoji-picker {
    position: absolute;
    right: 10px;
    top: 10px;
    display: flex;
    gap: 5px;
}

.feedback-textarea .emoji {
    font-size: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    opacity: 0.5;
}

.feedback-textarea .emoji:hover {
    transform: scale(1.2);
    opacity: 1;
}

.feedback-submit {
    text-align: center;
}

.feedback-btn {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    display: inline-flex;
    align-items: center;
}

.feedback-btn i {
    margin-right: 8px;
}

.feedback-btn:hover {
    background: linear-gradient(135deg, #2980b9, #1a5276);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
}

.feedback-submitted {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin: 15px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.feedback-submitted:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, #3498db, #2ecc71);
}

.feedback-rating {
    margin: 15px 0;
}

.feedback-rating i {
    font-size: 24px;
    margin: 0 2px;
}

.feedback-rating i.fas.fa-star {
    color: #f1c40f;
}

.feedback-rating i.far.fa-star {
    color: #ddd;
}

.feedback-comments {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
    font-style: italic;
    color: #555;
    position: relative;
}

.feedback-comments:before {
    content: '\f10d';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: -10px;
    left: 10px;
    font-size: 20px;
    color: #3498db;
    background: white;
    padding: 0 10px;
}

.feedback-thanks {
    margin-top: 15px;
    color: #2ecc71;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feedback-thanks i {
    margin-right: 8px;
    font-size: 20px;
}

/* Animation for submitted feedback */
@keyframes thanksPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.feedback-thanks {
    animation: thanksPulse 2s infinite;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Navigation
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
                
                // Save active tab to localStorage
                localStorage.setItem('activeTab', tabId);
            });
        });
        
        // Restore active tab from localStorage
        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            const activeButton = document.querySelector(`.tab-btn[data-tab="${activeTab}"]`);
            if (activeButton) {
                activeButton.click();
            }
        }
        
        // Close notification
        const closeButtons = document.querySelectorAll('.close-notification');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notification = this.closest('.notification');
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            });
        });
        
        // Auto-hide notifications after 5 seconds
        const notifications = document.querySelectorAll('.notification');
        if (notifications.length > 0) {
            setTimeout(() => {
                notifications.forEach(notification => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 300);
                });
            }, 5000);
        }
        
        // Image preview lightbox
        const imageLinks = document.querySelectorAll('.image-preview');
        imageLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const imgSrc = this.getAttribute('href');
                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox';
                
                const img = document.createElement('img');
                img.src = imgSrc;
                
                const closeBtn = document.createElement('button');
                closeBtn.className = 'lightbox-close';
                closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                
                lightbox.appendChild(img);
                lightbox.appendChild(closeBtn);
                document.body.appendChild(lightbox);
                
                // Prevent scrolling when lightbox is open
                document.body.style.overflow = 'hidden';
                
                // Close lightbox on click
                lightbox.addEventListener('click', function() {
                    document.body.style.overflow = '';
                    lightbox.remove();
                });
                
                // Prevent propagation when clicking on image
                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                // Close on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        document.body.style.overflow = '';
                        lightbox.remove();
                    }
                });
                
                // Close button
                closeBtn.addEventListener('click', function() {
                    document.body.style.overflow = '';
                    lightbox.remove();
                });
            });
        });
        
        // Star rating system
        const ratingSelects = document.querySelectorAll('select[name="rating"]');
        ratingSelects.forEach(select => {
            select.addEventListener('change', function() {
                const stars = this.value;
                const starsContainer = document.createElement('div');
                starsContainer.className = 'stars-container';
                
                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');
                    star.className = i <= stars ? 'fas fa-star' : 'far fa-star';
                    starsContainer.appendChild(star);
                }
                
                // Replace select with stars display
                const parentDiv = this.parentNode;
                parentDiv.appendChild(starsContainer);
            });
        });
        
        // Password strength meter
        const newPasswordInput = document.getElementById('new_password');
        if (newPasswordInput) {
            const strengthMeter = document.createElement('div');
            strengthMeter.className = 'password-strength';
            strengthMeter.innerHTML = '<div class="strength-meter"></div><p class="strength-text">Password strength</p>';
            
            newPasswordInput.parentNode.insertBefore(strengthMeter, newPasswordInput.nextSibling);
            
            const meter = strengthMeter.querySelector('.strength-meter');
            const text = strengthMeter.querySelector('.strength-text');
            
            newPasswordInput.addEventListener('input', function() {
                const val = this.value;
                let strength = 0;
                
                // Check password length
                if (val.length >= 8) strength += 1;
                
                // Check for mixed case
                if (val.match(/[a-z]/) && val.match(/[A-Z]/)) strength += 1;
                
                // Check for numbers
                if (val.match(/\d/)) strength += 1;
                
                // Check for special characters
                if (val.match(/[^a-zA-Z\d]/)) strength += 1;
                
                // Update meter
                meter.className = 'strength-meter';
                text.className = 'strength-text';
                
                if (val.length === 0) {
                    meter.className = 'strength-meter';
                    text.className = 'strength-text';
                    text.textContent = 'Password strength';
                } else if (strength < 2) {
                    meter.className = 'strength-meter weak';
                    text.className = 'strength-text weak';
                    text.textContent = 'Weak password';
                } else if (strength === 2) {
                    meter.className = 'strength-meter medium';
                    text.className = 'strength-text medium';
                    text.textContent = 'Medium password';
                } else if (strength === 3) {
                    meter.className = 'strength-meter strong';
                    text.className = 'strength-text strong';
                    text.textContent = 'Strong password';
                } else {
                    meter.className = 'strength-meter very-strong';
                    text.className = 'strength-text very-strong';
                    text.textContent = 'Very strong password';
                }
            });
        }
        
        // Confirm delete account
        const deleteAccountForm = document.querySelector('form[action*="delete_account"]');
        if (deleteAccountForm) {
            deleteAccountForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const confirmed = confirm('Are you sure you want to delete your account? This action cannot be undone.');
                
                if (confirmed) {
                    this.submit();
                }
            });
        }
    });
</script>

<?php include 'footer.php'; ?>