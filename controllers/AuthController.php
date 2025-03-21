<?php
// Check if session is already active before starting
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../config/db.php';
require '../config/email.php';

// Set PHP time zone to match MySQL
date_default_timezone_set('Asia/Kolkata');

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'signup') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
            exit;
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Debug: Log OTP and expiry
        echo "Debug: Generated OTP - $otp (Expires at: $expires_at)<br>";

        // Save OTP to database
        $stmt = $pdo->prepare("INSERT INTO otps (email, otp, expires_at) VALUES (?, ?, ?)");
        if (!$stmt->execute([$email, $otp, $expires_at])) {
            echo "Error saving OTP: " . implode(" - ", $stmt->errorInfo());
            exit;
        }

        // Send OTP via email
        $subject = "Your OTP for IT Support Hub";
        $body = "Dear $name,<br><br>Your OTP for signup is: <b>$otp</b>. It is valid for 30 minutes.<br><br>Thank you,<br>IT Support Hub Team";
        if (sendEmail($email, $subject, $body)) {
            // Temporarily store user data in session
            $_SESSION['pending_user'] = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];
            header("Location: /views/verify_otp.php?email=$email");
            exit;
        } else {
            echo "Failed to send OTP. Please try again.";
        }
    }
}

if ($action === 'verify_otp') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $otp = trim($_POST['otp']);

        // Debug: Log the input OTP
        echo "Debug: Input OTP - $otp<br>";

        // Debug: Get current server time (PHP)
        $current_time = date('Y-m-d H:i:s');
        echo "Debug: Current Server Time (PHP) - $current_time<br>";

        // Debug: Get MySQL NOW() time
        $stmt = $pdo->query("SELECT NOW() as now");
        $mysql_time = $stmt->fetch()['now'];
        echo "Debug: MySQL NOW() Time - $mysql_time<br>";

        // Check OTP
        $stmt = $pdo->prepare("SELECT * FROM otps WHERE email = ? AND otp = ? AND expires_at > NOW()");
        $stmt->execute([$email, $otp]);
        $otp_record = $stmt->fetch();

        if ($otp_record) {
            // OTP verified, register the user
            $user = $_SESSION['pending_user'];
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_verified) VALUES (?, ?, ?, 1)");
            $stmt->execute([$user['name'], $user['email'], $user['password']]);

            // Delete OTP
            $stmt = $pdo->prepare("DELETE FROM otps WHERE email = ?");
            $stmt->execute([$email]);

            // Send welcome email
            $subject = "Welcome to IT Support Hub!";
            $body = "Dear {$user['name']},<br><br>Welcome to IT Support Hub! Your account has been successfully created. We're here to help you with all your tech issues.<br><br>Best regards,<br>IT Support Hub Team";
            sendEmail($user['email'], $subject, $body);

            // Clear session
            unset($_SESSION['pending_user']);

            header("Location: /views/login.php?success=Signup successful! Please login.");
            exit;
        } else {
            // Debug: Check why OTP verification failed
            $stmt = $pdo->prepare("SELECT * FROM otps WHERE email = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([$email]);
            $saved_otp = $stmt->fetch();
            if ($saved_otp) {
                echo "Debug: Saved OTP - {$saved_otp['otp']}<br>";
                echo "Debug: Expires at - {$saved_otp['expires_at']}<br>";
                if (strval($saved_otp['otp']) !== strval($otp)) {
                    echo "Debug: OTP mismatch! Saved OTP: {$saved_otp['otp']}, Input OTP: $otp<br>";
                } elseif (strtotime($saved_otp['expires_at']) < strtotime($mysql_time)) {
                    echo "Debug: OTP expired! Expires at: {$saved_otp['expires_at']}, MySQL NOW(): $mysql_time<br>";
                } else {
                    echo "Debug: No specific error detected, but OTP verification failed.<br>";
                }
            } else {
                echo "Debug: No OTP found for this email in the database!<br>";
            }
            echo "Invalid or expired OTP!";
        }
    }
}

if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_verified = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'user') {
                header("Location: /views/user_dashboard.php");
            } elseif ($user['role'] === 'agent') {
                header("Location: /views/agent_dashboard.php");
            } elseif ($user['role'] === 'admin') {
                header("Location: /admin/dashboard.php");
            }
            exit;
        } else {
            echo "Invalid email or password!";
        }
    }
}

if ($action === 'logout') {
    // Destroy session
    session_unset();
    session_destroy();
    header("Location: /views/login.php?success=Logged out successfully!");
    exit;
}