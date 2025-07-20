
<?php
require '../vendor/autoload.php'; // PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SMTP config
$smtpHost = 'smtp.hostinger.com';
$smtpUsername = 'no-reply@itsahayata.com';
$smtpPassword = 'Support@1925';
$smtpPort = 587;
$adminEmail = 'theankitkumarg@gmail.com';

// Get POST data safely
$name             = isset($_POST['name']) ? trim($_POST['name']) : '';
$email            = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone            = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$company          = isset($_POST['company']) ? trim($_POST['company']) : '';
$service_type     = isset($_POST['service_type']) ? trim($_POST['service_type']) : '';
$requirements     = isset($_POST['requirements']) ? trim($_POST['requirements']) : '';
$data_volume      = isset($_POST['data_volume']) ? trim($_POST['data_volume']) : '';
$budget           = isset($_POST['budget']) ? trim($_POST['budget']) : '';
$timeline         = isset($_POST['timeline']) ? trim($_POST['timeline']) : '';
$current_system   = isset($_POST['current_system']) ? trim($_POST['current_system']) : '';
$selectedFeatures = isset($_POST['selected_features']) ? trim($_POST['selected_features']) : '';
$totalAmount      = isset($_POST['total_amount']) ? trim($_POST['total_amount']) : '';
$service_category = isset($_POST['service_category']) ? trim($_POST['service_category']) : 'data_management';

// Prepare attractive HTML email body
$body = '
<div style="font-family:Poppins,Segoe UI,Arial,sans-serif;background:#f8fafc;padding:0;margin:0;">
  <div style="max-width:520px;margin:32px auto;background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(67,97,238,0.10);overflow:hidden;">
    <div style="background:linear-gradient(90deg,#667eea 0%,#764ba2 100%);padding:22px 28px;">
      <img src="https://itsahayata.com/assets/logo.svg" alt="IT Sahayata" style="height:38px;vertical-align:middle;margin-right:10px;">
      <span style="font-size:1.3rem;font-weight:700;color:#fff;vertical-align:middle;">New Data Management Quote Request</span>
    </div>
    <div style="padding:28px 28px 18px 28px;">
      <table style="width:100%;border-collapse:collapse;font-size:1.05rem;">
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;width:160px;"><i style="margin-right:7px;" class="fas fa-user"></i> Name:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($name) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-envelope"></i> Email:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($email) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-phone"></i> Phone:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($phone) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-building"></i> Company:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($company) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-cogs"></i> Service Type:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($service_type) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-list"></i> Selected Features:</td>
          <td style="padding:8px 0;">' . nl2br(htmlspecialchars($selectedFeatures)) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-rupee-sign"></i> Budget Range:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($budget) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-database"></i> Data Volume:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($data_volume) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-calendar-alt"></i> Timeline:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($timeline) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-file-alt"></i> Requirements:</td>
          <td style="padding:8px 0;">' . nl2br(htmlspecialchars($requirements)) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-server"></i> Current System:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($current_system) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-money-bill-wave"></i> Total Amount:</td>
          <td style="padding:8px 0;font-weight:700;color:#00b894;">₹' . htmlspecialchars($totalAmount) . '</td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:#667eea;font-weight:600;"><i style="margin-right:7px;" class="fas fa-cogs"></i> Service Category:</td>
          <td style="padding:8px 0;">' . htmlspecialchars($service_category) . '</td>
        </tr>
      </table>
      <div style="margin-top:22px;padding:16px 18px;background:#f1f2f6;border-radius:12px;color:#636e72;font-size:0.98rem;">
        <i class="fas fa-info-circle" style="color:#667eea;margin-right:7px;"></i>
        This is an automated quote request from IT Sahayata website.
      </div>
    </div>
  </div>
  <div style="text-align:center;color:#b2bec3;font-size:0.93rem;margin-top:18px;">
    Powered by <a href="https://itsahayata.com" style="color:#667eea;text-decoration:none;font-weight:600;">IT Sahayata</a>
  </div>
</div>
';

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

    $mail->setFrom($smtpUsername, 'IT Sahayata Data Quote');
    $mail->addAddress($adminEmail);

    $mail->isHTML(true);
    $mail->Subject = 'New Data Management Quote Request - IT Sahayata';
    $mail->Body    = $body;

    $mail->send();

    // Success response for AJAX
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Error response for AJAX
    echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
}