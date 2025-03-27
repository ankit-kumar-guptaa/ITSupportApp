<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (empty($password)) {
        $error = "Password is required!";
    } else {
        // Check if agent exists
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE email = ?");
        $stmt->execute([$email]);
        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agent) {
            // Verify password
            if (password_verify($password, $agent['password'])) {
                // Check if agent is approved
                if ($agent['status'] !== 'approved') {
                    $error = "Your account is not approved yet. Please wait for admin approval.";
                } else {
                    // Set session variables
                    $_SESSION['user_id'] = $agent['id'];
                    $_SESSION['role'] = 'agent';
                    $_SESSION['name'] = $agent['name'];

                    // Redirect to agent dashboard
                    header("Location: /views/agent_dashboard.php?success=Login successful!");
                    exit;
                }
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Login - IT Sahayata</title>
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
        
        .login-section {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            background: linear-gradient(135deg, #f9fbfd 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }
        
        .login-section::before {
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
        
        .login-section::after {
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
        
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: white;
            clip-path: ellipse(75% 100% at center top);
        }
        
        .login-body {
            padding: 2.5rem;
        }
        
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding-left: 45px;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
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
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .alert {
            border-radius: 8px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--gray);
        }
        
        .login-footer a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .brand-logo {
            width: 120px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="login-card">
                        <div class="login-header">
                            <img src="/assets/logo.svg" alt="IT Sahayata" class="brand-logo">
                            <h2>Agent Login</h2>
                            <p class="mb-0">Access your agent dashboard</p>
                        </div>
                        
                        <div class="login-body">
                            <?php if (isset($_GET['success'])): ?>
                                <div class="alert alert-success">
                                    <?php echo htmlspecialchars($_GET['success']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>
                            
                            <form action="/views/agent_login.php" method="POST">
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-wrapper">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control ps-5" id="email" name="email" required placeholder="agent@example.com">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-wrapper">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control ps-5" id="password" name="password" required placeholder="••••••••">
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-login">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </button>
                                </div>
                            </form>
                            
                            <div class="login-footer">
                                <p class="mb-0">Don't have an account? <a href="/views/register_agent.php">Register as Agent</a></p>
                                <p class="mt-2"><a href="/views/forgot_password.php">Forgot password?</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'footer.php'; ?>

   
