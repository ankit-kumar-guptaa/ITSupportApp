<?php
session_start();
require '../config/db.php';
require '../config/email.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'admin_register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $code = trim($_POST['code']);

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
            exit;
        }

        // Verify unique code
        $stmt = $pdo->prepare("SELECT * FROM admin_codes WHERE code = ? AND is_used = 0");
        $stmt->execute([$code]);
        $admin_code = $stmt->fetch();

        if (!$admin_code) {
            echo "Invalid or already used code!";
            exit;
        }

        // Register admin
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, is_verified) VALUES (?, ?, ?, 'admin', 1)");
        $stmt->execute([$name, $email, $password]);

        // Mark the code as used
        $stmt = $pdo->prepare("UPDATE admin_codes SET is_used = 1 WHERE code = ?");
        $stmt->execute([$code]);

        // Send welcome email
        $subject = "Welcome to IT Support Hub - Admin Account";
        $body = "Dear $name,<br><br>Welcome to IT Support Hub! Your admin account has been successfully created. You can now manage issues and assign agents.<br><br>Best regards,<br>IT Support Hub Team";
        sendEmail($email, $subject, $body);

        header("Location: /views/login.php?success=Admin registration successful! Please login.");
        exit;
    }
}

if ($action === 'assign_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $agent_id = $_POST['agent_id'];

        // Update issue with agent
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = ? WHERE id = ?");
        $stmt->execute([$agent_id, $issue_id]);

        // Send email notification to user
        $stmt = $pdo->prepare("SELECT u.email FROM issues i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
        $stmt->execute([$issue_id]);
        $user = $stmt->fetch();
        $stmt = $pdo->prepare("SELECT name FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch();
        $subject = "Agent Assigned to Your Issue";
        $body = "An agent ({$agent['name']}) has been assigned to your issue (ID: $issue_id).";
        sendEmail($user['email'], $subject, $body);

        header("Location: /admin/dashboard.php");
        exit;
    }
}

if ($action === 'delete_user') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];

        // Delete user from users table
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'user'");
        $stmt->execute([$user_id]);

        // Delete user's issues
        $stmt = $pdo->prepare("DELETE FROM issues WHERE user_id = ?");
        $stmt->execute([$user_id]);

        header("Location: /admin/dashboard.php");
        exit;
    }
}

if ($action === 'delete_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];

        // Remove agent from issues
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = NULL WHERE agent_id = ?");
        $stmt->execute([$agent_id]);

        // Delete agent from agents table
        $stmt = $pdo->prepare("DELETE FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);

        // Delete agent from users table
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'agent'");
        $stmt->execute([$agent_id]);

        header("Location: /admin/dashboard.php");
        exit;
    }
}

if ($action === 'toggle_agent_details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $show_agent_details = isset($_POST['show_agent_details']) ? 1 : 0;

        // Update show_agent_details in issues table
        $stmt = $pdo->prepare("UPDATE issues SET show_agent_details = ? WHERE id = ?");
        $stmt->execute([$show_agent_details, $issue_id]);

        header("Location: /admin/dashboard.php");
        exit;
    }
}

if ($action === 'toggle_user_details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $show_user_details = isset($_POST['show_user_details']) ? 1 : 0;

        // Update show_user_details in issues table
        $stmt = $pdo->prepare("UPDATE issues SET show_user_details = ? WHERE id = ?");
        $stmt->execute([$show_user_details, $issue_id]);

        header("Location: /admin/dashboard.php");
        exit;
    }
}