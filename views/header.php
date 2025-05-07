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



<style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --secondary: #3f37c9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --danger: #ef4444;
            --success: #10b981;
        }

        /* Header Styles */
        .navbar {
            padding: 0;
            background: white !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            font-family: 'Poppins', sans-serif;
            position: relative;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 95%;
            margin: 0 auto;
            padding: 0 2rem;
            width: 100%;
        }

        .navbar-brand img {
            height: 65px;
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            padding: 1rem 1.2rem !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1.2rem;
            right: 1.2rem;
            height: 3px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover:before,
        .nav-link.active:before {
            transform: scaleX(1);
        }

        .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem !important;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem !important;
            border-radius: 8px;
            margin: 0.2rem 0.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary) !important;
        }

        .dropdown-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray) !important;
            padding: 0.5rem 1.5rem !important;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white !important;
            border-radius: 8px;
            padding: 0.7rem 1.5rem !important;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }

        .btn-agent {
            background: white;
            color: var(--primary) !important;
            border-radius: 8px;
            padding: 0.7rem 1.5rem !important;
            font-weight: 500;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }

        .btn-agent:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        /* Mobile Styles */
        @media (max-width: 991.98px) {
            .navbar-container {
                padding: 0 1rem;
            }
            
            .navbar-brand img {
                height: 40px;
            }
            
            .navbar-collapse {
                position: fixed;
                top: 0;
                right: 0;
                width: 280px;
                height: 100vh;
                background: white;
                padding: 4rem 1.5rem 2rem;
                z-index: 1050;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
            }
            
            .navbar-collapse.show {
                transform: translateX(0);
            }
            
            .navbar-nav {
                margin-top: 1rem;
                gap: 0.5rem;
            }
            
            .mobile-close-btn {
                position: absolute;
                top: 1.5rem;
                right: 1.5rem;
                font-size: 1.5rem;
                background: none;
                border: none;
                color: var(--gray);
                z-index: 1051;
            }
            
            .btn-login, .btn-agent {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }
            
            .dropdown-menu {
                box-shadow: none;
                border: 1px solid rgba(0, 0, 0, 0.05);
                margin-left: 1rem !important;
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
            }
            
            .nav-link:before {
                left: 1rem;
                right: auto;
                width: 3px;
                height: 60%;
                top: 20%;
                transform: scaleY(0);
            }
            
            .nav-link:hover:before,
            .nav-link.active:before {
                transform: scaleY(1);
            }
        }

        /* Mobile Toggle Button */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            font-size: 1.5rem;
            color: var(--dark);
            position: relative;
            z-index: 1;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* New Book Slot Button */
        .btn-book {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            border-radius: 8px;
            padding: 0.7rem 1.5rem !important;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            margin-left: 1rem;
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid navbar-container">
            <a class="navbar-brand" href="/">
                <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="img-fluid">
            </a>
            
            <button class="navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="navbar-collapse" id="navbarContent">
                <button class="mobile-close-btn d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') === false) ? 'active' : ''; ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'report_issue.php') ? 'active' : ''; ?>" href="/views/report_issue.php">Report Issue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>" href="/views/pricing.php">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="/views/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="/views/faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/views/contact.php">Contact</a>
                    </li>
                 

                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($current_page, 'blog') !== false || $current_page == 'post.php' || ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') !== false)) ? 'active' : ''; ?>" href="/blog/index.php">Blog</a>
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
                                    <li><a class="dropdown-item" href="/views/book_slot.php"><i class="fas fa-calendar-check me-2"></i>Book Slot</a></li>
                                    <li><a class="dropdown-item" href="/views/reported_issues.php"><i class="fas fa-tasks me-2"></i>Your Issues</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                <?php elseif ($_SESSION['role'] === 'agent'): ?>
                                    <li><h6 class="dropdown-header">Agent Menu</h6></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php#issues"><i class="fas fa-clipboard-list me-2"></i>Assigned Issues</a></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php#bookings"><i class="fas fa-calendar-day me-2"></i>Booked Slots</a></li>
                                    <li><a class="dropdown-item" href="/views/agent_dashboard.php#history"><i class="fas fa-history me-2"></i>History</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                                    <li><h6 class="dropdown-header">Admin Menu</h6></li>
                                    <li><a class="dropdown-item" href="/admin/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/admin/dashboard.php#agents"><i class="fas fa-users-cog me-2"></i>Manage Agents</a></li>
                                    <li><a class="dropdown-item" href="/admin/admin_bookings.php"><i class="fas fa-calendar-alt me-2"></i>Manage Bookings</a></li>
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
                        <a href="/views/book_slot.php" class="btn btn-book d-none d-lg-inline-block ms-2">
                            <i class="fas fa-calendar-check me-1"></i> Book Slot
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const mobileCloseBtn = document.querySelector('.mobile-close-btn');
            
            // Toggle mobile menu
            navbarToggler.addEventListener('click', function() {
                navbarCollapse.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
            
            // Close mobile menu
            mobileCloseBtn.addEventListener('click', function() {
                navbarCollapse.classList.remove('show');
                document.body.style.overflow = '';
            });
            
            // Close menu when clicking on nav links (for single page applications)
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarCollapse.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });
        });
    </script>