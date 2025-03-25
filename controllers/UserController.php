<?php
session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../config/db.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}

if ($action === 'update_phone') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);

        // Validate phone number
        if (!preg_match('/^[0-9]{10}$/', $phone_number)) {
            header("Location: /views/user_dashboard.php?error=Invalid phone number! Please enter a 10-digit number.");
            exit;
        }

        // Update phone number
        $stmt = $pdo->prepare("UPDATE users SET phone_number = ? WHERE id = ?");
        $stmt->execute([$phone_number, $_SESSION['user_id']]);

        header("Location: /views/user_dashboard.php?success=Phone number updated successfully!");
        exit;
    }
}

if ($action === 'update_address') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

        // Validate address (basic check for non-empty)
        if (empty($address)) {
            header("Location: /views/user_dashboard.php?error=Address cannot be empty!");
            exit;
        }

        // Update address
        $stmt = $pdo->prepare("UPDATE users SET address = ? WHERE id = ?");
        $stmt->execute([$address, $_SESSION['user_id']]);

        header("Location: /views/user_dashboard.php?success=Address updated successfully!");
        exit;
    }
}

if ($action === 'update_email') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /views/user_dashboard.php?error=Invalid email format!");
            exit;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $_SESSION['user_id']]);
        if ($stmt->rowCount() > 0) {
            header("Location: /views/user_dashboard.php?error=Email already exists!");
            exit;
        }

        // Update email
        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute([$email, $_SESSION['user_id']]);

        header("Location: /views/user_dashboard.php?success=Email updated successfully!");
        exit;
    }
}

if ($action === 'change_password') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];

        // Fetch current password
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Verify current password
        if (!password_verify($current_password, $user['password'])) {
            header("Location: /views/user_dashboard.php?error=Current password is incorrect!");
            exit;
        }

        // Validate new password (minimum 8 characters, 1 uppercase, 1 number, 1 special character)
        if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[0-9]/', $new_password) || !preg_match('/[^A-Za-z0-9]/', $new_password)) {
            header("Location: /views/user_dashboard.php?error=New password must be at least 8 characters long, with 1 uppercase letter, 1 number, and 1 special character!");
            exit;
        }

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);

        header("Location: /views/user_dashboard.php?success=Password changed successfully!");
        exit;
    }
}

if ($action === 'delete_account') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Delete user's issues
        $stmt = $pdo->prepare("DELETE FROM issues WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);

        // Delete user account
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);

        // Clear session and logout
        session_unset();
        session_destroy();

        header("Location: /views/login.php?success=Account deleted successfully!");
        exit;
    }
}