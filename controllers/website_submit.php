
<?php
// Load PHPMailer
require '../vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SMTP config
$smtpHost = 'smtp.hostinger.com';
$smtpUsername = 'no-reply@itsahayata.com';
$smtpPassword = 'Support@1925';
$smtpPort = 587;
$adminEmail = 'admin@itsahayata.com';

// Get POST data safely
$name         = isset($_POST['name']) ? trim($_POST['name']) : '';
$email        = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone        = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$company      = isset($_POST['company']) ? trim($_POST['company']) : '';
$website_type = isset($_POST['website_type']) ? trim($_POST['website_type']) : '';
$features     = isset($_POST['features']) ? trim($_POST['features']) : '';
$requirements = isset($_POST['requirements']) ? trim($_POST['requirements']) : '';
$total_cost   = isset($_POST['total_cost']) ? trim($_POST['total_cost']) : '';
$service_type = isset($_POST['service_type']) ? trim($_POST['service_type']) : 'Website Development';

// Prepare email body
$body = "
New Website Quote Request:<br><br>
<b>Name:</b> $name<br>
<b>Email:</b> $email<br>
<b>Phone:</b> $phone<br>
<b>Company:</b> $company<br>
<b>Website Type:</b> $website_type<br>
<b>Selected Features:</b> $features<br>
<b>Additional Requirements:</b> $requirements<br>
<b>Total Estimated Cost:</b> ₹$total_cost<br>
<b>Service Type:</b> $service_type<br>
";

// Send email via PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUsername;
    $mail->Password   = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    $mail->setFrom($smtpUsername, 'IT Sahayata Website');
    $mail->addAddress($adminEmail);

    $mail->isHTML(true);
    $mail->Subject = 'New Website Quote Request - IT Sahayata';
    $mail->Body    = $body;

    $mail->send();

    // Success response for AJAX
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Error response for AJAX
    echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
}