<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

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
    <title>IT Sahayta</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-dark: #2c3e50;
            --text-light: #858796;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6b48ff 0%, #00ddeb 100%);
            min-height: 100vh;
        }
        
        /* Larger logo and better spacing */
        .navbar-brand {
            margin-right: 3rem; /* Increased space between logo and nav */
            padding: 0.5rem 0;
        }
        
        .navbar-brand img {
            height: 68px; /* Increased logo size */
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .navbar {
            padding: 0.5rem 3rem; /* Increased side padding */
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Navigation items spacing */
        .navbar-nav {
            gap: 2rem; /* Space between nav items */
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.5rem 1.1rem !important;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link:focus {
            color: var(--primary-color) !important;
        }
        
        .nav-link:hover::after {
            width: 70%;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 400;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: var(--primary-color);
            color: white !important;
        }
        
        .dropdown-divider {
            margin: 0.3rem 0;
        }
        
        .user-avatar {
            width: 36px; /* Slightly larger avatar */
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px; /* Increased spacing */
        }
        
        .btn-login {
            background: var(--primary-color);
            color: white !important;
            border-radius: 50px;
            padding: 0.6rem 1.75rem !important; /* Slightly larger buttons */
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            margin-left: 0.5rem;
        }
        
        .btn-login:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        
        .btn-agent {
            background: #f8f9fc;
            color: var(--primary-color) !important;
            border-radius: 50px;
            padding: 0.6rem 1.75rem !important;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid var(--primary-color);
            margin-left: 0.5rem;
        }
        
        .btn-agent:hover {
            background: var(--primary-color);
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            margin-left: auto;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        @media (max-width: 991.98px) {
            .navbar {
                padding: 0.8rem 1.5rem;
            }
            
            .navbar-brand {
                margin-right: 0;
            }
            
            .navbar-brand img {
                height: 45px; /* Slightly smaller on mobile */
            }
            
            .nav-link {
                padding: 0.8rem 1rem !important;
                margin: 0.2rem 0;
            }
            
            .nav-link::after {
                display: none;
            }
            
            .dropdown-menu {
                box-shadow: none;
                border: 1px solid rgba(0, 0, 0, 0.05);
                margin-top: 0;
            }
            
            .btn-login, .btn-agent {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/" data-aos="fade-right">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="img-fluid">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent" data-aos="fade-left">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/report_issue.php">Report Issue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                                </div>
                                <span class="d-none d-lg-inline"><?php echo $user_name; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if ($_SESSION['role'] === 'user'): ?>
                                    <li><h6 class="dropdown-header">User Menu</h6></li>
                                    <li><a class="dropdown-item" href="/views/user_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/views/report_issue.php"><i class="fas fa-plus-circle me-2"></i>Report Issue</a></li>
                                    <li><a class="dropdown-item" href="/views/reported_issues.php"><i class="fas fa-tasks me-2"></i>Your Issues</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                <?php elseif ($_SESSION['role'] === 'agent'): ?>
                                    <li><h6 class="dropdown-header">Agent Menu</h6></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php#issues"><i class="fas fa-clipboard-list me-2"></i>Assigned Issues</a></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php#history"><i class="fas fa-history me-2"></i>History</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                                    <li><h6 class="dropdown-header">Admin Menu</h6></li>
                                    <li><a class="dropdown-item" href="/views/admin_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/views/admin_dashboard.php#agents"><i class="fas fa-users-cog me-2"></i>Manage Agents</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/views/login.php" class="btn btn-login me-2">
                            <i class="fas fa-user me-1"></i> User Login
                        </a>
                        <a href="/views/agent_login.php" class="btn btn-agent">
                            <i class="fas fa-headset me-1"></i> Agent Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Add shadow to navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
            }
        });
    </script>
</body>
</html>