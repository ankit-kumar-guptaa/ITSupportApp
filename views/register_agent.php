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
                $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes')); // Changed to 5 minutes

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

<?php include 'header.php'; ?>
<main>
    <section class="dashboard-section">
        <div class="dashboard-box" data-aos="fade-up">
            <h2>Agent Registration</h2>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/views/register_agent.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Enter 10-digit phone number">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required placeholder="Enter your address"></textarea>
                </div>
                <div class="form-group">
                    <label for="govt_id_type">Government ID Type</label>
                    <select id="govt_id_type" name="govt_id_type" required>
                        <option value="">Select ID Type</option>
                        <option value="Aadhaar">Aadhaar</option>
                        <option value="PAN">PAN</option>
                        <option value="Voter ID">Voter ID</option>
                        <option value="Driving License">Driving License</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="govt_id_number">Government ID Number</label>
                    <input type="text" id="govt_id_number" name="govt_id_number" required placeholder="Enter your ID number">
                </div>
                <div class="form-group">
                    <label for="govt_id_front">Government ID Front Image</label>
                    <input type="file" id="govt_id_front" name="govt_id_front" required accept="image/*">
                </div>
                <div class="form-group">
                    <label for="govt_id_back">Government ID Back Image</label>
                    <input type="file" id="govt_id_back" name="govt_id_back" required accept="image/*">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="cta-btn">Register</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>