<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['queryId']) || !isset($data['message']) || !isset($data['isUser'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$queryId = (int)$data['queryId'];
$message = trim($data['message']);
$isUser = (bool)$data['isUser'];

try {
    $conn = getDbConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    $stmt = $conn->prepare("INSERT INTO chat_messages (query_id, message, is_user) VALUES (?, ?, ?)");
    $stmt->execute([$queryId, $message, $isUser ? 1 : 0]);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>