<?php
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// एडमिन प्रोफाइल API
if ($action === 'profile') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $admin_id = verifyToken('admin');
    
    // एडमिन डेटा प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email FROM admins WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        sendResponse('success', 'Admin profile retrieved successfully', $admin);
    } else {
        sendResponse('error', 'Admin not found', null);
    }
}

// यूजर्स लिस्ट API
if ($action === 'users') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $admin_id = verifyToken('admin');
    
    // पेजिनेशन पैरामीटर्स
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    // सर्च पैरामीटर
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_condition = '';
    $params = [];
    
    if (!empty($search)) {
        $search_condition = "WHERE name LIKE ? OR email LIKE ? OR phone_number LIKE ?";
        $search_param = "%$search%";
        $params = [$search_param, $search_param, $search_param];
    }
    
    // यूजर्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, is_verified, created_at 
                          FROM users $search_condition
                          ORDER BY created_at DESC
                          LIMIT ? OFFSET ?");
    $params[] = $limit;
    $params[] = $offset;
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // टोटल यूजर्स काउंट प्राप्त करें
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users $search_condition");
    $count_params = [];
    if (!empty($search)) {
        $search_param = "%$search%";
        $count_params = [$search_param, $search_param, $search_param];
    }
    $stmt->execute($count_params);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    sendResponse('success', 'Users retrieved successfully', [
        'users' => $users,
        'pagination' => [
            'total' => (int)$total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ]
    ]);
}

// एजेंट्स लिस्ट API
if ($action === 'agents') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $admin_id = verifyToken('admin');
    
    // पेजिनेशन पैरामीटर्स
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    // सर्च पैरामीटर
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_condition = '';
    $params = [];
    
    if (!empty($search)) {
        $search_condition = "WHERE name LIKE ? OR email LIKE ? OR phone_number LIKE ? OR department LIKE ?";
        $search_param = "%$search%";
        $params = [$search_param, $search_param, $search_param, $search_param];
    }
    
    // एजेंट्स प्राप्त करें
    $stmt = $pdo->prepare("SELECT id, name, email, phone_number, department, created_at 
                          FROM agents $search_condition
                          ORDER BY created_at DESC
                          LIMIT ? OFFSET ?");
    $params[] = $limit;
    $params[] = $offset;
    $stmt->execute($params);
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // टोटल एजेंट्स काउंट प्राप्त करें
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM agents $search_condition");
    $count_params = [];
    if (!empty($search)) {
        $search_param = "%$search%";
        $count_params = [$search_param, $search_param, $search_param, $search_param];
    }
    $stmt->execute($count_params);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    sendResponse('success', 'Agents retrieved successfully', [
        'agents' => $agents,
        'pagination' => [
            'total' => (int)$total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ]
    ]);
}

// इश्यूज लिस्ट API (एडमिन के लिए)
if ($action === 'issues') {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendResponse('error', 'Invalid request method', null);
    }
    
    $admin_id = verifyToken('admin');
    
    // पेजिनेशन पैरामीटर्स
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    // फिल्टर पैरामीटर्स
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    
    $conditions = [];
    $params = [];
    
    if (!empty($status)) {
        $conditions[] = "i.status = ?";
        $params[] = $status;
    }
    
    if (!empty($category)) {
        $conditions[] = "i.category = ?";
        $params[] = $category;
    }
    
    $where_clause = '';
    if (!empty($conditions)) {
        $where_clause = "WHERE " . implode(" AND ", $conditions);
    }
    
    // इश्यूज प्राप्त करें
    $stmt = $pdo->prepare("SELECT i.*, u.name as user_name, a.name as agent_name 
                          FROM issues i 
                          LEFT JOIN users u ON i.user_id = u.id 
                                                LEFT JOIN agents a ON i.agent_id = a.id
                          $where_clause
                          ORDER BY i.created_at DESC
                          LIMIT ? OFFSET ?");
    $params[] = $limit;
    $params[] = $offset;
    $stmt->execute($params);
    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // टोटल इश्यूज काउंट प्राप्त करें
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues i $where_clause");
    $count_params = [];
    if (!empty($conditions)) {
        $count_params = $params;
        array_pop($count_params); // Remove limit
        array_pop($count_params); // Remove offset
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