<?php
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// एजेंट प्रोफाइल API
if ($action === 'profile') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    // एजेंट डेटा प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email, phone_number, department, role FROM agents WHERE id = ?");
    $stmt->execute([$agent_id]);
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($agent) {
        sendResponse('success', 'Agent profile retrieved successfully', $agent);
    } else {
        sendResponse('error', 'Agent not found', null);
    }
}

// असाइन्ड इश्यूज लिस्ट API
if ($action === 'assigned_issues') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    // पेजिनेशन पैरामीटर्स
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    // स्टेटस फिल्टर
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $status_condition = '';
    $params = [$agent_id];
    
    if (!empty($status)) {
        $status_condition = "AND status = ?";
        $params[] = $status;
    }
    
    // असाइन्ड इश्यूज प्राप्त करें
    $stmt = $pdo->prepare("SELECT i.*, u.name as user_name, u.phone_number as user_phone 
                          FROM issues i 
                          JOIN users u ON i.user_id = u.id 
                          WHERE i.agent_id = ? $status_condition
                          ORDER BY i.created_at DESC
                          LIMIT ? OFFSET ?");
    $params[] = $limit;
    $params[] = $offset;
    $stmt->execute($params);
    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // टोटल इश्यूज काउंट प्राप्त करें
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues WHERE agent_id = ? $status_condition");
    $count_params = [$agent_id];
    if (!empty($status)) {
        $count_params[] = $status;
    }
    $stmt->execute($count_params);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    sendResponse('success', 'Assigned issues retrieved successfully', [
        'issues' => $issues,
        'pagination' => [
            'total' => (int)$total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ]
    ]);
}

// इश्यू डिटेल्स API (एजेंट के लिए)
if ($action === 'issue_detail') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    // इश्यू डिटेल्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT i.*, u.name as user_name, u.phone_number as user_phone, u.email as user_email, u.address as user_address
                          FROM issues i 
                          JOIN users u ON i.user_id = u.id 
                          WHERE i.id = ? AND (i.agent_id = ? OR i.agent_id IS NULL)");
    $stmt->execute([$issue_id, $agent_id]);
    $issue = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$issue) {
        sendResponse('error', 'Issue not found or access denied', null);
    }
    
    sendResponse('success', 'Issue details retrieved successfully', $issue);
}

// इश्यू असाइन API (एजेंट के लिए)
if ($action === 'assign_issue') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    // चेक करें कि इश्यू पेंडिंग है या नहीं और किसी एजेंट को असाइन नहीं है
    $stmt = $pdo->prepare("SELECT id FROM issues WHERE id = ? AND status = 'Pending' AND agent_id IS NULL");
    $stmt->execute([$issue_id]);
    if ($stmt->rowCount() === 0) {
        sendResponse('error', 'Issue not found, already assigned, or not in pending status', null);
    }
    
    // इश्यू को एजेंट को असाइन करें
    $stmt = $pdo->prepare("UPDATE issues SET agent_id = ?, status = 'In Progress', updated_at = NOW() WHERE id = ?");
    $stmt->execute([$agent_id, $issue_id]);
    
    sendResponse('success', 'Issue assigned successfully', null);
}

// इश्यू स्टेटस अपडेट API (एजेंट के लिए)
if ($action === 'update_status') {
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    $issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $status = $input['status'] ?? '';
    $resolution = $input['resolution'] ?? '';
    
    if ($issue_id <= 0) {
        sendResponse('error', 'Invalid issue ID', null);
    }
    
    if (empty($status) || !in_array($status, ['In Progress', 'Resolved'])) {
        sendResponse('error', 'Invalid status. Status must be In Progress or Resolved', null);
    }
    
    if ($status === 'Resolved' && empty($resolution)) {
        sendResponse('error', 'Resolution is required when status is Resolved', null);
    }
    
    // चेक करें कि इश्यू एजेंट को असाइन है या नहीं
    $stmt = $pdo->prepare("SELECT id FROM issues WHERE id = ? AND agent_id = ?");
    $stmt->execute([$issue_id, $agent_id]);
    if ($stmt->rowCount() === 0) {
        sendResponse('error', 'Issue not found or not assigned to you', null);
    }
    
    // इश्यू स्टेटस अपडेट करें
    $sql = "UPDATE issues SET status = ?, updated_at = NOW()";
    $params = [$status, $issue_id];
    
    if (!empty($resolution)) {
        $sql .= ", resolution = ?";
        array_splice($params, 1, 0, [$resolution]);
    }
    
    $sql .= " WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    sendResponse('success', 'Issue status updated successfully', null);
}

// एजेंट डैशबोर्ड स्टैट्स API
if ($action === 'dashboard_stats') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $agent_id = verifyToken('agent');
    
    // स्टैट्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT 
                          COUNT(*) as total,
                          SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress,
                          SUM(CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END) as resolved
                          FROM issues WHERE agent_id = ?");
    $stmt->execute([$agent_id]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    sendResponse('success', 'Dashboard stats retrieved successfully', $stats);
}

// अगर कोई एक्शन मैच नहीं हुआ
sendResponse('error', 'Invalid action', null);