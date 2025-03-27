<?php
session_start();
require '../config/db.php';
require '../config/email.php';

// Set time zone
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $govt_id_type = filter_input(INPUT_POST, 'govt_id_type', FILTER_SANITIZE_STRING);
    $govt_id_number = filter_input(INPUT_POST, 'govt_id_number', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
        $error = "Invalid phone number! Please enter a 10-digit number.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        $error = "Password must be at least 8 characters long, with 1 uppercase letter, 1 number, and 1 special character!";
    } elseif (empty($govt_id_type) || empty($govt_id_number)) {
        $error = "Government ID details are required!";
    } elseif (!isset($_FILES['govt_id_front']) || !isset($_FILES['govt_id_back'])) {
        $error = "Please upload both front and back images of your government ID!";
    } else {
        // Check if email or phone already exists
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE email = ? OR phone_number = ?");
        $stmt->execute([$email, $phone_number]);
        if ($stmt->rowCount() > 0) {
            $error = "Email or phone number already exists!";
        } else {
            // Handle file uploads
            $upload_dir = '../uploads/govt_ids/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $govt_id_front = $upload_dir . uniqid() . '_' . basename($_FILES['govt_id_front']['name']);
            $govt_id_back = $upload_dir . uniqid() . '_' . basename($_FILES['govt_id_back']['name']);

            if (move_uploaded_file($_FILES['govt_id_front']['tmp_name'], $govt_id_front) && move_uploaded_file($_FILES['govt_id_back']['tmp_name'], $govt_id_back)) {
                // Generate OTP for email
                $otp = rand(100000, 999999);
                $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

                // Delete any old OTPs for this email and action
                $stmt = $pdo->prepare("DELETE FROM otps WHERE email = ? AND action = 'agent_registration'");
                $stmt->execute([$email]);

                // Save OTP to database
                $stmt = $pdo->prepare("INSERT INTO otps (email, otp, expires_at, action) VALUES (?, ?, ?, 'agent_registration')");
                $stmt->execute([$email, $otp, $expires_at]);

                // Send OTP via email
                $subject = "OTP for Agent Registration - IT Support Hub";
                $body = "Dear $name,<br><br>Your OTP for agent registration is: <b>$otp</b>. It is valid for 5 minutes.<br><br>Thank you,<br>IT Support Hub Team";
                if (sendEmail($email, $subject, $body)) {
                    // Store registration details in session temporarily
                    $_SESSION['pending_agent_registration'] = [
                        'name' => $name,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'address' => $address,
                        'govt_id_type' => $govt_id_type,
                        'govt_id_number' => $govt_id_number,
                        'govt_id_front' => $govt_id_front,
                        'govt_id_back' => $govt_id_back,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ];
                    header("Location: /views/verify_agent_otp.php");
                    exit;
                } else {
                    $error = "Failed to send OTP. Please try again.";
                }
            } else {
                $error = "Failed to upload government ID images!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Registration - IT Sahayata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .registration-section {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            background: linear-gradient(135deg, #f9fbfd 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }
        
        .registration-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(37, 99, 235, 0.05);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            z-index: 0;
        }
        
        .registration-section::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: rgba(16, 185, 129, 0.05);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            z-index: 0;
        }
        
        .registration-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .registration-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .registration-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .registration-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: white;
            clip-path: ellipse(75% 100% at center top);
        }
        
        .registration-body {
            padding: 2.5rem;
        }
        
        .form-control, .form-select {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding-left: 45px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        
        textarea.form-control {
            height: auto;
            min-height: 100px;
            padding-top: 12px;
        }
        
        .input-group-text {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            background: transparent;
            border: none;
            color: var(--gray);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .alert {
            border-radius: 8px;
        }
        
        .registration-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--gray);
        }
        
        .registration-footer a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }
        
        .registration-footer a:hover {
            text-decoration: underline;
        }
        
        .brand-logo {
            width: 120px;
            margin-bottom: 1rem;
        }
        
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: var(--primary);
            background-color: rgba(37, 99, 235, 0.05);
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-icon {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .file-upload-text {
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .file-name {
            font-size: 0.85rem;
            margin-top: 0.5rem;
            color: var(--dark);
            font-weight: 500;
        }
        
        .password-strength {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: var(--success);
            transition: width 0.3s ease;
        }
        
        .password-requirements {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 0.5rem;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.3rem;
        }
        
        .requirement i {
            margin-right: 0.5rem;
            font-size: 0.7rem;
        }
        
        .requirement.valid {
            color: var(--success);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="registration-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="registration-card">
                        <div class="registration-header">
                            <img src="/assets/logo.svg" alt="IT Sahayata" class="brand-logo">
                            <h2>Become an IT Sahayata Agent</h2>
                            <p class="mb-0">Join our network of certified IT support professionals</p>
                        </div>
                        
                        <div class="registration-body">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>
                            
                            <form action="/views/register_agent.php" method="POST" enctype="multipart/form-data" id="registrationForm">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="form-label">Full Name</label>
                                        <div class="input-wrapper">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control ps-5" id="name" name="name" required placeholder="John Doe">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-wrapper">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control ps-5" id="email" name="email" required placeholder="agent@example.com">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <div class="input-wrapper">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control ps-5" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="9876543210">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="govt_id_type" class="form-label">Government ID Type</label>
                                        <div class="input-wrapper">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <select class="form-select ps-5" id="govt_id_type" name="govt_id_type" required>
                                                <option value="">Select ID Type</option>
                                                <option value="Aadhaar">Aadhaar</option>
                                                <option value="PAN">PAN</option>
                                                <option value="Voter ID">Voter ID</option>
                                                <option value="Driving License">Driving License</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="address" class="form-label">Address</label>
                                    <div class="input-wrapper">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <textarea class="form-control ps-5" id="address" name="address" required placeholder="Enter your complete address"></textarea>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="govt_id_number" class="form-label">Government ID Number</label>
                                    <div class="input-wrapper">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <input type="text" class="form-control ps-5" id="govt_id_number" name="govt_id_number" required placeholder="Enter your ID number">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Government ID Front Image</label>
                                        <div class="file-upload-wrapper">
                                            <label class="file-upload-label">
                                                <div class="file-upload-icon">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                                <div class="file-upload-text">Click to upload front image</div>
                                                <div class="file-name" id="frontFileName">No file selected</div>
                                                <input type="file" id="govt_id_front" name="govt_id_front" class="file-upload-input" required accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Government ID Back Image</label>
                                        <div class="file-upload-wrapper">
                                            <label class="file-upload-label">
                                                <div class="file-upload-icon">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                                <div class="file-upload-text">Click to upload back image</div>
                                                <div class="file-name" id="backFileName">No file selected</div>
                                                <input type="file" id="govt_id_back" name="govt_id_back" class="file-upload-input" required accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-wrapper">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control ps-5" id="password" name="password" required placeholder="Create a strong password">
                                    </div>
                                    <div class="password-strength">
                                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                    </div>
                                    <div class="password-requirements">
                                        <div class="requirement" id="lengthReq">
                                            <i class="fas fa-circle"></i>
                                            <span>At least 8 characters</span>
                                        </div>
                                        <div class="requirement" id="upperReq">
                                            <i class="fas fa-circle"></i>
                                            <span>1 uppercase letter</span>
                                        </div>
                                        <div class="requirement" id="numberReq">
                                            <i class="fas fa-circle"></i>
                                            <span>1 number</span>
                                        </div>
                                        <div class="requirement" id="specialReq">
                                            <i class="fas fa-circle"></i>
                                            <span>1 special character</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-register">
                                        <i class="fas fa-user-plus me-2"></i> Register as Agent
                                    </button>
                                </div>
                            </form>
                            
                            <div class="registration-footer">
                                <p class="mb-0">Already have an account? <a href="/views/agent_login.php">Login here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // File upload name display
        document.getElementById('govt_id_front').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
            document.getElementById('frontFileName').textContent = fileName;
        });
        
        document.getElementById('govt_id_back').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
            document.getElementById('backFileName').textContent = fileName;
        });
        
        // Password strength checker
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            
            // Calculate strength
            let strength = 0;
            
            // Length check
            if (password.length >= 8) {
                strength += 25;
                document.getElementById('lengthReq').classList.add('valid');
            } else {
                document.getElementById('lengthReq').classList.remove('valid');
            }
            
            // Uppercase check
            if (/[A-Z]/.test(password)) {
                strength += 25;
                document.getElementById('upperReq').classList.add('valid');
            } else {
                document.getElementById('upperReq').classList.remove('valid');
            }
            
            // Number check
            if (/[0-9]/.test(password)) {
                strength += 25;
                document.getElementById('numberReq').classList.add('valid');
            } else {
                document.getElementById('numberReq').classList.remove('valid');
            }
            
            // Special char check
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 25;
                document.getElementById('specialReq').classList.add('valid');
            } else {
                document.getElementById('specialReq').classList.remove('valid');
            }
            
            // Update strength bar
            strengthBar.style.width = strength + '%';
            
            // Update color based on strength
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#dc3545'; // Red
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#fd7e14'; // Orange
            } else if (strength < 100) {
                strengthBar.style.backgroundColor = '#ffc107'; // Yellow
            } else {
                strengthBar.style.backgroundColor = '#198754'; // Green
            }
        });
    </script>
