<?php
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// लॉगिन API
if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        sendResponse('error', 'Email and password are required', null);
    }
    
    // यूजर को डेटाबेस से चेक करें
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_verified = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        // टोकन जनरेट करें
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        // टोकन को डेटाबेस में सेव करें
        $stmt = $pdo->prepare("INSERT INTO api_tokens (user_id, token, user_role, expires_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user['id'], $token, $user['role'], $expires_at]);
        
        // यूजर डेटा तैयार करें (पासवर्ड हटाकर)
        unset($user['password']);
        
        sendResponse('success', 'Login successful', [
            'user' => $user,
            'token' => $token,
            'expires_at' => $expires_at
        ]);
    } else {
        sendResponse('error', 'Invalid email or password', null);
    }
}

// रजिस्ट्रेशन API
if ($action === 'register') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    $phone_number = $input['phone_number'] ?? '';
    $address = $input['address'] ?? '';
    
    if (empty($name) || empty($email) || empty($password)) {
        sendResponse('error', 'Name, email and password are required', null);
    }
    
    // ईमेल वैलिडेशन
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse('error', 'Invalid email format', null);
    }
    
    // फोन नंबर वैलिडेशन
    if (!empty($phone_number) && !preg_match('/^[0-9]{10}$/', $phone_number)) {
        sendResponse('error', 'Phone number must be 10 digits', null);
    }
    
    // चेक करें कि ईमेल पहले से मौजूद तो नहीं है
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        sendResponse('error', 'Email already exists', null);
    }
    
    // पासवर्ड हैश करें
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // वेरिफिकेशन टोकन जनरेट करें
    $verification_token = bin2hex(random_bytes(16));
    
    // यूजर को डेटाबेस में सेव करें
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone_number, address, role, verification_token, is_verified) 
                          VALUES (?, ?, ?, ?, ?, 'user', ?, 0)");
    $stmt->execute([$name, $email, $hashed_password, $phone_number, $address, $verification_token]);
    
    $user_id = $pdo->lastInsertId();
    
    // ईमेल वेरिफिकेशन लिंक भेजें (यहां आप अपना ईमेल भेजने का कोड लगा सकते हैं)
    // sendVerificationEmail($email, $verification_token);
    
    sendResponse('success', 'Registration successful. Please verify your email.', [
        'user_id' => $user_id,
        'verification_token' => $verification_token
    ]);
}

// ईमेल वेरिफिकेशन API
if ($action === 'verify_email') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $token = $input['token'] ?? '';
    
    if (empty($token)) {
        sendResponse('error', 'Verification token is required', null);
    }
    
    // टोकन को डेटाबेस में चेक करें
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // यूजर को वेरिफाइड मार्क करें
        $stmt = $pdo->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        sendResponse('success', 'Email verified successfully. You can now login.', null);
    } else {
        sendResponse('error', 'Invalid or expired verification token', null);
    }
}

// लॉगआउट API
if ($action === 'logout') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    // यूजर के सभी टोकन डिलीट करें
    $stmt = $pdo->prepare("DELETE FROM api_tokens WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    sendResponse('success', 'Logged out successfully', null);
}

// पासवर्ड रीसेट रिक्वेस्ट API
if ($action === 'forgot_password') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $email = $input['email'] ?? '';
    
    if (empty($email)) {
        sendResponse('error', 'Email is required', null);
    }
    
    // ईमेल को डेटाबेस में चेक करें
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND is_verified = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // रीसेट टोकन जनरेट करें
        $reset_token = bin2hex(random_bytes(16));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // रीसेट टोकन को डेटाबेस में सेव करें
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE id = ?");
        $stmt->execute([$reset_token, $expires_at, $user['id']]);
        
        // रीसेट ईमेल भेजें (यहां आप अपना ईमेल भेजने का कोड लगा सकते हैं)
        // sendPasswordResetEmail($email, $reset_token);
        
        sendResponse('success', 'Password reset link has been sent to your email', null);
    } else {
        // सिक्योरिटी के लिए हम यहां भी सक्सेस मैसेज भेजेंगे
        sendResponse('success', 'Password reset link has been sent to your email', null);
    }
}

// पासवर्ड रीसेट API
if ($action === 'reset_password') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $token = $input['token'] ?? '';
    $password = $input['password'] ?? '';
    
    if (empty($token) || empty($password)) {
        sendResponse('error', 'Token and new password are required', null);
    }
    
    // टोकन को डेटाबेस में चेक करें
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // पासवर्ड हैश करें
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // पासवर्ड अपडेट करें और रीसेट टोकन हटाएं
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
        $stmt->execute([$hashed_password, $user['id']]);
        
        sendResponse('success', 'Password has been reset successfully', null);
    } else {
        sendResponse('error', 'Invalid or expired reset token', null);
    }
}

// अगर कोई एक्शन मैच नहीं हुआ
sendResponse('error', 'Invalid action', null);