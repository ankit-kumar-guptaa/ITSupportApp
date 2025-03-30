<?php
// Admin authentication check

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/email.php';


// Fetch all bookings
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY booking_date DESC, booking_time DESC");
$bookings = $stmt->fetchAll();

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bookingId = $_POST['booking_id'];
    $newStatus = $_POST['new_status'];
    
    // Get current booking details
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE booking_id = ?");
    $stmt->execute([$bookingId]);
    $booking = $stmt->fetch();
    
    // Update status
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->execute([$newStatus, $bookingId]);
    
    // Send email notification if status changed
    if ($booking['status'] !== $newStatus) {
        $customerEmail = !empty($booking['customer_email']) ? $booking['customer_email'] : null;
        
        if ($customerEmail) {
            $subject = "Your Booking #{$bookingId} Status Updated";
            
            $body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #4361ee; color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; }
                        .status-update { 
                            padding: 15px; 
                            border-radius: 8px; 
                            margin: 20px 0;
                            text-align: center;
                            font-weight: bold;
                        }
                        .status-confirmed { background: #e0e7ff; color: #4361ee; }
                        .status-completed { background: #d1fae5; color: #10b981; }
                        .status-cancelled { background: #fee2e2; color: #ef4444; }
                        .details { margin: 20px 0; }
                        .detail-row { display: flex; margin-bottom: 10px; }
                        .detail-label { font-weight: bold; width: 150px; }
                        .footer { margin-top: 20px; font-size: 0.9em; color: #666; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Booking Status Update</h2>
                        </div>
                        <div class='content'>
                            <p>Hello " . htmlspecialchars($booking['customer_name'] ?: 'Customer') . ",</p>
                            
                            <div class='status-update status-{$newStatus}'>
                                Your booking status has been updated to: " . ucfirst($newStatus) . "
                            </div>
                            
                            <div class='details'>
                                <div class='detail-row'>
                                    <div class='detail-label'>Booking ID:</div>
                                    <div>{$bookingId}</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Service:</div>
                                    <div>" . htmlspecialchars($booking['service_name']) . "</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Date:</div>
                                    <div>" . date('D, d M Y', strtotime($booking['booking_date'])) . "</div>
                                </div>
                                <div class='detail-row'>
                                    <div class='detail-label'>Time Slot:</div>
                                    <div>" . htmlspecialchars($booking['booking_time']) . "</div>
                                </div>
                            </div>";
            
            if ($newStatus === 'completed') {
                $body .= "<p>Thank you for using our services. We hope we met your expectations.</p>";
            } elseif ($newStatus === 'cancelled') {
                $body .= "<p>We're sorry for any inconvenience caused. Please contact us if you need any assistance.</p>";
            }
            
            $body .= "
                            <div class='footer'>
                                <p>IT Support Team</p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ";
            
            // Send email
            sendEmail($customerEmail, $subject, $body);
        }
    }
    
    // Refresh the page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Bookings | IT Sahayta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --secondary: #3f37c9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }
        
        .admin-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .booking-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        
        .booking-card.completed {
            border-left-color: var(--success);
        }
        
        .booking-card.cancelled {
            border-left-color: var(--danger);
        }
        
        .badge-confirmed {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .badge-completed {
            background-color: #d1fae5;
            color: var(--success);
        }
        
        .badge-cancelled {
            background-color: #fee2e2;
            color: var(--danger);
        }
        
        .service-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            margin-right: 1rem;
        }
        
        .hardware-icon {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }
        
        .software-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        
        .network-icon {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }
        
        .virus-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .data-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .other-icon {
            background: linear-gradient(135deg, #64748b, #475569);
        }
        
        .action-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .action-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin: 0.25rem;
        }
        
        .action-dropdown .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .status-select {
            border: none;
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-weight: 500;
            cursor: pointer;
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Admin Dashboard</h4>
                <div>
                    <a href="/views/logout.php" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manage Bookings</h2>
            <div>
                <a href="/admin/dashboard.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
        
        <!-- Booking Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Bookings List -->
        <div class="row">
            <?php if (empty($bookings)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No bookings found.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php
                    // Get service icon class
                    $iconClass = 'other-icon';
                    $icon = 'fas fa-question-circle';
                    
                    switch ($booking['service_type']) {
                        case 'hardware':
                            $iconClass = 'hardware-icon';
                            $icon = 'fas fa-desktop';
                            break;
                        case 'software':
                            $iconClass = 'software-icon';
                            $icon = 'fas fa-code';
                            break;
                        case 'network':
                            $iconClass = 'network-icon';
                            $icon = 'fas fa-wifi';
                            break;
                        case 'virus':
                            $iconClass = 'virus-icon';
                            $icon = 'fas fa-shield-virus';
                            break;
                        case 'data':
                            $iconClass = 'data-icon';
                            $icon = 'fas fa-database';
                            break;
                    }
                    
                    // Get status badge class
                    $statusClass = 'badge-confirmed';
                    if ($booking['status'] === 'completed') {
                        $statusClass = 'badge-completed';
                    } elseif ($booking['status'] === 'cancelled') {
                        $statusClass = 'badge-cancelled';
                    }
                    ?>
                    <div class="col-md-6">
                        <div class="booking-card <?php echo $booking['status']; ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="service-icon <?php echo $iconClass; ?>">
                                            <i class="<?php echo $icon; ?>"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0"><?php echo htmlspecialchars($booking['service_name']); ?></h5>
                                            <small class="text-muted">Booking ID: <?php echo htmlspecialchars($booking['booking_id']); ?></small>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex mb-2">
                                        <div style="width: 120px;"><strong>Date:</strong></div>
                                        <div><?php echo date('D, d M Y', strtotime($booking['booking_date'])); ?></div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div style="width: 120px;"><strong>Time Slot:</strong></div>
                                        <div><?php echo htmlspecialchars($booking['booking_time']); ?></div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div style="width: 120px;"><strong>Customer:</strong></div>
                                        <div>
                                            <?php 
                                            $customerName = !empty($booking['customer_name']) ? $booking['customer_name'] : 'User';
                                            $customerEmail = !empty($booking['customer_email']) ? $booking['customer_email'] : '';
                                            echo htmlspecialchars($customerName);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div style="width: 120px;"><strong>Contact:</strong></div>
                                        <div><?php echo htmlspecialchars($booking['contact_number']); ?></div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div style="width: 120px;"><strong>Amount:</strong></div>
                                        <div><?php echo htmlspecialchars($booking['price']); ?></div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div><strong>Problem Description:</strong></div>
                                    <div class="text-muted"><?php echo nl2br(htmlspecialchars($booking['problem_description'])); ?></div>
                                </div>
                                
                                <?php if (!empty($booking['special_notes'])): ?>
                                <div class="mb-3">
                                    <div><strong>Special Notes:</strong></div>
                                    <div class="text-muted"><?php echo nl2br(htmlspecialchars($booking['special_notes'])); ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Booked on <?php echo date('d M Y h:i A', strtotime($booking['created_at'])); ?>
                                    </small>
                                    
                                    <div class="action-dropdown dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form method="POST" class="dropdown-item p-0">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                                    <select name="new_status" class="status-select" onchange="this.form.submit()">
                                                        <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                        <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                        <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="mailto:<?php echo htmlspecialchars($customerEmail); ?>?subject=Regarding Your Booking <?php echo htmlspecialchars($booking['booking_id']); ?>">
                                                    <i class="fas fa-envelope me-2"></i> Email Customer
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="tel:<?php echo htmlspecialchars($booking['contact_number']); ?>">
                                                    <i class="fas fa-phone me-2"></i> Call Customer
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>