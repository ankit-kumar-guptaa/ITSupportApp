<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['phone']) || !isset($data['problem'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$phone = trim($data['phone']);
$problem = trim($data['problem']);

// Validate inputs
if (empty($name) || empty($email) || empty($phone) || empty($problem)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    $conn = getDbConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Insert user query
    $stmt = $conn->prepare("INSERT INTO user_queries (name, email, phone, problem) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $problem]);
    $queryId = $conn->lastInsertId();
    
    // Send email to admin
    $adminEmail = 'admin@itsahayata.com';
    $subject = 'New IT Support Query';
    $message = "Name: $name\nEmail: $email\nPhone: $phone\nProblem: $problem";
    $headers = 'From: ' . $email;
    
    mail($adminEmail, $subject, $message, $headers);
    
    echo json_encode(['success' => true, 'queryId' => $queryId]);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>