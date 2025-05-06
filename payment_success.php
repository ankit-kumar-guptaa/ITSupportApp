<?php
session_start();
require_once 'config/db.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$subscription_details = null;

if (!empty($payment_id)) {
    // Get subscription details from database
    $stmt = $conn->prepare("SELECT s.*, p.name as plan_name 
                           FROM subscriptions s 
                           LEFT JOIN plans p ON s.plan_id = p.id
                           WHERE s.payment_id = ? AND s.user_id = ?");
    $stmt->bind_param("si", $payment_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $subscription_details = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<?php include 'views/header.php'; ?>

<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5 text-center">
                        <?php if ($subscription_details): ?>
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                            </div>
                            <h1 class="display-4 fw-bold text-success mb-4">Payment Successful!</h1>
                            <p class="lead mb-4">Your payment has been processed successfully and your subscription is now active.</p>
                            
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Subscription Details</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Plan:</span>
                                            <strong><?php echo isset($subscription_details['plan_name']) ? $subscription_details['plan_name'] : $subscription_details['plan_id']; ?></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Billing Cycle:</span>
                                            <strong><?php echo ucfirst($subscription_details['billing_cycle']); ?></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Amount:</span>
                                            <strong>₹<?php echo number_format($subscription_details['amount']); ?></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Payment ID:</span>
                                            <strong><?php echo $subscription_details['payment_id']; ?></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Payment Date:</span>
                                            <strong><?php echo date('d M Y, h:i A', strtotime($subscription_details['payment_date'])); ?></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Expiry Date:</span>
                                            <strong><?php echo date('d M Y', strtotime($subscription_details['expiry_date'])); ?></strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <p class="mb-4">A payment confirmation email has been sent to your registered email address.</p>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="dashboard.php" class="btn btn-primary btn-lg px-5">Go to Dashboard</a>
                                <a href="contact.php" class="btn btn-outline-secondary btn-lg px-5">Get Support</a>
                            </div>
                        <?php else: ?>
                            <div class="mb-4">
                                <i class="fas fa-exclamation-circle text-warning" style="font-size: 80px;"></i>
                            </div>
                            <h1 class="display-4 fw-bold text-warning mb-4">Payment Details Not Found</h1>
                            <p class="lead mb-4">We are unable to retrieve your payment details. If you have made a payment, please contact our customer support.</p>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="dashboard.php" class="btn btn-primary btn-lg px-5">Go to Dashboard</a>
                                <a href="contact.php" class="btn btn-outline-secondary btn-lg px-5">Get Support</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'views/footer.php'; ?>