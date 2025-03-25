<?php
session_start();
require '../config/db.php';
require '../config/email.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $specialization = $_POST['specialization'];

        // Validate phone number
        if (!preg_match('/^[0-9]{10}$/', $phone_number)) {
            echo "Invalid phone number! Please enter a 10-digit number.";
            exit;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
            exit;
        }

        // Register agent
        $stmt = $pdo->prepare("INSERT INTO agents (name, email, phone_number, password, specialization) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone_number, $password, $specialization]);

        // Also add to users table with role 'agent'
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone_number, password, role, is_verified) VALUES (?, ?, ?, ?, 'agent', 1)");
        $stmt->execute([$name, $email, $phone_number, $password]);

        header("Location: /views/login.php?success=Agent registration successful! Please login.");
        exit;
    }
}