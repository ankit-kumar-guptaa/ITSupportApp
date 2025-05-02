<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

// Database configuration
$host = 'localhost';
$dbname = 'itsupport_db';
$username = 'root';
$password = '';

// SMTP configuration
$smtpHost = 'smtp.hostinger.com';
$smtpUsername = 'no-reply@itsahayata.com';
$smtpPassword = 'Support@1925';
$smtpPort = 587; // Use 465 for SSL or 587 for TLS
$adminEmail = 'admin@itsahayata.com';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Save data to the database
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);
    } catch (PDOException $e) {
        die("Failed to save data: " . $e->getMessage());
    }

    // Send email to admin
    $adminMail = new PHPMailer(true);
    try {
        $adminMail->isSMTP();
        $adminMail->Host = $smtpHost;
        $adminMail->SMTPAuth = true;
        $adminMail->Username = $smtpUsername;
        $adminMail->Password = $smtpPassword;
        $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $adminMail->Port = $smtpPort;

        $adminMail->setFrom($smtpUsername, 'IT Sahayata');
        $adminMail->addAddress($adminEmail);

        $adminMail->isHTML(true);
        $adminMail->Subject = 'New Contact Form Submission';
        $adminMail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $adminMail->send();
    } catch (Exception $e) {
        die("Failed to send admin email: " . $adminMail->ErrorInfo);
    }

    // Send confirmation email to the user
    $userMail = new PHPMailer(true);
    try {
        $userMail->isSMTP();
        $userMail->Host = $smtpHost;
        $userMail->SMTPAuth = true;
        $userMail->Username = $smtpUsername;
        $userMail->Password = $smtpPassword;
        $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $userMail->Port = $smtpPort;

        $userMail->setFrom($smtpUsername, 'IT Sahayata');
        $userMail->addAddress($email);

        $userMail->isHTML(true);
        $userMail->Subject = 'Thank you for contacting us!';
        $userMail->Body = "
            <h3>Dear $name,</h3>
            <p>Thank you for reaching out to us. We have received your message and will get back to you shortly.</p>
            <p>Best regards,<br>IT Sahayata Team</p>
        ";

        $userMail->send();
    } catch (Exception $e) {
        die("Failed to send confirmation email: " . $userMail->ErrorInfo);
    }

    // Redirect to a thank-you page
    header("Location: ../views/thank-you.php");
    exit();
}
?>