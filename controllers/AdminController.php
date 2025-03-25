<?php
session_start();
require '../config/db.php';
require '../config/email.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}

// Delete User
if ($action === 'delete_user') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];

        // Delete user's issues
        $stmt = $pdo->prepare("DELETE FROM issues WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        header("Location: /views/admin_dashboard.php?success=User deleted successfully!");
        exit;
    }
}

// Delete Agent
if ($action === 'delete_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];

        // Unassign agent from issues
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = NULL WHERE agent_id = ?");
        $stmt->execute([$agent_id]);

        // Delete agent
        $stmt = $pdo->prepare("DELETE FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);

        header("Location: /views/admin_dashboard.php?success=Agent deleted successfully!");
        exit;
    }
}

// Approve Agent
if ($action === 'approve_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];

        // Update agent status to approved
        $stmt = $pdo->prepare("UPDATE agents SET status = 'approved' WHERE id = ?");
        $stmt->execute([$agent_id]);

        // Fetch agent email
        $stmt = $pdo->prepare("SELECT email, name FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch();

        // Send approval email
        $subject = "Agent Account Approved - IT Support Hub";
        $body = "Dear {$agent['name']},<br><br>Your agent account has been approved. You can now log in to your dashboard.<br><br>Thank you,<br>IT Support Hub Team";
        sendEmail($agent['email'], $subject, $body);

        header("Location: /views/admin_dashboard.php?success=Agent approved successfully!");
        exit;
    }
}

// Reject Agent
if ($action === 'reject_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];
        $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);

        // Fetch agent email
        $stmt = $pdo->prepare("SELECT email, name FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch();

        // Update agent status to rejected
        $stmt = $pdo->prepare("UPDATE agents SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$agent_id]);

        // Send rejection email
        $subject = "Agent Account Rejected - IT Support Hub";
        $body = "Dear {$agent['name']},<br><br>Your agent account has been rejected. Reason: $reason<br><br>Thank you,<br>IT Support Hub Team";
        sendEmail($agent['email'], $subject, $body);

        header("Location: /views/admin_dashboard.php?success=Agent rejected successfully!");
        exit;
    }
}

// Assign Issue to Agent
if ($action === 'assign_issue') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $agent_id = $_POST['agent_id'];

        // Update issue with agent_id
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = ?, status = 'in_progress' WHERE id = ?");
        $stmt->execute([$agent_id, $issue_id]);

        header("Location: /views/admin_dashboard.php?success=Issue assigned successfully!");
        exit;
    }
}

// Update Issue Status
if ($action === 'update_issue_status') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $status = $_POST['status'];

        // Update issue status
        $stmt = $pdo->prepare("UPDATE issues SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $issue_id]);

        header("Location: /views/admin_dashboard.php?success=Issue status updated successfully!");
        exit;
    }
}

// Delete Issue
if ($action === 'delete_issue') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];

        // Delete issue
        $stmt = $pdo->prepare("DELETE FROM issues WHERE id = ?");
        $stmt->execute([$issue_id]);

        header("Location: /views/admin_dashboard.php?success=Issue deleted successfully!");
        exit;
    }
}

// Send Message to Agent
if ($action === 'send_message') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Save message to database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_role, recipient_id, recipient_role, message, created_at) 
                               VALUES (?, 'admin', ?, 'agent', ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $agent_id, $message]);

        header("Location: /views/admin_dashboard.php?success=Message sent to agent successfully!");
        exit;
    }
}