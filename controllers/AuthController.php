<?php
require_once '../config/db.php';

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function sendOtp($email) {
        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return "Email already exists!";
        }

        // Generate OTP and store in session temporarily
        $otp = rand(100000, 999999); // 6-digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        // Send OTP email
        $result = $this->sendOtpEmail($email, $otp);
        if ($result === true) {
            return "OTP sent to your email. Please verify.";
        } else {
            return "Failed to send OTP: $result";
        }
    }

    public function verifyOtp($otp) {
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $otp) {
            return "OTP verified successfully!";
        } else {
            return "Invalid OTP!";
        }
    }

    public function completeSignup($name, $mobile, $password) {
        $email = $_SESSION['otp_email'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, mobile, password, is_verified) VALUES (?, ?, ?, ?, 1)");
        if ($stmt->execute([$name, $email, $mobile, $hashedPassword])) {
            unset($_SESSION['otp']);
            unset($_SESSION['otp_email']);
            return "Signup successful! Please login.";
        } else {
            return "Signup failed!";
        }
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_verified'] == 0) {
                return "Please verify your email first!";
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return "Login successful!";
        } else {
            return "Invalid email or password!";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /ITSupportApp/");
        exit();
    }

    private function sendOtpEmail($email, $otp) {
        require '../vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            $mail->SMTPDebug = 2; // Debug mode on
            $mail->isSMTP();
            // Switch to Gmail SMTP for testing
            $mail->Host = 'smtp.hostinger.com';
            $mail->Username = 'rajiv@greencarcarpool.com';
            $mail->Password = 'Rajiv@111@';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAuth = true;

            $mail->setFrom('rajiv@greencarcarpool.com', 'IT Support Hub');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - IT Support Hub';
            $mail->Body = "Your OTP for email verification is: <b>$otp</b>. Please use this to verify your account.";

            if ($mail->send()) {
                return true;
            } else {
                return "Mailer Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            return "Exception: " . $e->getMessage();
        }
    }
}