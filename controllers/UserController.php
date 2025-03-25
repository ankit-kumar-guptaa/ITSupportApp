<?php
session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../config/db.php';
require '../config/email.php'; // Assuming this contains the sendEmail function

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

if ($action === 'update_email_request') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Validate email
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /views/user_dashboard.php?error=Invalid email format!");
            exit;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$new_email, $_SESSION['user_id']]);
        if ($stmt->rowCount() > 0) {
            header("Location: /views/user_dashboard.php?error=Email already exists!");
            exit;
        }

        // Fetch current email
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $current_email = $stmt->fetch()['email'];

        // Generate OTP
        $otp = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Save OTP to database
        $stmt = $pdo->prepare("INSERT INTO otps (email, otp, expires_at, action) VALUES (?, ?, ?, 'email_update')");
        $stmt->execute([$current_email, $otp, $expires_at]);

        // Send OTP via email
        $subject = "OTP for Email Update - IT Support Hub";
        $body = "Dear {$userData['name']},<br><br>Your OTP for email update is: <b>$otp</b>. It is valid for 30 minutes.<br><br>Thank you,<br>IT Support Hub Team";
        if (sendEmail($current_email, $subject, $body)) {
            // Store new email in session temporarily
            $_SESSION['pending_email_update'] = [
                'new_email' => $new_email,
                'current_email' => $current_email
            ];
            header("Location: /views/verify_email_otp.php");
            exit;
        } else {
            header("Location: /views/user_dashboard.php?error=Failed to send OTP. Please try again.");
            exit;
        }
    }
}

if ($action === 'verify_email_otp') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $otp = trim($_POST['otp']);
        $current_email = $_SESSION['pending_email_update']['current_email'];
        $new_email = $_SESSION['pending_email_update']['new_email'];

        // Check OTP
        $stmt = $pdo->prepare("SELECT * FROM otps WHERE email = ? AND otp = ? AND expires_at > NOW() AND action = 'email_update'");
        $stmt->execute([$current_email, $otp]);
        $otp_record = $stmt->fetch();

        if ($otp_record) {
            // OTP verified, update the email
            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->execute([$new_email, $_SESSION['user_id']]);

            // Delete OTP
            $stmt = $pdo->prepare("DELETE FROM otps WHERE email = ? AND action = 'email_update'");
            $stmt->execute([$current_email]);

            // Clear session
            unset($_SESSION['pending_email_update']);

            header("Location: /views/user_dashboard.php?success=Email updated successfully!");
            exit;
        } else {
            header("Location: /views/verify_email_otp.php?error=Invalid or expired OTP!");
            exit;
        }
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