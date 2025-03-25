<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';

// Fetch user name if logged in
$user_name = '';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $user_name = $user ? htmlspecialchars($user['name']) : 'User';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support Hub</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/user_dashboard.css">
    <!-- AOS Animation CDN -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <style>
        /* Dropdown Styles */
.dropdown {
    position: relative;
    display: inline-block;
}
.dropdown-toggle {
    color: #1E3A8A;
    text-decoration: none;
    padding: 10px;
    display: block;
}
.dropdown-menu {
    display: none;
    position: absolute;
    background: white;
    min-width: 150px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1;
    top: 100%;
    right: 0;
}
.dropdown-menu li {
    list-style: none;
}
.dropdown-menu li a {
    color: #1E3A8A;
    padding: 10px 15px;
    display: block;
    text-decoration: none;
}
.dropdown-menu li a:hover {
    background: #F9FAFB;
}
.dropdown:hover .dropdown-menu {
    display: block;
}
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="/assets/logo.svg" alt="Logo" style=" vertical-align: middle;">
            <!-- <span>IT Support Hub</span> -->
        </div>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/views/report_issue.php">Report Issue</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"><?php echo $user_name; ?> ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="/views/user_dashboard.php">Dashboard</a></li>
                            <li><a href="/views/report_issue.php">Report Issue</a></li>
                            <li><a href="/views/reported_issues.php">Your Reported Issues</a></li>
                            <li><a href="/views/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="/views/login.php">Login/Signup</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>


    <style>
        :root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --text-color: #333;
    --background-color: #f4f4f4;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 50px;
    background-color: var(--background-color);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.logo img {
    max-height: 100px;
    vertical-align: middle;
    transition: transform 0.3s ease;
}

.logo img:hover {
    transform: scale(1.05);
}

nav ul {
    display: flex;
    list-style: none;
    align-items: center;
    margin: 0;
    padding: 0;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    text-decoration: none;
    color: var(--text-color);
    font-weight: 500;
    position: relative;
    transition: color 0.3s ease;
}

nav ul li a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -5px;
    left: 0;
    background-color: var(--secondary-color);
    transition: width 0.3s ease;
}

nav ul li a:hover {
    color: var(--secondary-color);
}

nav ul li a:hover::after {
    width: 100%;
}

.dropdown {
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    min-width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 1000;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-menu li {
    margin: 0;
}

.dropdown-menu li a {
    display: block;
    padding: 10px 15px;
    color: var(--text-color);
}

.dropdown-menu li a:hover {
    background-color: var(--background-color);
}
    </style>