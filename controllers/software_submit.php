<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SMTP Configuration
$smtpConfig = [
    'host' => 'smtp.hostinger.com',
    'username' => 'no-reply@itsahayata.com',
    'password' => 'Support@1925',
    'port' => 587,
    'admin_email' => 'admin@itsahayata.com',
    'from_name' => 'IT Sahayata'
];

// Sanitize and validate input
$formData = [
    'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '',
    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '',
    'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) ?? '',
    'company' => filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING) ?? '',
    'project_type' => filter_input(INPUT_POST, 'project_type', FILTER_SANITIZE_STRING) ?? '',
    'requirements' => filter_input(INPUT_POST, 'requirements', FILTER_SANITIZE_STRING) ?? '',
    'budget' => filter_input(INPUT_POST, 'budget', FILTER_SANITIZE_STRING) ?? '',
    'timeline' => filter_input(INPUT_POST, 'timeline', FILTER_SANITIZE_STRING) ?? '',
    'selected_features' => filter_input(INPUT_POST, 'selected_features', FILTER_SANITIZE_STRING) ?? '',
    'total_amount' => filter_input(INPUT_POST, 'total_amount', FILTER_SANITIZE_STRING) ?? '',
    'service_type' => filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_STRING) ?? 'software_development'
];

// Generate admin email HTML
$adminEmailHTML = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quote Request</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f5f7fa; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); padding: 25px; text-align: center; }
        .logo { height: 40px; }
        .title { color: white; font-size: 22px; font-weight: 600; margin-top: 15px; }
        .content { padding: 30px; }
        .detail-row { display: flex; margin-bottom: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; }
        .detail-label { flex: 1; color: #4361ee; font-weight: 500; min-width: 150px; }
        .detail-value { flex: 2; color: #333; }
        .highlight { color: #3a0ca3; font-weight: 600; }
        .features { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 10px; }
        .footer { text-align: center; padding: 20px; color: #888; font-size: 14px; }
        .total-box { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 8px; text-align: center; margin-top: 20px; }
        .total-label { font-size: 16px; color: #555; }
        .total-amount { font-size: 24px; color: #2b9348; font-weight: 700; margin-top: 5px; }
        .icon { margin-right: 8px; color: #4361ee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://itsahayata.com/assets/logo.svg" alt="IT Sahayata" class="logo">
            <div class="title">New Software Development Quote Request</div>
        </div>
        <div class="content">
            <div class="detail-row">
                <div class="detail-label">👤 Client Name</div>
                <div class="detail-value">{$formData['name']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">📧 Email Address</div>
                <div class="detail-value">{$formData['email']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">📞 Phone Number</div>
                <div class="detail-value">{$formData['phone']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">🏢 Company</div>
                <div class="detail-value">{$formData['company']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">💻 Project Type</div>
                <div class="detail-value">{$formData['project_type']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">📅 Timeline</div>
                <div class="detail-value highlight">{$formData['timeline']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">💰 Budget Range</div>
                <div class="detail-value highlight">{$formData['budget']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">🛠️ Service Type</div>
                <div class="detail-value">{$formData['service_type']}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">✨ Selected Features</div>
                <div class="detail-value">
                    <div class="features">{$formData['selected_features']}</div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">📝 Requirements</div>
                <div class="detail-value">{$formData['requirements']}</div>
            </div>
            
            <div class="total-box">
                <div class="total-label">Estimated Project Value</div>
                <div class="total-amount">₹{$formData['total_amount']}</div>
            </div>
        </div>
        <div class="footer">
            This quote request was submitted through IT Sahayata website. Please respond within 24 hours.
        </div>
    </div>
</body>
</html>
HTML;

// Generate client confirmation email HTML
$clientEmailHTML = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Request</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f5f7fa; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); padding: 25px; text-align: center; }
        .logo { height: 40px; }
        .title { color: white; font-size: 22px; font-weight: 600; margin-top: 15px; }
        .content { padding: 30px; }
        .thank-you { font-size: 24px; color: #3a0ca3; font-weight: 600; text-align: center; margin-bottom: 20px; }
        .message { color: #555; line-height: 1.6; margin-bottom: 25px; }
        .summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .summary-title { color: #4361ee; font-weight: 600; margin-bottom: 10px; }
        .summary-item { margin-bottom: 8px; }
        .summary-label { font-weight: 500; color: #333; }
        .summary-value { color: #555; }
        .next-steps { margin-top: 25px; }
        .steps-title { color: #4361ee; font-weight: 600; margin-bottom: 10px; }
        .step { display: flex; margin-bottom: 15px; }
        .step-number { background: #4361ee; color: white; width: 24px; height: 24px; border-radius: 50%; text-align: center; line-height: 24px; margin-right: 10px; flex-shrink: 0; }
        .step-text { color: #555; }
        .contact { margin-top: 25px; text-align: center; }
        .contact-title { color: #4361ee; font-weight: 600; margin-bottom: 10px; }
        .contact-info { color: #555; }
        .footer { text-align: center; padding: 20px; color: #888; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://itsahayata.com/assets/logo.svg" alt="IT Sahayata" class="logo">
            <div class="title">Thank You for Your Interest</div>
        </div>
        <div class="content">
            <div class="thank-you">Thank You, {$formData['name']}!</div>
            
            <div class="message">
                We've received your request for a {$formData['project_type']} project and our team is already reviewing your requirements. 
                You'll hear from us within 24 hours with a detailed proposal.
            </div>
            
            <div class="summary">
                <div class="summary-title">📋 Request Summary</div>
                <div class="summary-item">
                    <span class="summary-label">Project Type:</span>
                    <span class="summary-value">{$formData['project_type']}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Estimated Budget:</span>
                    <span class="summary-value">{$formData['budget']}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Timeline:</span>
                    <span class="summary-value">{$formData['timeline']}</span>
                </div>
            </div>
            
            <div class="next-steps">
                <div class="steps-title">📅 What Happens Next?</div>
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Our team will review your requirements and may contact you for clarifications</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">We'll prepare a detailed proposal with timeline and cost breakdown</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">You'll receive our proposal via email within 24 hours</div>
                </div>
            </div>
            
            <div class="contact">
                <div class="contact-title">Need Immediate Assistance?</div>
                <div class="contact-info">
                    Call us at +91 XXXXX XXXXX or reply to this email
                </div>
            </div>
        </div>
        <div class="footer">
            IT Sahayata &copy; 2023 | Transforming Ideas Into Digital Reality
        </div>
    </div>
</body>
</html>
HTML;

// Send emails using PHPMailer
$mailer = new PHPMailer(true);

try {
    // Configure PHPMailer
    $mailer->isSMTP();
    $mailer->Host       = $smtpConfig['host'];
    $mailer->SMTPAuth   = true;
    $mailer->Username   = $smtpConfig['username'];
    $mailer->Password   = $smtpConfig['password'];
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port       = $smtpConfig['port'];
    $mailer->CharSet    = 'UTF-8';
    
    // First send to admin
    $mailer->setFrom($smtpConfig['username'], $smtpConfig['from_name']);
    $mailer->addAddress($smtpConfig['admin_email']);
    $mailer->isHTML(true);
    $mailer->Subject = 'New Quote Request: ' . $formData['project_type'] . ' Project';
    $mailer->Body    = $adminEmailHTML;
    $mailer->send();
    
    // Then send confirmation to client
    $mailer->clearAddresses();
    $mailer->addAddress($formData['email']);
    $mailer->Subject = 'Thank You for Your Quote Request - IT Sahayata';
    $mailer->Body    = $clientEmailHTML;
    $mailer->send();
    
    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your request has been submitted successfully. Check your email for confirmation.'
    ]);
    
} catch (Exception $e) {
    // Error response
    echo json_encode([
        'success' => false,
        'message' => 'We encountered an error while processing your request. Please try again later.',
        'error' => $mailer->ErrorInfo
    ]);
}