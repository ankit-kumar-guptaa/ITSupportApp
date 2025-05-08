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
        padding: 0.5rem 0;
        background: white !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        font-family: 'Poppins', sans-serif;
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
        will-change: transform; /* स्क्रॉल पर हिलने को रोकने के लिए */
        transform: translateZ(0); /* हार्डवेयर एक्सेलेरेशन के लिए */
        backface-visibility: hidden; /* और स्मूथनेस के लिए */
    }
    
    .navbar.scrolled {
        padding: 0.3rem 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .navbar-container {
        width: 100%;
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        height: 70px;
        transition: all 0.3s ease;
    }
    
    .navbar.scrolled .navbar-brand img {
        height: 50px;
    }

    /* नेविगेशन सेंटर में रखने के लिए */
    .navbar-center {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 1;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-item {
        position: relative;
        white-space: nowrap;
    }

    .nav-link {
        font-weight: 500;
        color: var(--dark) !important;
        padding: 0.7rem 0.8rem !important;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 1rem;
    }

    .nav-link:before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0.8rem;
        right: 0.8rem;
        height: 3px;
        background: var(--primary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        border-radius: 3px;
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
        min-width: 220px;
        animation: fadeIn 0.3s ease;
        display: none;
        position: absolute;
        background-color: white;
        z-index: 1001;
    }
    
    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        padding: 0.6rem 1.5rem !important;
        border-radius: 8px;
        margin: 0.2rem 0.5rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: var(--dark);
    }

    .dropdown-item:hover {
        background: var(--primary-light);
        color: var(--primary) !important;
        transform: translateX(3px);
    }

    .dropdown-header {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--gray) !important;
        padding: 0.5rem 1.5rem !important;
        font-weight: 600;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
    }
    
    .user-avatar:hover {
        transform: scale(1.05);
    }

    .auth-buttons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-login {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white !important;
        border-radius: 8px;
        padding: 0.6rem 1.2rem !important;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
    }

    .btn-agent {
        background: white;
        color: var(--primary) !important;
        border-radius: 8px;
        padding: 0.6rem 1.2rem !important;
        font-weight: 500;
        border: 1.5px solid var(--primary);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-agent:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
    }

    /* Book Slot Button */
    .btn-book {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white !important;
        border-radius: 8px;
        padding: 0.6rem 1.2rem !important;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    /* Mobile Toggle Button */
    .navbar-toggler {
        border: none;
        background: var(--primary-light);
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: none;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: auto;
        z-index: 998; /* मोबाइल मेनू से कम z-index */
    }
    
    .navbar-toggler:hover {
        background: rgba(67, 97, 238, 0.15);
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
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
        backdrop-filter: blur(3px);
    }
    
    .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .navbar-collapse {
        position: fixed;
        top: 0;
        right: -100%; /* शुरू में स्क्रीन के बाहर */
        width: 280px;
        height: 100vh;
        background: white;
        padding: 1.5rem;
        z-index: 1000;
        transition: right 0.4s ease; /* translateX के बजाय right प्रॉपर्टी का उपयोग */
        box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }
    
    .navbar-collapse.show {
        right: 0; /* दिखाने के लिए स्क्रीन पर लाएं */
    }

    .mobile-close-btn {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        background: var(--primary-light);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1001;
    }
    
    .mobile-close-btn:hover {
        background: rgba(67, 97, 238, 0.2);
        transform: rotate(90deg);
    }

    /* ड्रॉपडाउन टॉगल के लिए स्टाइल */
    .dropdown-toggle {
        cursor: pointer;
    }
    
    .dropdown-toggle::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Styles */
    @media (min-width: 992px) {
        .navbar-collapse {
            position: static;
            display: flex !important;
            flex-basis: auto;
            flex-grow: 1;
            align-items: center;
            justify-content: space-between;
            height: auto;
            width: auto;
            background: transparent;
            box-shadow: none;
            padding: 0;
            overflow: visible;
            right: 0;
        }
        
        .navbar-nav {
            flex-direction: row;
        }
        
        .mobile-menu-header,
        .mobile-menu-footer {
            display: none;
        }
    }

    @media (max-width: 991.98px) {
        .navbar-container {
            padding: 0 1rem;
            position: relative;
        }
        
        .navbar-brand img {
            height: 45px;
        }
        
        .navbar-toggler {
            display: flex;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .navbar-nav {
            flex-direction: column;
            width: 100%;
            margin: 1.5rem 0;
            gap: 0.3rem;
        }
        
        .nav-item {
            width: 100%;
        }
        
        .nav-link {
            padding: 0.8rem 1rem !important;
            width: 100%;
            border-radius: 8px;
        }
        
        .nav-link:hover {
            background: var(--primary-light);
        }
        
        .nav-link:before {
            display: none;
        }
        
        .nav-link.active {
            background: var(--primary-light);
        }
        
        .dropdown-menu {
            position: static !important;
            float: none;
            width: 100%;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-left: 1rem !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
            transform: none !important;
        }
        
        .auth-buttons {
            flex-direction: column;
            width: 100%;
            gap: 0.75rem;
            margin-top: auto;
        }
        
        .btn-login, 
        .btn-agent,
        .btn-book {
            width: 100%;
            justify-content: center;
        }
        
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }
        
        .mobile-menu-title {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
        }
        
        .mobile-menu-footer {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .mobile-menu-contact {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark);
            text-decoration: none;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }
        
        .mobile-menu-social {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
    }

    @media (max-width: 767.98px) {
        .navbar-brand img {
            height: 40px;
        }
        
        .navbar-collapse {
            width: 260px;
        }
    }

    @media (max-width: 575.98px) {
        .navbar-container {
            padding: 0 0.75rem;
        }
        
        .navbar-brand img {
            height: 38px;
        }
        
        .navbar-collapse {
            width: 100%;
        }
    }

    /* मोबाइल मेनू खुलने पर टॉगलर बटन छिपाने के लिए */
    .mobile-menu-overlay.active ~ .navbar-container .navbar-toggler {
        display: none;
    }
</style>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay"></div>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="navbar-container">
        <!-- लोगो शुरू में -->
        <a class="navbar-brand" href="/">
            <img src="/assets/logo.svg" alt="IT Sahayta Logo" class="img-fluid">
        </a>
        
        <!-- नेविगेशन सेंटर में -->
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
        
        <!-- बटन्स एंड में -->
        <div class="auth-buttons d-none d-lg-flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button">
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
                <a href="/views/login.php" class="btn btn-login">
                    <i class="fas fa-user"></i> User Login
                </a>
                <a href="/views/agent_login.php" class="btn btn-agent">
                    <i class="fas fa-headset"></i> Agent Login
                </a>
                <a href="/views/book_slot.php" class="btn btn-book">
                    <i class="fas fa-calendar-check"></i> Book Slot
                </a>
            <?php endif; ?>
        </div>
        
        <!-- मोबाइल टॉगल बटन -->
        <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- मोबाइल मेन्यू -->
        <div class="navbar-collapse" id="navbarContent">
            <div class="mobile-menu-header d-lg-none">
                <div class="mobile-menu-title">IT Sahayata</div>
                <button class="mobile-close-btn" aria-label="Close menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <ul class="navbar-nav d-lg-none">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') === false) ? 'active' : ''; ?>" href="/">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'report_issue.php') ? 'active' : ''; ?>" href="/views/report_issue.php">
                        <i class="fas fa-plus-circle me-2"></i> Report Issue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>" href="/views/pricing.php">
                        <i class="fas fa-tags me-2"></i> Pricing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="/views/about.php">
                        <i class="fas fa-info-circle me-2"></i> About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="/views/faq.php">
                        <i class="fas fa-question-circle me-2"></i> FAQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/views/contact.php">
                        <i class="fas fa-envelope me-2"></i> Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'blog') !== false || $current_page == 'post.php' || ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/blog/') !== false)) ? 'active' : ''; ?>" href="/blog/index.php">
                        <i class="fas fa-blog me-2"></i> Blog
                    </a>
                </li>
            </ul>
            
            <div class="mobile-menu-footer d-lg-none">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                        </div>
                        <div class="ms-2">
                            <div class="fw-bold"><?php echo $user_name; ?></div>
                            <div class="text-muted small"><?php echo ucfirst($_SESSION['role']); ?></div>
                        </div>
                    </div>
                    
                    <?php if ($_SESSION['role'] === 'user'): ?>
                        <a href="/views/user_dashboard.php" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="/views/logout.php" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    <?php elseif ($_SESSION['role'] === 'agent'): ?>
                        <a href="/views/agent_dashboard.php" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="/views/logout.php" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    <?php elseif ($_SESSION['role'] === 'admin'): ?>
                        <a href="/admin/dashboard.php" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="/views/logout.php" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/views/login.php" class="btn btn-login w-100 mb-2">
                        <i class="fas fa-user me-2"></i> User Login
                    </a>
                    <a href="/views/agent_login.php" class="btn btn-agent w-100 mb-2">
                        <i class="fas fa-headset me-2"></i> Agent Login
                    </a>
                    <a href="/views/book_slot.php" class="btn btn-book w-100">
                        <i class="fas fa-calendar-check me-2"></i> Book Slot
                    </a>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="tel:+917703823008" class="mobile-menu-contact">
                        <i class="fas fa-phone-alt me-2"></i> +91-7703823008
                    </a>
                    <a href="mailto:support@itsahayta.com" class="mobile-menu-contact">
                        <i class="fas fa-envelope me-2"></i> support@itsahayata.com
                    </a>
                </div>
                
                <div class="mobile-menu-social">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ड्रॉपडाउन टॉगल के लिए
    const dropdownToggle = document.querySelectorAll('.dropdown-toggle');
    dropdownToggle.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const dropdownMenu = parent.querySelector('.dropdown-menu');
            
            // अन्य सभी ड्रॉपडाउन को बंद करें
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('show');
                }
            });
            
            // टॉगल करें
            dropdownMenu.classList.toggle('show');
        });
    });
    
    // बाहर क्लिक करने पर ड्रॉपडाउन बंद करें
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    
    // मोबाइल मेनू के लिए
    const navbarToggler = document.querySelector('.navbar-toggler');
    const mobileCloseBtn = document.querySelector('.mobile-close-btn');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.add('show');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            navbarToggler.style.display = 'none'; // टॉगलर को छिपाएं
        });
    }
    
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', function() {
            closeMenu();
        });
    }
    
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', function() {
            closeMenu();
        });
    }
    
    // मेनू बंद करने का फंक्शन
    function closeMenu() {
        navbarCollapse.classList.remove('show');
        mobileMenuOverlay.classList.remove('active');
        document.body.style.overflow = '';
        
        // थोड़ी देर बाद टॉगलर को वापस दिखाएं
        setTimeout(function() {
            navbarToggler.style.display = 'flex';
        }, 300);
    }
    
    // स्क्रॉल पर नेवबार का स्टाइल बदलें
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 10) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
});
</script>
                    