<?php
session_start();
require '../config/db.php';
require '../config/email.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'report') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $category = $_POST['category'];
        $gadget_type = $_POST['gadget_type'];

        // Handle file upload
        $file_path = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($_FILES['file']['name']);
            $file_path = $upload_dir . $file_name;
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
            $file_path = '/uploads/' . $file_name;
        }

        // Save issue to database
        $stmt = $pdo->prepare("INSERT INTO issues (user_id, description, category, gadget_type, attached_file) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $description, $category, $gadget_type, $file_path]);

        // Send confirmation email
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        $subject = "Issue Reported Successfully";
        $body = "Your issue has been reported successfully. We'll assign an agent soon.";
        sendEmail($user['email'], $subject, $body);

        header("Location: /views/user_dashboard.php");
        exit;
    }
}