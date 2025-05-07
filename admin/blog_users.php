<?php
// Admin authentication check
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php");
    exit;
}

// Initialize variables
$user = [
    'id' => '',
    'username' => '',
    'name' => '',
    'email' => '',
    'role' => 'agent'
];
$errors = [];
$success_message = '';

// Handle form submission for adding/editing user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_user'])) {
    $user['id'] = $_POST['user_id'] ?? '';
    $user['username'] = trim($_POST['username'] ?? '');
    $user['name'] = trim($_POST['name'] ?? '');
    $user['email'] = trim($_POST['email'] ?? '');
    $user['role'] = $_POST['role'] ?? 'agent';
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($user['username'])) {
        $errors[] = "Username is required";
    }
    
    if (empty($user['name'])) {
        $errors[] = "Name is required";
    }
    
    if (empty($user['email'])) {
        $errors[] = "Email is required";
    } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if username or email already exists
    if (!$user['id']) {
        $stmt = $pdo->prepare("SELECT id FROM blog_users WHERE username = ? OR email = ?");
        $stmt->execute([$user['username'], $user['email']]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Username or email already exists";
        }
        
        if (empty($password)) {
            $errors[] = "Password is required for new users";
        }
    }
    
    // If no errors, save to database
    if (empty($errors)) {
        if ($user['id']) {
            // Update existing user
            if (!empty($password)) {
                // Update with new password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    UPDATE blog_users 
                    SET username = ?, name = ?, email = ?, role = ?, password = ? 
                    WHERE id = ?
                ");
                $stmt->execute([
                    $user['username'], 
                    $user['name'], 
                    $user['email'], 
                    $user['role'],
                    $hashed_password,
                    $user['id']
                ]);
            } else {
                            // Update without changing password
                            $stmt = $pdo->prepare("
                            UPDATE blog_users 
                            SET username = ?, name = ?, email = ?, role = ? 
                            WHERE id = ?
                        ");
                        $stmt->execute([
                            $user['username'], 
                            $user['name'], 
                            $user['email'], 
                            $user['role'],
                            $user['id']
                        ]);
                    }
                    $success_message = "User updated successfully!";
                } else {
                    // Create new user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("
                        INSERT INTO blog_users (username, name, email, role, password, created_at) 
                        VALUES (?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([
                        $user['username'], 
                        $user['name'], 
                        $user['email'], 
                        $user['role'],
                        $hashed_password
                    ]);
                    $success_message = "New user created successfully!";
                }
                
                // Reset form after successful submission
                $user = [
                    'id' => '',
                    'username' => '',
                    'name' => '',
                    'email' => '',
                    'role' => 'agent'
                ];
            }
        }
        
        // Handle edit user request
        if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $stmt = $pdo->prepare("SELECT id, username, name, email, role FROM blog_users WHERE id = ?");
            $stmt->execute([$_GET['edit']]);
            $edit_user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($edit_user) {
                $user = $edit_user;
            }
        }
        
        // Handle delete user request
        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $stmt = $pdo->prepare("DELETE FROM blog_users WHERE id = ?");
            $stmt->execute([$_GET['delete']]);
            $success_message = "User deleted successfully!";
        }
        
        // Fetch all blog users
        $stmt = $pdo->query("SELECT * FROM blog_users ORDER BY created_at DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>