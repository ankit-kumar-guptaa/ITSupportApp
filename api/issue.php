<?php
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// इश्यू रिपोर्ट API
if ($action === 'report') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $category = $input['category'] ?? '';
    $description = $input['description'] ?? '';
    $priority = $input['priority'] ?? 'Medium';
    
    if (empty($category) || empty($description)) {
        sendResponse('error', 'Category and description are required', null);
    }
    
    // इश्यू को डेटाबेस में सेव करें
    $stmt = $pdo->prepare("INSERT INTO issues (user_id, category, description, priority, status, created_at) 
                          VALUES (?, ?, ?, ?, 'Pending', NOW())");
    $stmt->execute([$user_id, $category, $description, $priority]);
    
    $issue_id = $pdo->lastInsertId();
    
    // इमेज अपलोड हैंडलिंग (यदि मोबाइल ऐप से base64 इमेज भेजी गई है)
    if (isset($input['image']) && !empty($input['image'])) {
        $image_data = $input['image'];
        $image_name = 'issue_' . $issue_id . '_' . time() . '.jpg';
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/issues/' . $image_name;
        
        // base64 डेटा को इमेज में कन्वर्ट करें
        $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        $image_data = base64_decode($image_data);
        
        // अपलोड डायरेक्टरी बनाएं यदि मौजूद नहीं है
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/issues/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/issues/', 0777, true);
        }
        
        // इमेज सेव करें
        file_put_contents($image_path, $image_data);
        
        // इमेज पाथ को डेटाबेस में अपडेट करें
        $image_url = '/uploads/issues/' . $image_name;
        $stmt = $pdo->prepare("UPDATE issues SET image_path = ? WHERE id = ?");
        $stmt->execute([$image_url, $issue_id]);
    }
    
    // फाइल अपलोड हैंडलिंग (यदि मोबाइल ऐप से base64 फाइल भेजी गई है)
    if (isset($input['file']) && !empty($input['file'])) {
        $file_data = $input['file'];
        $file_name = 'issue_' . $issue_id . '_' . time() . '.pdf';
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/files/' . $file_name;
        
        // base64 डेटा को फाइल में कन्वर्ट करें
        $file_data = str_replace('data:application/pdf;base64,', '', $file_data);
        $file_data = str_replace(' ', '+', $file_data);
        $file_data = base64_decode($file_data);
        
        // अपलोड डायरेक्टरी बनाएं यदि मौजूद नहीं है
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/files/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/files/', 0777, true);
        }
        
        // फाइल सेव करें
        file_put_contents($file_path, $file_data);
        
        // फाइल पाथ को डेटाबेस में अपडेट करें
        $file_url = '/uploads/files/' . $file_name;
        $stmt = $pdo->prepare("UPDATE issues SET attached_file = ? WHERE id = ?");
        $stmt->execute([$file_url, $issue_id]);
    }
    
    // नया इश्यू डेटा प्राप्त करें
    $stmt = $pdo->prepare("SELECT * FROM issues WHERE id = ?");
    $stmt->execute([$issue_id]);
    $issue = $stmt->fetch(PDO::FETCH_ASSOC);
    
    sendResponse('success', 'Issue reported successfully', $issue);
}

// यूजर के इश्यूज लिस्ट API
if ($action === 'list') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    // डीबग के लिए लॉग जोड़ें
    error_log("Fetching issues for user_id: $user_id");
    
    // पेजिनेशन पैरामीटर्स
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    // स्टेटस फिल्टर
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $status_condition = '';
    $params = [$user_id];
    
    if (!empty($status)) {
        $status_condition = "AND status = ?";
        $params[] = $status;
    }
    
    // इश्यूज प्राप्त करें
    $query = "SELECT i.*, a.name as agent_name, a.phone_number as agent_phone 
              FROM issues i 
              LEFT JOIN agents a ON i.agent_id = a.id 
              WHERE i.user_id = ? $status_condition
              ORDER BY i.created_at DESC
              LIMIT ? OFFSET ?";
              
    error_log("Query: $query");
    
    $stmt = $pdo->prepare($query);
    $params[] = $limit;
    $params[] = $offset;
    $stmt->execute($params);
    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    error_log("Found " . count($issues) . " issues");
    
    // टोटल इश्यूज काउंट प्राप्त करें
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues WHERE user_id = ? $status_condition");
    $count_params = [$user_id];
    if (!empty($status)) {
        $count_params[] = $status;
    }
    $stmt->execute($count_params);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    sendResponse('success', 'Issues retrieved successfully', [
        'issues' => $issues,
        'pagination' => [
            'total' => (int)$total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ]
    ]);
}

// इश्यू डिटेल्स API
if ($action === 'detail') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    // इश्यू डिटेल्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone 
                          FROM issues i 
                          LEFT JOIN agents a ON i.agent_id = a.id 
                          WHERE i.id = ? AND i.user_id = ?");
    $stmt->execute([$issue_id, $user_id]);
    $issue = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$issue) {
        sendResponse('error', 'Issue not found or access denied', null);
    }
    
    sendResponse('success', 'Issue details retrieved successfully', $issue);
}

// इश्यू अपडेट API (यूजर के लिए)
if ($action === 'update') {
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $description = $input['description'] ?? '';
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    if (empty($description)) {
        sendResponse('error', 'Description is required', null);
    }
    
    // चेक करें कि इश्यू यूजर का है या नहीं
    $stmt = $pdo->prepare("SELECT id FROM issues WHERE id = ? AND user_id = ? AND status = 'Pending'");
    $stmt->execute([$issue_id, $user_id]);
    if ($stmt->rowCount() === 0) {
        sendResponse('error', 'Issue not found, access denied, or cannot be updated (only pending issues can be updated)', null);
    }
    
    // इश्यू अपडेट करें
    $stmt = $pdo->prepare("UPDATE issues SET description = ? WHERE id = ?");
    $stmt->execute([$description, $issue_id]);
    
    // अपडेटेड इश्यू डिटेल्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT * FROM issues WHERE id = ?");
    $stmt->execute([$issue_id]);
    $issue = $stmt->fetch(PDO::FETCH_ASSOC);
    
    sendResponse('success', 'Issue updated successfully', $issue);
}

// इश्यू कैंसिल API (यूजर के लिए)
if ($action === 'cancel') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $user_id = verifyToken();
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    // चेक करें कि इश्यू यूजर का है या नहीं और पेंडिंग है या नहीं
    $stmt = $pdo->prepare("SELECT id FROM issues WHERE id = ? AND user_id = ? AND status = 'Pending'");
    $stmt->execute([$issue_id, $user_id]);
    if ($stmt->rowCount() === 0) {
        sendResponse('error', 'Issue not found, access denied, or cannot be cancelled (only pending issues can be cancelled)', null);
    }
    
    // इश्यू कैंसिल करें
    $stmt = $pdo->prepare("UPDATE issues SET status = 'Cancelled' WHERE id = ?");
    $stmt->execute([$issue_id]);
    
    sendResponse('success', 'Issue cancelled successfully', null);
}

// अगर कोई एक्शन मैच नहीं हुआ
sendResponse('error', 'Invalid action', null);