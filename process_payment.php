<?php
session_start();
require_once 'config/db.php';

// Razorpay API keys
$razorpay_key_id = 'rzp_live_W1ZSYhZ4kTPWhm';
$razorpay_key_secret = 'PQLN0YUtmxxM0OhRha3H9dRm';

// For GET request (creating order)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $plan_id = isset($_GET['plan']) ? $_GET['plan'] : '';
    $billing_cycle = isset($_GET['cycle']) ? $_GET['cycle'] : 'monthly';
    
    // Get plan prices
    $plans = [
        'basic' => [
            'monthly' => 1999,
            'annual' => 19190, // 20% discount on yearly
        ],
        'professional' => [
            'monthly' => 4999,
            'annual' => 47990, // 20% discount on yearly
        ],
        'enterprise' => [
            'monthly' => 9999,
            'annual' => 95990, // 20% discount on yearly
        ]
    ];
    
    if (isset($plans[$plan_id][$billing_cycle])) {
        $amount = $plans[$plan_id][$billing_cycle];
        
        // Create Razorpay order
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key_id . ':' . $razorpay_key_secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        $receipt = 'order_' . time() . rand(10, 99);
        
        $data = [
            'amount' => $amount * 100, // In paise (1 rupee = 100 paise)
            'currency' => 'INR',
            'receipt' => $receipt,
            'payment_capture' => 1
        ];
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $result = curl_exec($ch);
        
        // Check for cURL errors
        if(curl_errno($ch)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'cURL Error: ' . curl_error($ch)
            ]);
            curl_close($ch);
            exit;
        }
        
        curl_close($ch);
        
        $order = json_decode($result, true);
        
        if (isset($order['id'])) {
            // Order created successfully
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amount,
                'plan_id' => $plan_id,
                'billing_cycle' => $billing_cycle,
                'key_id' => $razorpay_key_id
            ]);
        } else {
            // Error creating order
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Error creating order: ' . (isset($order['error']['description']) ? $order['error']['description'] : 'Unknown error'),
                'response' => $order
            ]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'Invalid plan or billing cycle'
        ]);
    }
    exit;
}

// For POST request (verifying payment)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Get payment details
    $razorpay_payment_id = isset($data['razorpay_payment_id']) ? $data['razorpay_payment_id'] : '';
    $razorpay_order_id = isset($data['razorpay_order_id']) ? $data['razorpay_order_id'] : '';
    $razorpay_signature = isset($data['razorpay_signature']) ? $data['razorpay_signature'] : '';
    
    $plan_id = isset($data['plan_id']) ? $data['plan_id'] : '';
    $billing_cycle = isset($data['billing_cycle']) ? $data['billing_cycle'] : '';
    $amount = isset($data['amount']) ? $data['amount'] : 0;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    
    // For payment verification
    $success = false;
    $error = "Payment failed";
    
    if (!empty($razorpay_payment_id) && !empty($user_id)) {
        try {
            // Generate signature for verification
            $generated_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $razorpay_key_secret);
            
            // Verify signature
            if ($generated_signature == $razorpay_signature) {
                // Verify payment with Razorpay API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key_id . ':' . $razorpay_key_secret);
                $result = curl_exec($ch);
                
                // Check for cURL errors
                if(curl_errno($ch)) {
                    $error = 'cURL Error: ' . curl_error($ch);
                    curl_close($ch);
                    
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'error' => $error
                    ]);
                    exit;
                }
                
                curl_close($ch);
                
                $payment_details = json_decode($result, true);
                
                if ($payment_details && ($payment_details['status'] === 'captured' || $payment_details['status'] === 'authorized')) {
                    // Check if plans table exists
                    $check_plans_table = $conn->query("SHOW TABLES LIKE 'plans'");
                    $plans_table_exists = $check_plans_table->num_rows > 0;
                    
                    // Create subscriptions table if it doesn't exist
                    $conn->query("CREATE TABLE IF NOT EXISTS `subscriptions` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `user_id` int(11) NOT NULL,
                        `plan_id` varchar(50) NOT NULL,
                        `billing_cycle` varchar(20) NOT NULL,
                        `amount` decimal(10,2) NOT NULL,
                        `payment_id` varchar(100) NOT NULL,
                        `payment_date` datetime NOT NULL,
                        `expiry_date` date NOT NULL,
                        `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        KEY `user_id` (`user_id`),
                        KEY `payment_id` (`payment_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                    
                    // Payment successful - save to database
                    $stmt = $conn->prepare("INSERT INTO subscriptions (user_id, plan_id, billing_cycle, amount, payment_id, payment_date, expiry_date) VALUES (?, ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL ? DAY))");
                    
                    $days = ($billing_cycle === 'annual') ? 365 : 30;
                    $stmt->bind_param("issdsi", $user_id, $plan_id, $billing_cycle, $amount, $razorpay_payment_id, $days);
                    
                    if ($stmt->execute()) {
                        $success = true;
                        $error = "";
                    } else {
                        $error = "Error saving payment details to database: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Payment verification failed: " . (isset($payment_details['error']['description']) ? $payment_details['error']['description'] : 'Unknown error');
                }
            } else {
                $error = "Payment signature verification failed";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'payment_id' => $razorpay_payment_id
    ]);
    exit;
}

// If neither GET nor POST, return error
header('Content-Type: application/json');
echo json_encode([
    'success' => false,
    'error' => 'Invalid request method'
]);
exit;
?>


<!-- Add this right after the opening <body> tag in your pricing.php file -->
<div id="payment-loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Processing payment...</p>
    </div>
</div>

<script>

  
function processPayment(planId, billingCycle) {
    // Check if logged in
    <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'login.php?redirect=pricing.php?plan=' + planId + '&cycle=' + billingCycle;
        return;
    <?php endif; ?>
    
    // Show loading indicator
    document.getElementById('payment-loading').style.display = 'block';
    
    // Send request to create order
    fetch('process_payment.php?plan=' + planId + '&cycle=' + billingCycle)
        .then(response => response.json())
        .then(data => {
            // Hide loading indicator
            document.getElementById('payment-loading').style.display = 'none';
            
            if (data.success) {
                // Launch Razorpay checkout
                const options = {
                    key: data.key_id,
                    amount: data.amount * 100, // Convert to paise
                    currency: 'INR',
                    name: 'IT Sahayata',
                    description: 'IT Support ' + planId.charAt(0).toUpperCase() + planId.slice(1) + ' Plan (' + billingCycle + ')',
                    order_id: data.order_id,
                    handler: function (response) {
                        // On successful payment
                        document.getElementById('payment-loading').style.display = 'block';
                        verifyPayment(response, data.plan_id, data.billing_cycle, data.amount);
                    },
                    prefill: {
                        name: '<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>',
                        email: '<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>',
                        contact: '<?php echo isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : ''; ?>'
                    },
                    theme: {
                        color: '#4e73df'
                    },
                    modal: {
                        ondismiss: function() {
                            console.log('Checkout form closed');
                            document.getElementById('payment-loading').style.display = 'none';
                        }
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response){
                    alert('Payment failed: ' + response.error.description);
                    console.error('Payment failed:', response.error);
                });
                rzp.open();
            } else {
                alert('Error: ' + data.error);
                console.error('Order creation failed:', data);
            }
        })
        .catch(error => {
            // Hide loading indicator
            document.getElementById('payment-loading').style.display = 'none';
            
            console.error('Error:', error);
            alert('Error processing payment. Please try again later.');
        });
}

// Verify payment
function verifyPayment(response, planId, billingCycle, amount) {
    fetch('process_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            plan_id: planId,
            billing_cycle: billingCycle,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading indicator
        document.getElementById('payment-loading').style.display = 'none';
        
        if (data.success) {
            // Payment successful - redirect to success page
            window.location.href = 'payment_success.php?payment_id=' + data.payment_id;
        } else {
            alert('Payment verification failed: ' + data.error);
            console.error('Payment verification failed:', data);
        }
    })
    .catch(error => {
        // Hide loading indicator
        document.getElementById('payment-loading').style.display = 'none';
        
        console.error('Error:', error);
        alert('Error verifying payment. Please contact customer support.');
    });
}
</script>