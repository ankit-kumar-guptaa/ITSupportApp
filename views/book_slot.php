<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php?error=Please login to book a slot");
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/email.php';

// Fetch user name if logged in
$userName = '';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $userName = $user ? htmlspecialchars($user['name']) : 'User';
}

$userEmail = $_SESSION['email'] ?? '';
$userPhone = $_SESSION['phone_number'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking'])) {
    $serviceType = $_POST['service_type'] ?? '';
    $serviceName = $_POST['service_name'] ?? '';
    $bookingDate = $_POST['booking_date'] ?? '';
    $bookingTime = $_POST['booking_time'] ?? '';
    $problemDesc = $_POST['problem_description'] ?? '';
    $contactNumber = $_POST['contact_number'] ?? '';
    $specialNotes = $_POST['special_notes'] ?? '';
    $customerName = $_POST['customer_name'] ?? $userName;
    $customerEmail = $_POST['customer_email'] ?? $userEmail;
    
    // Validate required fields
    $errors = [];
    if (empty($serviceType)) $errors[] = "Service type is required";
    if (empty($serviceName)) $errors[] = "Service name is required";
    if (empty($bookingDate)) $errors[] = "Booking date is required";
    if (empty($bookingTime)) $errors[] = "Booking time is required";
    if (empty($problemDesc)) $errors[] = "Problem description is required";
    if (empty($contactNumber)) $errors[] = "Contact number is required";
    if (empty($customerName)) $errors[] = "Your name is required";
    if (empty($customerEmail)) $errors[] = "Email address is required";
    
    if (empty($errors)) {
        // Generate booking ID
        $bookingId = 'IT-' . strtoupper(uniqid());
        
        try {
            // Save to database
            $stmt = $pdo->prepare("INSERT INTO bookings 
                (booking_id, user_id, service_type, service_name, problem_description, 
                booking_date, booking_time, contact_number, special_notes, customer_name, customer_email, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'confirmed')");
            
            $stmt->execute([
                $bookingId,
                $_SESSION['user_id'],
                $serviceType,
                $serviceName,
                $problemDesc,
                $bookingDate,
                $bookingTime,
                $contactNumber,
                $specialNotes,
                $customerName,
                $customerEmail
            ]);
            
            // Prepare user confirmation email
            $userEmailSubject = "Your IT Service Booking Confirmation #$bookingId";
            
            $userEmailBody = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #4361ee; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { padding: 20px; background: #fff; border-radius: 0 0 8px 8px; }
                        .details { margin: 20px 0; }
                        .detail-row { display: flex; margin-bottom: 10px; }
                        .detail-label { font-weight: bold; width: 150px; }
                        .footer { margin-top: 20px; font-size: 0.9em; color: #666; text-align: center; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>IT Service Booking Confirmation</h2>
                        </div>
                        <div class='content'>
                            <p>Hello $customerName,</p>
                            <p>Your IT service booking has been confirmed. Here are your booking details:</p>
                            
                            <div class='details'>
                                <div class='detail-row'>
                                    <div class='detail-label'>Booking ID:</div>
                                    <div>$bookingId</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Service:</div>
                                    <div>$serviceName</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Date:</div>
                                    <div>$bookingDate</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Time Slot:</div>
                                    <div>$bookingTime</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Contact Number:</div>
                                    <div>$contactNumber</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Special Notes:</div>
                                    <div>".($specialNotes ?: 'None')."</div>
                                </div>
                            </div>
                            
                            <p>Our technician will contact you before the scheduled time.</p>
                            
                            <div class='footer'>
                                <p>Thank you for choosing our IT services!</p>
                                <p><strong>IT Support Team</strong></p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ";
            
            // Prepare admin notification email
            $adminEmailSubject = "New Booking Notification #$bookingId";
            
            $adminEmailBody = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #4361ee; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { padding: 20px; background: #fff; border-radius: 0 0 8px 8px; }
                        .details { margin: 20px 0; }
                        .detail-row { display: flex; margin-bottom: 10px; }
                        .detail-label { font-weight: bold; width: 150px; }
                        .footer { margin-top: 20px; font-size: 0.9em; color: #666; text-align: center; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>New Booking Notification</h2>
                        </div>
                        <div class='content'>
                            <p>A new booking has been created on your website. Here are the details:</p>
                            
                            <div class='details'>
                                <div class='detail-row'>
                                    <div class='detail-label'>Booking ID:</div>
                                    <div>$bookingId</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Customer Name:</div>
                                    <div>$customerName</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Customer Email:</div>
                                    <div>$customerEmail</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Service:</div>
                                    <div>$serviceName</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Date:</div>
                                    <div>$bookingDate</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Time Slot:</div>
                                    <div>$bookingTime</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Contact Number:</div>
                                    <div>$contactNumber</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Problem Description:</div>
                                    <div>$problemDesc</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Special Notes:</div>
                                    <div>".($specialNotes ?: 'None')."</div>
                                </div>
                            </div>
                            
                            <div class='footer'>
                                <p>Please contact the customer to confirm the appointment.</p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ";
            
            // Send confirmation email to customer
            sendEmail($customerEmail, $userEmailSubject, $userEmailBody);
            
            // Send notification to admin
            sendEmail('gauravmishra92812@gmail.com', $adminEmailSubject, $adminEmailBody);
            
            // Set success session
            $_SESSION['booking_success'] = true;
            $_SESSION['booking_id'] = $bookingId;
            
            // Redirect to prevent form resubmission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
            
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = implode("<br>", $errors);
    }
}

// Check for success redirect
$showSuccess = false;
if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']) {
    $showSuccess = true;
    unset($_SESSION['booking_success']);
    
    // Get booking details for success page
    $bookingId = $_SESSION['booking_id'];
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE booking_id = ?");
    $stmt->execute([$bookingId]);
    $bookingDetails = $stmt->fetch();
    unset($_SESSION['booking_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book IT Service Slot | IT Sahayta</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr for date/time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --rounded-sm: 0.125rem;
            --rounded: 0.25rem;
            --rounded-md: 0.375rem;
            --rounded-lg: 0.5rem;
            --rounded-xl: 0.75rem;
            --rounded-2xl: 1rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1rem 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s;
        }

        .header-links a:hover {
            opacity: 0.9;
        }

        .user-greeting {
            color: white;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        /* Hero Section */
        .booking-hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .booking-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
            opacity: 0.3;
        }

        .booking-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .booking-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
        }

        /* Main Booking Card */
        .booking-card {
            background: white;
            border-radius: var(--rounded-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin-top: -3rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .booking-header {
            padding: 2rem;
            border-bottom: 1px solid var(--gray-light);
            text-align: center;
        }

        .booking-header h2 {
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .booking-header p {
            color: var(--gray);
            font-size: 1rem;
        }

        /* Booking Steps */
        .booking-steps {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-light);
            background: var(--light);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
            max-width: 200px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .step.completed .step-number {
            background: var(--success);
            color: white;
        }

        .step-title {
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            color: var(--gray);
            transition: all 0.3s ease;
        }

        .step.active .step-title {
            color: var(--primary);
            font-weight: 600;
        }

        .step.completed .step-title {
            color: var(--success);
        }

        .step:not(:last-child):after {
            content: '';
            position: absolute;
            top: 20px;
            left: 60px;
            right: 0;
            height: 2px;
            background: var(--gray-light);
            z-index: 0;
            transition: all 0.3s ease;
        }

        .step.completed:not(:last-child):after {
            background: var(--success);
        }

        /* Booking Content */
        .booking-content {
            padding: 2rem;
        }

        .booking-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .booking-content .text-muted {
            color: var(--gray);
            margin-bottom: 1.5rem;
            display: block;
        }

        /* Service Grid */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .service-card {
            background: white;
            border-radius: var(--rounded-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-light);
            cursor: pointer;
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }

        .service-card.selected {
            border: 2px solid var(--primary);
            background: var(--primary-light);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .service-icon {
            background: var(--primary-light);
            color: var(--primary);
            width: 60px;
            height: 60px;
            border-radius: var(--rounded-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 1.5rem auto 1rem;
            transition: all 0.3s ease;
        }

        .service-card.selected .service-icon {
            background: var(--primary);
            color: white;
        }

        .service-content {
            padding: 0 1.5rem 1.5rem;
            text-align: center;
        }

        .service-content h3 {
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .service-card.selected .service-content h3 {
            color: var(--primary-dark);
        }

        .service-content p {
            color: var(--gray);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--gray-light);
            border-radius: var(--rounded-md);
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
            font-size: 1rem;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .datetime-picker {
            position: relative;
        }

        .datetime-picker .form-control {
            padding-left: 3rem;
        }

        .datetime-picker:before {
            content: '\f073';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            z-index: 1;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1.75rem;
            border-radius: var(--rounded-md);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--gray);
            color: var(--dark);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .btn i {
            margin-right: 0.5rem;
        }

        /* Booking Summary */
        .booking-summary {
            background: var(--light);
            border-radius: var(--rounded-lg);
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid var(--gray-light);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-light);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        /* Other Service Input */
        .other-service-input {
            margin-top: 1rem;
            display: none;
        }

        /* Success Page */
        .success-icon {
            font-size: 5rem;
            color: var(--success);
            margin-bottom: 1rem;
            animation: bounce 1s;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }

        /* Utility Classes */
        .hidden {
            display: none;
        }

        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: var(--rounded);
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .text-muted {
            color: var(--gray);
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: end;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .booking-steps {
                flex-wrap: wrap;
            }
            
            .step {
                flex: 0 0 calc(50% - 1rem);
                margin-bottom: 1rem;
            }
            
            .step:not(:last-child):after {
                display: none;
            }
            
            .service-grid {
                grid-template-columns: 1fr;
            }

            .booking-hero {
                padding: 3rem 0;
            }

            .booking-hero h1 {
                font-size: 2rem;
            }

            .booking-hero p {
                font-size: 1rem;
            }

            .header-container {
                flex-direction: column;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
            }

            .header-links {
                width: 100%;
                justify-content: space-between;
            }

            .booking-card {
                margin-top: -2rem;
            }
        }

        @media (max-width: 480px) {
            .booking-content {
                padding: 1.5rem;
            }

            .booking-header {
                padding: 1.5rem;
            }

            .booking-steps {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="/" class="logo">
                <i class="fas fa-headset"></i> IT Sahayta
            </a>
            <div class="header-links">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($userName); ?></span>
                <a href="/views/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="booking-hero">
        <div class="container">
            <h1>Book IT Service Slot</h1>
            <p>Schedule your IT support session with our expert technicians</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($showSuccess && $bookingDetails): ?>
            <div class="booking-card">
                <div class="booking-header text-center">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>Booking Confirmed!</h2>
                    <p>Your IT service slot has been successfully booked.</p>
                </div>
                
                <div class="booking-content">
                    <div class="booking-summary" style="max-width: 600px; margin: 0 auto;">
                        <div class="summary-item">
                            <span>Booking ID:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['booking_id']); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Service:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['service_name']); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Date:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['booking_date']); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Time Slot:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['booking_time']); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Problem Description:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['problem_description']); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Special Notes:</span>
                            <span><?php echo htmlspecialchars($bookingDetails['special_notes'] ?: 'None'); ?></span>
                        </div>
                    </div>
                    
                    <div class="text-center" style="margin-top: 2rem;">
                        <p>We've sent the confirmation details to your email address.</p>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem;">
                            <a href="/views/user_dashboard.php" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                            </a>
                            <a href="/views/book_slot.php" class="btn btn-outline">
                                <i class="fas fa-calendar-plus"></i> Book Another Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="booking-card">
                <input type="hidden" name="confirm_booking" value="1">
                
                <div class="booking-header">
                    <h2>Get Technical Support</h2>
                    <p>Select a service, choose your preferred time slot, and confirm your booking</p>
                </div>

                <div class="booking-steps">
                    <div class="step active" id="step1">
                        <div class="step-number">1</div>
                        <div class="step-title">Select Service</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-number">2</div>
                        <div class="step-title">Choose Time</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-number">3</div>
                        <div class="step-title">Confirm</div>
                    </div>
                </div>

                <div class="booking-content">
                    <!-- Step 1: Select Service -->
                    <div id="service-selection">
                        <h3>What service do you need?</h3>
                        <p class="text-muted">Select one of our popular IT services</p>

                        <div class="service-grid">
                            <div class="service-card" data-service="hardware">
                                <div class="service-icon">
                                    <i class="fas fa-desktop"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Hardware Repair</h3>
                                    <p>Diagnose and fix hardware issues with your devices</p>
                                </div>
                                <input type="radio" name="service_type" value="hardware" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Hardware Repair">
                            </div>

                            <div class="service-card" data-service="software">
                                <div class="service-icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Software Support</h3>
                                    <p>Installation, troubleshooting and configuration</p>
                                </div>
                                <input type="radio" name="service_type" value="software" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Software Support">
                            </div>

                            <div class="service-card" data-service="network">
                                <div class="service-icon">
                                    <i class="fas fa-wifi"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Network Setup</h3>
                                    <p>WiFi, router configuration and network issues</p>
                                </div>
                                <input type="radio" name="service_type" value="network" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Network Setup">
                            </div>

                            <div class="service-card" data-service="virus">
                                <div class="service-icon">
                                    <i class="fas fa-shield-virus"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Virus Removal</h3>
                                    <p>Malware scanning and complete system cleanup</p>
                                </div>
                                <input type="radio" name="service_type" value="virus" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Virus Removal">
                            </div>

                            <div class="service-card" data-service="data">
                                <div class="service-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Data Recovery</h3>
                                    <p>Recover lost or deleted files and documents</p>
                                </div>
                                <input type="radio" name="service_type" value="data" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Data Recovery">
                            </div>

                            <div class="service-card" data-service="other">
                                <div class="service-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Other Service</h3>
                                    <p>Request a different IT service not listed here</p>
                                </div>
                                <input type="radio" name="service_type" value="other" style="display: none;" required>
                                <input type="hidden" name="service_name" value="Other Service">
                            </div>
                        </div>

                        <div class="other-service-input" id="other-service-container">
                            <label for="other-service-name">Please specify your service:</label>
                            <input type="text" id="other-service-name" name="other_service_name" class="form-control" placeholder="Enter the service you need">
                        </div>

                        <div class="form-group">
                            <label for="problem-description">Problem Description *</label>
                            <textarea id="problem-description" name="problem_description" class="form-control" rows="4" required placeholder="Please describe your issue in detail..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" id="next-to-time" class="btn btn-primary">
                                Next: Choose Time <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Choose Time -->
                    <div id="time-selection" class="hidden">
                        <h3>When do you need service?</h3>
                        <p class="text-muted">Select your preferred date and time slot</p>

                        <div class="form-group">
                            <label>Service Type</label>
                            <div id="selected-service-display" class="form-control" style="background: #f8f9fa; font-weight: 500;"></div>
                        </div>

                        <div class="form-group">
                            <label for="booking-date">Date *</label>
                            <div class="datetime-picker">
                                <input type="text" id="booking-date" name="booking_date" class="form-control" required placeholder="Select date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="booking-time">Time Slot *</label>
                            <select id="booking-time" name="booking_time" class="form-control" required>
                                <option value="">Select time slot</option>
                                <option value="09:00-11:00">Morning (9:00 AM - 11:00 AM)</option>
                                <option value="11:00-13:00">Late Morning (11:00 AM - 1:00 PM)</option>
                                <option value="13:00-15:00">Afternoon (1:00 PM - 3:00 PM)</option>
                                <option value="15:00-17:00">Late Afternoon (3:00 PM - 5:00 PM)</option>
                                <option value="17:00-19:00">Evening (5:00 PM - 7:00 PM)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contact-number">Contact Number *</label>
                            <input type="tel" id="contact-number" name="contact_number" class="form-control" required placeholder="Your phone number" value="<?php echo htmlspecialchars($userPhone); ?>">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" id="back-to-service" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" id="next-to-confirm" class="btn btn-primary">
                                Next: Confirm Booking <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Confirm Booking -->
                    <div id="confirm-booking" class="hidden">
                        <h3>Confirm Your Booking</h3>
                        <p class="text-muted">Review your details before confirming</p>

                        <div class="booking-summary">
                            <div class="summary-item">
                                <span>Service:</span>
                                <span id="summary-service"></span>
                            </div>
                            <div class="summary-item">
                                <span>Date:</span>
                                <span id="summary-date"></span>
                            </div>
                            <div class="summary-item">
                                <span>Time Slot:</span>
                                <span id="summary-time"></span>
                            </div>
                            <div class="summary-item">
                                <span>Contact:</span>
                                <span id="summary-contact"></span>
                            </div>
                            <div class="summary-item">
                                <span>Problem Description:</span>
                                <span id="summary-problem"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer-name">Your Name *</label>
                            <input type="text" id="customer-name" name="customer_name" class="form-control" required placeholder="Enter your full name" value="<?php echo htmlspecialchars($userName); ?>">
                        </div>
                        <div class="form-group">
                            <label for="customer-email">Email Address *</label>
                            <input type="email" id="customer-email" name="customer_email" class="form-control" required placeholder="Enter your email" value="<?php echo htmlspecialchars($userEmail); ?>">
                        </div>

                        <div class="form-group">
                            <label for="special-notes">Special Notes (Optional)</label>
                            <textarea id="special-notes" name="special_notes" class="form-control" rows="3" placeholder="Any special instructions for our technician..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" id="back-to-time" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" id="confirm-booking-btn" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i> Confirm Booking
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date picker
            flatpickr("#booking-date", {
                minDate: "today",
                maxDate: new Date().fp_incr(14), // 14 days from now
                dateFormat: "Y-m-d",
                disable: [
                    function(date) {
                        // Disable Sundays
                        return (date.getDay() === 0);
                    }
                ]
            });

            // Service selection
            const serviceCards = document.querySelectorAll('.service-card');
            const otherServiceContainer = document.getElementById('other-service-container');
            
            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove selection from all cards
                    serviceCards.forEach(c => {
                        c.classList.remove('selected');
                        c.querySelector('input[type="radio"]').checked = false;
                    });
                    
                    // Select current card
                    this.classList.add('selected');
                    const radioInput = this.querySelector('input[type="radio"]');
                    radioInput.checked = true;
                    
                    // Show/hide other service input
                    if (this.dataset.service === 'other') {
                        otherServiceContainer.style.display = 'block';
                    } else {
                        otherServiceContainer.style.display = 'none';
                    }
                    
                    // Update selected service display
                    let serviceName = this.querySelector('h3').textContent;
                    if (this.dataset.service === 'other') {
                        const otherServiceName = document.getElementById('other-service-name').value;
                        if (otherServiceName) {
                            serviceName = otherServiceName;
                        }
                    }
                    document.getElementById('selected-service-display').textContent = serviceName;
                });
            });

            // Other service name input event
            document.getElementById('other-service-name').addEventListener('input', function() {
                const otherServiceCard = document.querySelector('.service-card[data-service="other"]');
                if (otherServiceCard.classList.contains('selected')) {
                    document.getElementById('selected-service-display').textContent = this.value || 'Other Service';
                }
            });

            // Step navigation
            const nextToTimeBtn = document.getElementById('next-to-time');
            const nextToConfirmBtn = document.getElementById('next-to-confirm');
            const backToServiceBtn = document.getElementById('back-to-service');
            const backToTimeBtn = document.getElementById('back-to-time');

            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');

            const serviceSelection = document.getElementById('service-selection');
            const timeSelection = document.getElementById('time-selection');
            const confirmBooking = document.getElementById('confirm-booking');

            nextToTimeBtn.addEventListener('click', function() {
                const selectedService = document.querySelector('input[name="service_type"]:checked');
                const problemDesc = document.getElementById('problem-description').value;
                
                if (!selectedService) {
                    alert('Please select a service');
                    return;
                }

                if (selectedService.value === 'other') {
                    const otherServiceName = document.getElementById('other-service-name').value;
                    if (!otherServiceName.trim()) {
                        alert('Please specify your service');
                        return;
                    }
                    // Update the hidden service_name input
                    document.querySelector('.service-card[data-service="other"] input[name="service_name"]').value = otherServiceName;
                }

                if (!problemDesc.trim()) {
                    alert('Please describe your problem');
                    return;
                }

                // Move to next step
                step1.classList.remove('active');
                step1.classList.add('completed');
                step2.classList.add('active');
                
                serviceSelection.classList.add('hidden');
                timeSelection.classList.remove('hidden');
                timeSelection.classList.add('fade-in');
            });

            nextToConfirmBtn.addEventListener('click', function() {
                const bookingDate = document.getElementById('booking-date').value;
                const bookingTime = document.getElementById('booking-time').value;
                const contactNumber = document.getElementById('contact-number').value;

                if (!bookingDate) {
                    alert('Please select a booking date');
                    return;
                }

                if (!bookingTime) {
                    alert('Please select a time slot');
                    return;
                }

                if (!contactNumber.trim()) {
                    alert('Please enter your contact number');
                    return;
                }

                // Update summary
                const selectedCard = document.querySelector('.service-card.selected');
                let serviceName = selectedCard.querySelector('h3').textContent;
                
                // For other service, use the custom name
                if (selectedCard.dataset.service === 'other') {
                    const otherServiceName = document.getElementById('other-service-name').value;
                    if (otherServiceName) {
                        serviceName = otherServiceName;
                    }
                }
                
                const problemDesc = document.getElementById('problem-description').value;
                
                document.getElementById('summary-service').textContent = serviceName;
                document.getElementById('summary-date').textContent = bookingDate;
                document.getElementById('summary-time').textContent = bookingTime;
                document.getElementById('summary-contact').textContent = contactNumber;
                document.getElementById('summary-problem').textContent = problemDesc;

                // Move to next step
                step2.classList.remove('active');
                step2.classList.add('completed');
                step3.classList.add('active');
                
                timeSelection.classList.add('hidden');
                confirmBooking.classList.remove('hidden');
                confirmBooking.classList.add('fade-in');
            });

            backToServiceBtn.addEventListener('click', function() {
                step1.classList.add('active');
                step1.classList.remove('completed');
                step2.classList.remove('active');
                
                timeSelection.classList.add('hidden');
                serviceSelection.classList.remove('hidden');
                serviceSelection.classList.add('fade-in');
            });

            backToTimeBtn.addEventListener('click', function() {
                step2.classList.add('active');
                step2.classList.remove('completed');
                step3.classList.remove('active');
                
                confirmBooking.classList.add('hidden');
                timeSelection.classList.remove('hidden');
                timeSelection.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>