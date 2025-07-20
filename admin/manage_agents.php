<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}
require '../config/db.php';

// Fetch all agents
$stmt = $pdo->prepare("SELECT * FROM agents");
$stmt->execute();
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch pending agents
$stmt = $pdo->prepare("SELECT * FROM agents WHERE status = 'pending'");
$stmt->execute();
$pending_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch approved agents
$stmt = $pdo->prepare("SELECT * FROM agents WHERE status = 'approved'");
$stmt->execute();
$approved_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch rejected agents
$stmt = $pdo->prepare("SELECT * FROM agents WHERE status = 'rejected'");
$stmt->execute();
$rejected_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle success/error messages
if (isset($_GET['success'])) {
    $success_message = htmlspecialchars($_GET['success']);
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '$success_message',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4b0082'
            });
        });
    </script>
    ";
}

if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '$error_message',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ff0000'
            });
        });
    </script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Manage Agents | Admin Panel</title>
    <meta name="description" content="Manage all agents, approve pending applications, and monitor agent performance in IT Sahayta admin panel.">
    <?php include "../views/assets.php"?>
    <style>
        .agent-management {
            padding: 2rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .management-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }
        
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .page-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 1.1rem;
        }
        
        .pending { color: #f39c12; }
        .approved { color: #27ae60; }
        .rejected { color: #e74c3c; }
        .total { color: #3498db; }
        
        .management-tabs {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .tab-navigation {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .tab-btn {
            flex: 1;
            padding: 1.5rem;
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tab-btn.active {
            background: white;
            color: #667eea;
        }
        
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #667eea;
        }
        
        .tab-content {
            display: none;
            padding: 2rem;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .search-filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            min-width: 150px;
        }
        
        .search-btn {
            padding: 0.75rem 2rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .search-btn:hover {
            background: #5a6fd8;
        }
        
        .agents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }
        
        .agent-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .agent-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .agent-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .agent-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 1rem;
        }
        
        .agent-info h3 {
            margin: 0 0 0.25rem 0;
            font-size: 1.2rem;
            color: #333;
        }
        
        .agent-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-approved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .agent-details {
            margin: 1rem 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            padding: 0.25rem 0;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        
        .detail-value {
            color: #6c757d;
        }
        
        .agent-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background: #218838;
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
        }
        
        .btn-reject:hover {
            background: #c82333;
        }
        
        .btn-edit {
            background: #007bff;
            color: white;
        }
        
        .btn-edit:hover {
            background: #0056b3;
        }
        
        .btn-delete {
            background: #6c757d;
            color: white;
        }
        
        .btn-delete:hover {
            background: #545b62;
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .btn-view:hover {
            background: #138496;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .rejection-form {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .rejection-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .agents-grid {
                grid-template-columns: 1fr;
            }
            
            .search-filter-bar {
                flex-direction: column;
            }
            
            .tab-navigation {
                flex-wrap: wrap;
            }
            
            .tab-btn {
                flex: none;
                min-width: 50%;
            }
        }
    </style>
</head>
<body>

<?php include '../views/header.php'; ?>

<section class="agent-management">
    <div class="management-container">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-up">
            <h1><i class="fas fa-users-cog"></i> Agent Management</h1>
            <p>Manage all agents, approve applications, and monitor performance</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-users"></i></div>
                <div class="stat-number"><?php echo count($agents); ?></div>
                <div class="stat-label">Total Agents</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
                <div class="stat-number"><?php echo count($pending_agents); ?></div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon approved"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number"><?php echo count($approved_agents); ?></div>
                <div class="stat-label">Approved Agents</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rejected"><i class="fas fa-times-circle"></i></div>
                <div class="stat-number"><?php echo count($rejected_agents); ?></div>
                <div class="stat-label">Rejected Applications</div>
            </div>
        </div>

        <!-- Management Tabs -->
        <div class="management-tabs" data-aos="fade-up" data-aos-delay="200">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="openAgentTab(event, 'all-agents')">All Agents</button>
                <button class="tab-btn" onclick="openAgentTab(event, 'pending-agents')">Pending Approval</button>
                <button class="tab-btn" onclick="openAgentTab(event, 'approved-agents')">Approved Agents</button>
                <button class="tab-btn" onclick="openAgentTab(event, 'rejected-agents')">Rejected Applications</button>
            </div>

            <!-- All Agents Tab -->
            <div id="all-agents" class="tab-content active">
                <div class="search-filter-bar">
                    <input type="text" class="search-input" placeholder="Search agents by name, email, or phone..." id="search-all">
                    <select class="filter-select" id="filter-all">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <button class="search-btn" onclick="filterAgents('all')">Filter</button>
                </div>

                <div class="agents-grid" id="all-agents-grid">
                    <?php if (empty($agents)): ?>
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>No Agents Found</h3>
                            <p>No agents have been registered yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($agents as $agent): ?>
                            <div class="agent-card" data-status="<?php echo $agent['status']; ?>" data-search="<?php echo strtolower($agent['name'] . ' ' . $agent['email'] . ' ' . $agent['phone_number']); ?>">
                                <div class="status-badge status-<?php echo $agent['status']; ?>">
                                    <?php echo ucfirst($agent['status']); ?>
                                </div>
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <?php echo strtoupper(substr($agent['name'], 0, 2)); ?>
                                    </div>
                                    <div class="agent-info">
                                        <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($agent['email']); ?></p>
                                    </div>
                                </div>
                                <div class="agent-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['phone_number']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['address'] ?? 'Not provided'); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Joined:</span>
                                        <span class="detail-value"><?php echo date('M d, Y', strtotime($agent['created_at'])); ?></span>
                                    </div>
                                    <?php if ($agent['status'] == 'pending'): ?>
                                        <div class="detail-row">
                                            <span class="detail-label">ID Type:</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($agent['govt_id_type']); ?></span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">ID Number:</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($agent['govt_id_number']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="agent-actions">
                                    <?php if ($agent['status'] == 'pending'): ?>
                                        <form action="/controllers/AdminController.php?action=approve_agent" method="POST" style="display:inline;">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <button type="submit" class="action-btn btn-approve">Approve</button>
                                        </form>
                                        <button class="action-btn btn-reject" onclick="showRejectForm(<?php echo $agent['id']; ?>)">Reject</button>
                                        <a href="<?php echo htmlspecialchars($agent['govt_id_front']); ?>" target="_blank" class="action-btn btn-view">View ID Front</a>
                                        <a href="<?php echo htmlspecialchars($agent['govt_id_back']); ?>" target="_blank" class="action-btn btn-view">View ID Back</a>
                                    <?php else: ?>
                                        <a href="/views/edit_agent.php?id=<?php echo $agent['id']; ?>" class="action-btn btn-edit">Edit</a>
                                        <form action="/controllers/AdminController.php?action=delete_agent" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                            <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                            <button type="submit" class="action-btn btn-delete">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <div class="rejection-form" id="reject-form-<?php echo $agent['id']; ?>">
                                    <form action="/controllers/AdminController.php?action=reject_agent" method="POST">
                                        <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                        <input type="text" name="reason" class="rejection-input" placeholder="Reason for rejection" required>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button type="submit" class="action-btn btn-reject">Confirm Reject</button>
                                            <button type="button" class="action-btn btn-edit" onclick="hideRejectForm(<?php echo $agent['id']; ?>)">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pending Agents Tab -->
            <div id="pending-agents" class="tab-content">
                <div class="search-filter-bar">
                    <input type="text" class="search-input" placeholder="Search pending agents..." id="search-pending">
                    <button class="search-btn" onclick="filterAgents('pending')">Search</button>
                </div>

                <div class="agents-grid" id="pending-agents-grid">
                    <?php if (empty($pending_agents)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clock"></i>
                            <h3>No Pending Applications</h3>
                            <p>All agent applications have been processed.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($pending_agents as $agent): ?>
                            <div class="agent-card" data-search="<?php echo strtolower($agent['name'] . ' ' . $agent['email'] . ' ' . $agent['phone_number']); ?>">
                                <div class="status-badge status-pending">Pending</div>
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <?php echo strtoupper(substr($agent['name'], 0, 2)); ?>
                                    </div>
                                    <div class="agent-info">
                                        <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($agent['email']); ?></p>
                                    </div>
                                </div>
                                <div class="agent-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['phone_number']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['address']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">ID Type:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['govt_id_type']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">ID Number:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['govt_id_number']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Applied:</span>
                                        <span class="detail-value"><?php echo date('M d, Y', strtotime($agent['created_at'])); ?></span>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <form action="/controllers/AdminController.php?action=approve_agent" method="POST" style="display:inline;">
                                        <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                        <button type="submit" class="action-btn btn-approve">Approve</button>
                                    </form>
                                    <button class="action-btn btn-reject" onclick="showRejectForm(<?php echo $agent['id']; ?>)">Reject</button>
                                    <a href="<?php echo htmlspecialchars($agent['govt_id_front']); ?>" target="_blank" class="action-btn btn-view">View ID Front</a>
                                    <a href="<?php echo htmlspecialchars($agent['govt_id_back']); ?>" target="_blank" class="action-btn btn-view">View ID Back</a>
                                </div>
                                <div class="rejection-form" id="reject-form-<?php echo $agent['id']; ?>">
                                    <form action="/controllers/AdminController.php?action=reject_agent" method="POST">
                                        <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                        <input type="text" name="reason" class="rejection-input" placeholder="Reason for rejection" required>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button type="submit" class="action-btn btn-reject">Confirm Reject</button>
                                            <button type="button" class="action-btn btn-edit" onclick="hideRejectForm(<?php echo $agent['id']; ?>)">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Approved Agents Tab -->
            <div id="approved-agents" class="tab-content">
                <div class="search-filter-bar">
                    <input type="text" class="search-input" placeholder="Search approved agents..." id="search-approved">
                    <button class="search-btn" onclick="filterAgents('approved')">Search</button>
                </div>

                <div class="agents-grid" id="approved-agents-grid">
                    <?php if (empty($approved_agents)): ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h3>No Approved Agents</h3>
                            <p>No agents have been approved yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($approved_agents as $agent): ?>
                            <div class="agent-card" data-search="<?php echo strtolower($agent['name'] . ' ' . $agent['email'] . ' ' . $agent['phone_number']); ?>">
                                <div class="status-badge status-approved">Approved</div>
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <?php echo strtoupper(substr($agent['name'], 0, 2)); ?>
                                    </div>
                                    <div class="agent-info">
                                        <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($agent['email']); ?></p>
                                    </div>
                                </div>
                                <div class="agent-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['phone_number']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['address'] ?? 'Not provided'); ?></span>
                                    </div>
                                    <!-- <div class="detail-row">
                                        <span class="detail-label">Approved:</span>
                                        <span class="detail-value"><?php echo date('M d, Y', strtotime($agent['updated_at'])); ?></span>
                                    </div> -->
                                </div>
                                <div class="agent-actions">
                                    <a href="/views/edit_agent.php?id=<?php echo $agent['id']; ?>" class="action-btn btn-edit">Edit</a>
                                    <form action="/controllers/AdminController.php?action=delete_agent" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                        <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                        <button type="submit" class="action-btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Rejected Agents Tab -->
            <div id="rejected-agents" class="tab-content">
                <div class="search-filter-bar">
                    <input type="text" class="search-input" placeholder="Search rejected applications..." id="search-rejected">
                    <button class="search-btn" onclick="filterAgents('rejected')">Search</button>
                </div>

                <div class="agents-grid" id="rejected-agents-grid">
                    <?php if (empty($rejected_agents)): ?>
                        <div class="empty-state">
                            <i class="fas fa-times-circle"></i>
                            <h3>No Rejected Applications</h3>
                            <p>No agent applications have been rejected.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($rejected_agents as $agent): ?>
                            <div class="agent-card" data-search="<?php echo strtolower($agent['name'] . ' ' . $agent['email'] . ' ' . $agent['phone_number']); ?>">
                                <div class="status-badge status-rejected">Rejected</div>
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <?php echo strtoupper(substr($agent['name'], 0, 2)); ?>
                                    </div>
                                    <div class="agent-info">
                                        <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($agent['email']); ?></p>
                                    </div>
                                </div>
                                <div class="agent-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['phone_number']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($agent['address']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Rejected:</span>
                                        <span class="detail-value"><?php echo date('M d, Y', strtotime($agent['updated_at'])); ?></span>
                                    </div>
                                    <?php if (!empty($agent['rejection_reason'])): ?>
                                        <div class="detail-row">
                                            <span class="detail-label">Reason:</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($agent['rejection_reason']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="agent-actions">
                                    <form action="/controllers/AdminController.php?action=delete_agent" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to permanently delete this agent?');">
                                        <input type="hidden" name="agent_id" value="<?php echo $agent['id']; ?>">
                                        <button type="submit" class="action-btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Tab functionality
function openAgentTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}

// Filter functionality
function filterAgents(type) {
    const searchInput = document.getElementById(`search-${type}`);
    const filterSelect = document.getElementById(`filter-${type}`);
    const grid = document.getElementById(`${type}-agents-grid`);
    const cards = grid.getElementsByClassName('agent-card');
    
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    const statusFilter = filterSelect ? filterSelect.value : '';
    
    for (let card of cards) {
        const searchData = card.getAttribute('data-search') || '';
        const statusData = card.getAttribute('data-status') || '';
        
        const matchesSearch = searchData.includes(searchTerm);
        const matchesStatus = !statusFilter || statusData === statusFilter;
        
        if (matchesSearch && matchesStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    }
}

// Rejection form functionality
function showRejectForm(agentId) {
    document.getElementById(`reject-form-${agentId}`).style.display = 'block';
}

function hideRejectForm(agentId) {
    document.getElementById(`reject-form-${agentId}`).style.display = 'none';
}

// Real-time search
document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const type = this.id.replace('search-', '');
            filterAgents(type);
        });
    });
    
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const type = this.id.replace('filter-', '');
            filterAgents(type);
        });
    });
});
</script>

<?php include '../views/footer.php'; ?>
</body>
</html>