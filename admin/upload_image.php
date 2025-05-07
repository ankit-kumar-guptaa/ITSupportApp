<?php
// Admin authentication check
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Create uploads directory if it doesn't exist
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/blog';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle image upload
if (isset($_FILES['file'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($_FILES['file']['type'], $allowed_types)) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Only JPG, PNG, GIF, and WEBP images are allowed']);
        exit;
    }
    
    if ($_FILES['file']['size'] > $max_size) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Image size should be less than 5MB']);
        exit;
    }
    
    // Generate unique filename
    $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid() . '.' . $file_extension;
    $upload_path = $upload_dir . '/' . $new_filename;
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
        // Return success response for TinyMCE
        echo json_encode([
            'location' => '/uploads/blog/' . $new_filename
        ]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Failed to upload image']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'No file uploaded']);
}