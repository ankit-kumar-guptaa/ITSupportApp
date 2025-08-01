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
        --ocean-blue: #4361ee;
        --deep-purple: #7209b7;
        --vibrant-pink: #f72585;
        --fresh-mint: #4cc9f0;
        --dark-space: #1a1a2e;
        --cosmic-gray: #16213e;
        --pure-white: #ffffff;
        --soft-gray: #e5e5e5;
        --alert-red: #f44336;
        --success-green: #4caf50;
        --electric-blue: #4895ef;
        --neon-purple: #b5179e;
    }

    /* Header Styles */
    .navbar {
        padding: 1rem 0;
        background: var(--pure-white) !important;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        font-family: 'Poppins', sans-serif;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .navbar.scrolled {
        padding: 0.7rem 0;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px);
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Logo Styles */
    .navbar-brand {
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        z-index: 1001;
    }

    .navbar-brand:hover {
        transform: translateY(-2px);
    }

    .navbar-brand img {
        height: 60px;
        transition: all 0.3s ease;
    }
    
    .navbar.scrolled .navbar-brand img {
        height: 50px;
    }

    /* Navigation Center */
    .navbar-center {
        display: flex;
        flex-grow: 1;
        justify-content: center;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 0.2rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        font-weight: 500;
        color: var(--dark-space) !important;
        padding: 0.8rem 1.2rem !important;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 0.95rem;
        border-radius: 12px;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1.2rem;
        right: 1.2rem;
        height: 2px;
        background: linear-gradient(90deg, var(--ocean-blue), var(--neon-purple));
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.3s ease;
    }

    .nav-link:hover::before,
    .nav-link.active::before {
        transform: scaleX(1);
    }

    .nav-link:hover {
        color: var(--ocean-blue) !important;
    }

    .nav-link.active {
        color: var(--ocean-blue) !important;
        font-weight: 600;
    }

    /* Right side buttons */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* User Dropdown */
    .user-dropdown {
        position: relative;
    }

    .user-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--ocean-blue), var(--deep-purple));
        color: white !important;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        cursor: pointer;
        border: none;
    }

    .user-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: white;
        color: var(--ocean-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 120%;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0;
        min-width: 220px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        padding: 0.7rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        color: var(--dark-space);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: var(--soft-gray);
        color: var(--ocean-blue);
        padding-left: 1.7rem;
    }

    .dropdown-item i {
        width: 20px;
        color: var(--ocean-blue);
    }

    .dropdown-divider {
        border-top: 1px solid var(--soft-gray);
        margin: 0.5rem 0;
    }

    /* Mobile Dropdown Menu */
    .mobile-dropdown-menu {
        display: none;
        width: 100%;
        background: var(--soft-gray);
        border-radius: 12px;
        margin-top: 0.5rem;
        padding: 0.5rem 0;
    }

    .mobile-dropdown-menu.show {
        display: block;
    }

    /* Button Styles */
    .btn {
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .btn-login {
        background: linear-gradient(135deg, var(--ocean-blue), var(--electric-blue));
        color: white !important;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
    }

    .btn-agent {
        background: white;
        color: var(--ocean-blue) !important;
        border: 2px solid var(--ocean-blue);
    }

    .btn-agent:hover {
        background: var(--soft-gray);
    }

    /* Mobile Toggle Button */
    .navbar-toggler {
        border: none;
        background: linear-gradient(135deg, var(--ocean-blue), var(--electric-blue));
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        z-index: 1001;
    }
    
    .navbar-toggler:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
    }

    /* Mobile Menu */
    .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    
    .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .mobile-close-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: var(--alert-red);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1001;
        border: none;
    }
    
    .mobile-close-btn:hover {
        transform: rotate(90deg);
    }

    /* Mobile User Button */
    .mobile-user-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ocean-blue), var(--deep-purple));
        color: white;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        z-index: 1001;
        border: none;
        cursor: pointer;
    }
    
    .mobile-user-btn:hover {
        transform: scale(1.05);
    }
    
    .mobile-user-avatar {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    /* Mobile Login Button */
    .mobile-login-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ocean-blue), var(--electric-blue));
        color: white;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        z-index: 1001;
        text-decoration: none;
    }
    
    .mobile-login-btn i {
        font-size: 1.2rem;
    }
    
    .mobile-login-btn:hover {
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (min-width: 992px) {
        .navbar-collapse {
            display: flex !important;
            flex-basis: auto;
            flex-grow: 1;
            align-items: center;
            justify-content: space-between;
        }
        
        .mobile-user-btn,
        .mobile-login-btn,
        .navbar-toggler {
            display: none !important;
        }
    }

    @media (max-width: 991.98px) {
        body {
            padding-top: 80px;
        }

        .navbar-container {
            padding: 0 1.5rem;
        }
        
        .navbar-brand img {
            height: 50px;
        }
        
        .navbar-center,
        .navbar-right {
            display: none !important;
        }
        
        /* Show mobile buttons */
        <?php if (isset($_SESSION['user_id'])): ?>
        .mobile-user-btn {
            display: flex !important;
        }
        <?php else: ?>
        .mobile-login-btn {
            display: flex !important;
        }
        <?php endif; ?>
        
        .navbar-toggler {
            display: flex;
        }
        
        .navbar-collapse {
            position: fixed;
            top: 0;
            right: 0;
            width: 320px;
            height: 100vh;
            background: white;
            padding: 2rem;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        
        .navbar-collapse.show {
            transform: translateX(0);
        }
        
        .navbar-nav {
            flex-direction: column;
            width: 100%;
            margin: 2rem 0;
            gap: 0.5rem;
        }
        
        .nav-item {
            width: 100%;
        }
        
        .nav-link {
            padding: 1rem 1.5rem !important;
            border-radius: 12px;
        }
        
        .nav-link:hover {
            background: var(--soft-gray);
        }
        
        .nav-link::before {
            display: none;
        }
        
        .mobile-auth-buttons {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 1rem;
            margin-top: auto;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
            padding: 1rem !important;
            border-radius: 12px !important;
        }
        
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--soft-gray);
            margin-bottom: 1rem;
        }
        
        .mobile-menu-title {
            font-weight: 700;
            color: var(--dark-space);
            font-size: 1.3rem;
            background: linear-gradient(90deg, var(--ocean-blue), var(--neon-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .mobile-menu-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--soft-gray);
        }
        
        .mobile-menu-contact {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--dark-space);
            text-decoration: none;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-contact:hover {
            background: var(--soft-gray);
            color: var(--ocean-blue);
        }
        
        .mobile-menu-social {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }
        
        .social-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--soft-gray);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: var(--ocean-blue);
            color: white;
            transform: translateY(-3px);
        }
    }

    @media (max-width: 767.98px) {
        .navbar-brand img {
            height: 46px;
        }
        
        .navbar-collapse {
            width: 100%;
        }
    }

    /* Add body padding to prevent content hiding under fixed navbar */
    body {
        padding-top: 80px;
    }
</style>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay"></div>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="navbar-container">
        <!-- Logo on left - larger on mobile -->
        <a class="navbar-brand" href="/">
            <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="img-fluid">
        </a>
        
        <!-- Navigation in center (Desktop only) -->
        <div class="navbar-center d-none d-lg-flex">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') === false) ? 'active' : ''; ?>" href="/">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'report_issue.php') ? 'active' : ''; ?>" href="/views/report_issue.php">
                        Report Issue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>" href="/views/pricing.php">
                        Pricing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="/views/about.php">
                        About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="/views/faq.php">
                        FAQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/views/contact.php">
                        Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'blog') !== false || $current_page == 'post.php' || ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') !== false)) ? 'active' : ''; ?>" href="/blog/index.php">
                        Blog
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Right side buttons (Desktop only) -->
        <div class="navbar-right d-none d-lg-flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                        </div>
                        <span><?php echo explode(' ', $user_name)[0]; ?></span>
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                    <div class="dropdown-menu" id="userDropdownMenu">
                        <?php if ($_SESSION['role'] === 'user'): ?>
                            <a class="dropdown-item" href="/views/user_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <a class="dropdown-item" href="/views/report_issue.php"><i class="fas fa-plus-circle"></i>Report Issue</a>
                            <a class="dropdown-item" href="/views/book_slot.php"><i class="fas fa-calendar-check"></i>Book Slot</a>
                            <a class="dropdown-item" href="/views/reported_issues.php"><i class="fas fa-tasks"></i>Your Issues</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        <?php elseif ($_SESSION['role'] === 'agent'): ?>
                            <a class="dropdown-item" href="/views/agent_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <a class="dropdown-item" href="/views/agent_dashboard.php#issues"><i class="fas fa-clipboard-list"></i>Assigned Issues</a>
                            <a class="dropdown-item" href="/views/agent_dashboard.php#bookings"><i class="fas fa-calendar-day"></i>Booked Slots</a>
                            <a class="dropdown-item" href="/views/agent_dashboard.php#history"><i class="fas fa-history"></i>History</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        <?php elseif ($_SESSION['role'] === 'admin'): ?>
                            <a class="dropdown-item" href="/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <a class="dropdown-item" href="/admin/dashboard.php#agents"><i class="fas fa-users-cog"></i>Manage Agents</a>
                            <a class="dropdown-item" href="/admin/admin_bookings.php"><i class="fas fa-calendar-alt"></i>Manage Bookings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/views/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="/views/login.php" class="btn btn-login">
                    <i class="fas fa-user"></i> Login
                </a>
                <a href="/views/agent_login.php" class="btn btn-agent">
                    <i class="fas fa-headset"></i> Agent
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Mobile User Button or Login Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="mobile-user-btn" id="mobileUserBtn">
                <div class="mobile-user-avatar">
                    <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                </div>
            </button>
        <?php else: ?>
            <a href="/views/login.php" class="mobile-login-btn">
                <i class="fas fa-user"></i>
            </a>
        <?php endif; ?>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" id="navbarToggler">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Mobile Menu -->
        <div class="navbar-collapse" id="navbarContent">
            <div class="mobile-menu-header d-lg-none">
                <!-- <div class="mobile-menu-title">IT Sahayta</div> -->
                <button class="mobile-close-btn" id="mobileCloseBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <ul class="navbar-nav d-lg-none">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') === false) ? 'active' : ''; ?>" href="/">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'report_issue.php') ? 'active' : ''; ?>" href="/views/report_issue.php">
                        <i class="fas fa-exclamation-circle me-2"></i>Report Issue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>" href="/views/pricing.php">
                        <i class="fas fa-tags me-2"></i>Pricing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="/views/about.php">
                        <i class="fas fa-info-circle me-2"></i>About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="/views/faq.php">
                        <i class="fas fa-question-circle me-2"></i>FAQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/views/contact.php">
                        <i class="fas fa-envelope me-2"></i>Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'blog') !== false || $current_page == 'post.php' || ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') !== false)) ? 'active' : ''; ?>" href="/blog/index.php">
                        <i class="fas fa-blog me-2"></i>Blog
                    </a>
                </li>
            </ul>
            
            <div class="mobile-auth-buttons d-lg-none">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="w-100">
                        <button class="btn btn-login w-100 mb-2" id="mobileDropdownToggle">
                            <i class="fas fa-user-circle me-2"></i> My Account
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <div class="mobile-dropdown-menu" id="mobileDropdownMenu">
                            <a href="/views/user_dashboard.php" class="dropdown-item">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                            <a href="/views/report_issue.php" class="dropdown-item">
                                <i class="fas fa-plus-circle me-2"></i> Report Issue
                            </a>
                            <a href="/views/book_slot.php" class="dropdown-item">
                                <i class="fas fa-calendar-check me-2"></i> Book Slot
                            </a>
                            <a href="/views/reported_issues.php" class="dropdown-item">
                                <i class="fas fa-tasks me-2"></i> Your Issues
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/views/logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/views/agent_login.php" class="btn btn-agent">
                        <i class="fas fa-headset"></i> Agent Login
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="mobile-menu-footer d-lg-none">
                <a href="tel:+918005678900" class="mobile-menu-contact">
                    <i class="fas fa-phone-alt"></i> +91 800 567 8900
                </a>
                <a href="mailto:support@itsahayta.com" class="mobile-menu-contact">
                    <i class="fas fa-envelope"></i> support@itsahayta.com
                </a>
                <div class="mobile-menu-social">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript for Dropdown and Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu elements
        const navbarToggler = document.getElementById('navbarToggler');
        const navbarCollapse = document.getElementById('navbarContent');
        const mobileCloseBtn = document.getElementById('mobileCloseBtn');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const navbar = document.querySelector('.navbar');
        const mobileUserBtn = document.getElementById('mobileUserBtn');
        
        // User dropdown elements
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        // Mobile dropdown elements
        const mobileDropdownToggle = document.getElementById('mobileDropdownToggle');
        const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
        
        // Toggle mobile menu
        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.add('show');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu
        function closeMenu() {
            navbarCollapse.classList.remove('show');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        mobileCloseBtn.addEventListener('click', closeMenu);
        mobileMenuOverlay.addEventListener('click', closeMenu);
        
        // Mobile user button click - show mobile menu
        if(mobileUserBtn) {
            mobileUserBtn.addEventListener('click', function(e) {
                e.preventDefault();
                navbarCollapse.classList.add('show');
                mobileMenuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }
        
        // User dropdown toggle (desktop)
        if(userDropdownBtn && userDropdownMenu) {
            userDropdownBtn.addEventListener('click', function(e) {
                e.preventDefault();
                userDropdownMenu.classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userDropdownBtn.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.remove('show');
                }
            });
        }
        
        // Mobile dropdown toggle
        if(mobileDropdownToggle && mobileDropdownMenu) {
            mobileDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileDropdownMenu.classList.toggle('show');
            });
        }
        
        // Close menu when clicking on nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    closeMenu();
                }
            });
        });
        
        // Scroll effect for navbar
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>