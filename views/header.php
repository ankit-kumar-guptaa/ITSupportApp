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

// Get current page for active nav indication
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta</title>
    <link rel="stylesheet" href="../assets/css/user_dashboard.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <style>
        /* Header Styles Only */
        .navbar-brand img {
            height: 70px;
            transition: all 0.3s ease;
        }
        
        .navbar {
            padding: 0.5rem 3rem;
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .navbar-nav {
            gap: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            position: relative;
        }
        
        .nav-link.active {
            color: #4e73df !important;
            font-weight: 600;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #4e73df;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .btn-login {
            background: #4e73df;
            color: white !important;
            border-radius: 50px;
            padding: 0.7rem 1.8rem !important;
            font-weight: 500;
        }
        
        .btn-agent {
            background: #f8f9fc;
            color: #4e73df !important;
            border-radius: 50px;
            padding: 0.7rem 1.8rem !important;
            font-weight: 500;
            border: 1px solid #4e73df;
        }
        
        /* Mobile Styles */
        @media (max-width: 991.98px) {
            .navbar {
                padding: 0.8rem 1.5rem;
                position: relative;
            }
            
            .navbar-brand img {
                height: 55px;
            }
            
            .navbar-collapse {
                position: fixed;
                top: 0;
                right: 0;
                width: 280px;
                height: 100vh;
                background: white;
                padding: 2rem 1.5rem;
                z-index: 1050;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            }
            
            .navbar-collapse.show {
                transform: translateX(0);
            }
            
            .navbar-nav {
                margin-top: 2rem;
                gap: 0.5rem;
            }
            
            .mobile-close-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                font-size: 1.5rem;
                background: none;
                border: none;
                color: #6c757d;
            }
            
            .btn-login, .btn-agent {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
            }
            
            .dropdown-menu {
                box-shadow: none;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="img-fluid">
            </a>
            
            <button class="navbar-toggler" type="button" aria-controls="navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-collapse" id="navbarContent">
                <button class="mobile-close-btn d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'report_issue.php') ? 'active' : ''; ?>" href="/views/report_issue.php">Report Issue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="/faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                                </div>
                                <span class="d-none d-lg-inline"><?php echo $user_name; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
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

  
