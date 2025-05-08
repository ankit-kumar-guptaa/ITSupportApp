<?php
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// यूजर प्रोफाइल API
if ($action === 'profile') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    // यूजर डेटा प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, role, is_verified FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        sendResponse('success', 'User profile retrieved successfully', $user);
    } else {
        sendResponse('error', 'User not found', null);
    }
}

// प्रोफाइल अपडेट API
if ($action === 'update_profile') {
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $name = $input['name'] ?? '';
    $phone_number = $input['phone_number'] ?? '';
    $address = $input['address'] ?? '';
    
    // फोन नंबर वैलिडेशन
    if (!empty($phone_number) && !preg_match('/^[0-9]{10}$/', $phone_number)) {
        sendResponse('error', 'Phone number must be 10 digits', null);
    }
    
    // अपडेट करने के लिए फील्ड्स तैयार करें
    $fields = [];
    $params = [];
    
    if (!empty($name)) {
        $fields[] = "name = ?";
        $params[] = $name;
    }
    
    if (!empty($phone_number)) {
        $fields[] = "phone_number = ?";
        $params[] = $phone_number;
    }
    
    if (!empty($address)) {
        $fields[] = "address = ?";
        $params[] = $address;
    }
    
    if (empty($fields)) {
        sendResponse('error', 'No fields to update', null);
    }
    
    // यूजर को अपडेट करें
    $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
    $params[] = $user_id;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    // अपडेटेड यूजर डेटा प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, role, is_verified FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    sendResponse('success', 'Profile updated successfully', $user);
}

// ईमेल अपडेट रिक्वेस्ट API
if ($action === 'update_email_request') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $email = $input['email'] ?? '';
    
    if (empty($email)) {
        sendResponse('error', 'Email is required', null);
    }
    
    // ईमेल वैलिडेशन
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse('error', 'Invalid email format', null);
    }
    
    // चेक करें कि ईमेल पहले से मौजूद तो नहीं है
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $user_id]);
    if ($stmt->rowCount() > 0) {
        sendResponse('error', 'Email already exists', null);
    }
    
    // OTP जनरेट करें
    $otp = sprintf("%06d", mt_rand(100000, 999999));
    $otp_expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    
    // OTP को डेटाबेस में सेव करें
    $stmt = $pdo->prepare("UPDATE users SET email_update_otp = ?, email_update_otp_expires = ?, pending_email = ? WHERE id = ?");
    $stmt->execute([$otp, $otp_expires, $email, $user_id]);
    
    // OTP ईमेल भेजें (यहां आप अपना ईमेल भेजने का कोड लगा सकते हैं)
    // sendEmailUpdateOTP($email, $otp);
    
    sendResponse('success', 'OTP has been sent to your new email', null);
}

// ईमेल अपडेट वेरिफिकेशन API
if ($action === 'verify_email_update') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $otp = $input['otp'] ?? '';
    
    if (empty($otp)) {
        sendResponse('error', 'OTP is required', null);
    }
    
    // OTP को डेटाबेस में चेक करें
    $stmt = $pdo->prepare("SELECT pending_email FROM users WHERE id = ? AND email_update_otp = ? AND email_update_otp_expires > NOW()");
    $stmt->execute([$user_id, $otp]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // ईमेल अपडेट करें और OTP फील्ड्स क्लियर करें
        $stmt = $pdo->prepare("UPDATE users SET email = pending_email, pending_email = NULL, email_update_otp = NULL, email_update_otp_expires = NULL WHERE id = ?");
        $stmt->execute([$user_id]);
        
        sendResponse('success', 'Email updated successfully', ['email' => $user['pending_email']]);
    } else {
        sendResponse('error', 'Invalid or expired OTP', null);
    }
}

// पासवर्ड चेंज API
if ($action === 'change_password') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $current_password = $input['current_password'] ?? '';
    $new_password = $input['new_password'] ?? '';
    
    if (empty($current_password) || empty($new_password)) {
        sendResponse('error', 'Current password and new password are required', null);
    }
    
    // वर्तमान पासवर्ड चेक करें
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || !password_verify($current_password, $user['password'])) {
        sendResponse('error', 'Current password is incorrect', null);
    }
    
    // नया पासवर्ड हैश करें
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // पासवर्ड अपडेट करें
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $user_id]);
    
    sendResponse('success', 'Password changed successfully', null);
}

// डैशबोर्ड स्टैट्स API
if ($action === 'dashboard_stats') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    // स्टैट्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT 
                          COUNT(*) as total,
                          SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                          SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress,
                          SUM(CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END) as resolved
                          FROM issues WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    sendResponse('success', 'Dashboard stats retrieved successfully', $stats);
}

// अगर कोई एक्शन मैच नहीं हुआ
sendResponse('error', 'Invalid action', null);