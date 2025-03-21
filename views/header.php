<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <img src="/assets/images/logo.png" alt="Logo" style="width: 40px; vertical-align: middle;">
            <span>IT Support Hub</span>
        </div>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/views/report.php">Report Issue</a></li>
                <li><a href="/views/faq.php">FAQ</a></li>
                <li><a href="/views/contact.php">Contact</a></li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="/views/logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="/views/login.php">Login/Signup</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>