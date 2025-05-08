<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// OPTIONS request को हैंडल करें (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// JSON डेटा को पार्स करें
$input = json_decode(file_get_contents('php://input'), true);

// सेशन शुरू करें
session_start();

// डेटाबेस कनेक्शन
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// API रिस्पांस फंक्शन
function sendResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
    exit;
}

// टोकन वेरिफिकेशन फंक्शन
function verifyToken() {
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        sendResponse('error', 'Unauthorized: No token provided', null);
    }
    
    $token = $matches[1];
    
    // यहां आप JWT या अपना कस्टम टोकन वेरिफिकेशन लॉजिक लगा सकते हैं
    // अभी के लिए, हम एक सरल सेशन-बेस्ड टोकन वेरिफिकेशन का उपयोग करेंगे
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM api_tokens WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tokenData) {
        sendResponse('error', 'Unauthorized: Invalid or expired token', null);
    }
    
    return $tokenData['user_id'];
}

// API टोकन टेबल बनाने के लिए
function createTokenTable() {
    global $pdo;
    
    $sql = "CREATE TABLE IF NOT EXISTS api_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token VARCHAR(255) NOT NULL,
        user_role VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expires_at TIMESTAMP NOT NULL,
        UNIQUE KEY (token)
    )";
    
    $pdo->exec($sql);
}

// टोकन टेबल बनाएं
createTokenTable();