<?php
session_start();
require '../config/db.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    header("Location: /views/login.php");
    exit;
}

if ($action === 'update_issue_status') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $status = $_POST['status'];
        $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);

        // Update issue status and note
        $stmt = $pdo->prepare("UPDATE issues SET status = ?, resolution_note = ?, updated_at = NOW() WHERE id = ? AND agent_id = ?");
        $stmt->execute([$status, $note, $issue_id, $_SESSION['user_id']]);

        header("Location: /views/agent_dashboard.php?success=Issue status updated successfully!");
        exit;
    }
}

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


if ($action === 'send_message') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Fetch admin ID (assuming there's at least one admin)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin) {
            header("Location: /views/agent_dashboard.php?error=No admin found!");
            exit;
        }

        $admin_id = $admin['id'];

        // Save message to database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_role, recipient_id, recipient_role, message, created_at) 
                               VALUES (?, 'agent', ?, 'admin', ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $admin_id, $message]);

        header("Location: /views/agent_dashboard.php?success=Message sent to admin successfully!");
        exit;
    }
}

if ($action === 'send_message') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Fetch admin ID
        $stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin) {
            header("Location: /views/agent_dashboard.php?error=No admin found!");
            exit;
        }

        $admin_id = $admin['id'];

        // Save message to database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_role, recipient_id, recipient_role, message, created_at) 
                               VALUES (?, 'agent', ?, 'admin', ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $admin_id, $message]);

        // Log the action
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, role, action, ip_address, created_at) 
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], 'agent', 'Sent message to admin', $ip_address]);

        header("Location: /views/agent_dashboard.php?success=Message sent to admin successfully!");
        exit;
    }
}