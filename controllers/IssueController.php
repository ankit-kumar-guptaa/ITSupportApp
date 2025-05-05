<?php
session_start();
require '../config/db.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// यूजर लॉगिन चेक
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit;
}

// रिपोर्ट इश्यू एक्शन
if ($action === 'report') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $gadget_type = filter_input(INPUT_POST, 'gadget_type', FILTER_SANITIZE_STRING);
        
        // इनपुट वैलिडेशन
        if (empty($description) || empty($category) || empty($gadget_type)) {
            header("Location: /views/report_issue.php?error=सभी फील्ड आवश्यक हैं!");
            exit;
        }
        
        // वैध कैटेगरी चेक
        $valid_categories = ['Hardware', 'Software', 'Network'];
        if (!in_array($category, $valid_categories)) {
            header("Location: /views/report_issue.php?error=अमान्य श्रेणी!");
            exit;
        }
        
        // वैध गैजेट टाइप चेक
        $valid_gadget_types = ['Mobile', 'Laptop', 'MacBook', 'Other'];
        if (!in_array($gadget_type, $valid_gadget_types)) {
            header("Location: /views/report_issue.php?error=अमान्य गैजेट प्रकार!");
            exit;
        }
        
        // फाइल अपलोड हैंडलिंग
        $image_path = null;
        $attached_file = null;
        
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($_FILES['file']['type'], $allowed_types)) {
                header("Location: /views/report_issue.php?error=केवल JPG, PNG और PDF फाइलें स्वीकार की जाती हैं!");
                exit;
            }
            
            if ($_FILES['file']['size'] > $max_size) {
                header("Location: /views/report_issue.php?error=फाइल का आकार 5MB से कम होना चाहिए!");
                exit;
            }
            
            // अपलोड डायरेक्टरी बनाना (अगर मौजूद नहीं है)
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/issues/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // यूनिक फाइलनेम बनाना
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('issue_') . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            // फाइल अपलोड करना
            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                $file_path = '/uploads/issues/' . $new_filename;
                
                // फाइल टाइप के अनुसार कॉलम में सेव करना
                $file_type = $_FILES['file']['type'];
                if (strpos($file_type, 'image') !== false) {
                    $image_path = $file_path;
                } else {
                    $attached_file = $file_path;
                }
            } else {
                header("Location: /views/report_issue.php?error=फाइल अपलोड करने में समस्या हुई!");
                exit;
            }
        }
        
        // डेटाबेस में इश्यू इन्सर्ट करना
        $stmt = $pdo->prepare("INSERT INTO issues (user_id, description, category, gadget_type, image_path, attached_file, status, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");
        $stmt->execute([$_SESSION['user_id'], $description, $category, $gadget_type, $image_path, $attached_file]);
        
        // एक्टिविटी लॉग करना (अगर एक्टिविटी लॉग टेबल है)
        if (tableExists($pdo, 'activity_logs')) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, role, action, ip_address, created_at) 
                                VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$_SESSION['user_id'], 'user', 'नई समस्या रिपोर्ट की गई', $ip_address]);
        }
        
        header("Location: /views/user_dashboard.php?success=समस्या सफलतापूर्वक रिपोर्ट की गई!");
        exit;
    }
}

// टेबल एक्जिस्ट चेक फंक्शन
function tableExists($pdo, $table) {
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        return false;
    }
    return $result !== false;
}
?>