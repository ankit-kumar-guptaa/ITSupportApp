<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

// Fetch user details
$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch reported issues with agent details
$stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone, a.email as agent_email 
                       FROM issues i 
                       LEFT JOIN agents a ON i.agent_id = a.id 
                       WHERE i.user_id = ?
                       ORDER BY i.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get issue count by status
$stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM issues WHERE user_id = ? GROUP BY status");
$stmt->execute([$_SESSION['user_id']]);
$status_counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$status_data = [
    'Pending' => 0,
    'In Progress' => 0,
    'Resolved' => 0,
    'Cancelled' => 0
];

foreach ($status_counts as $count) {
    $status_data[$count['status']] = $count['count'];
}

// Get total issues
$total_issues = array_sum($status_data);

// Calculate percentage for each status
$status_percentage = [];
foreach ($status_data as $status => $count) {
    $status_percentage[$status] = $total_issues > 0 ? round(($count / $total_issues) * 100) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Your Reported Issues | Track Your IT Support Requests</title>
    <meta name="description" content="View and manage all your reported IT issues at IT Sahayta. Track status, communicate with agents, and provide feedback on resolved issues.">
    <?php include "assets.php"?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --secondary: #3f37c9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
        }
        
        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            position: relative;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-pending .stat-icon {
            background: var(--warning);
        }
        
        .stat-progress .stat-icon {
            background: var(--info);
        }
        
        .stat-resolved .stat-icon {
            background: var(--success);
        }
        
        .stat-total .stat-icon {
            background: var(--primary);
        }
        
        .stat-title {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .stat-pending .stat-value {
            color: var(--warning);
        }
        
        .stat-progress .stat-value {
            color: var(--info);
        }
        
        .stat-resolved .stat-value {
            color: var(--success);
        }
        
        .stat-total .stat-value {
            color: var(--primary);
        }
        
        .stat-description {
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .progress-bar {
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-top: 0.75rem;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
        }
        
        .stat-pending .progress-fill {
            background: var(--warning);
        }
        
        .stat-progress .progress-fill {
            background: var(--info);
        }
        
        .stat-resolved .progress-fill {
            background: var(--success);
        }
        
        .stat-total .progress-fill {
            background: var(--primary);
        }
        
        .issues-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .issues-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .issues-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .issues-actions {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline {
            background: white;
            color: var(--primary);
            border: 1px solid #e2e8f0;
        }
        
        .btn-outline:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .filter-dropdown {
            position: relative;
        }
        
        .filter-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 10;
            padding: 0.75rem;
            margin-top: 0.5rem;
            display: none;
        }
        
        .filter-menu.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        .filter-option {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filter-option:hover {
            background: var(--primary-light);
        }
        
        .filter-option.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 500;
        }
        
        .issues-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .issues-table th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        
        .issues-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        
        .issues-table tr:last-child td {
            border-bottom: none;
        }
        
        .issues-table tr {
            transition: all 0.2s ease;
        }
        
        .issues-table tr:hover {
            background: #f8fafc;
        }
        
        .issue-id {
            font-weight: 600;
            color: var(--primary);
        }
        
        .issue-description {
            max-width: 300px;
        }
        
        .issue-media {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .issue-image-preview {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        
        .issue-image-preview:hover {
            transform: scale(1.05);
            border-color: var(--primary);
        }
        
        .file-preview {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .file-preview:hover {
            background: rgba(67, 97, 238, 0.2);
            transform: translateY(-2px);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .status-pending {
            background: #fff7ed;
            color: var(--warning);
        }
        
        .status-progress {
            background: #eff6ff;
            color: var(--info);
        }
        
        .status-resolved {
            background: #ecfdf5;
            color: var(--success);
        }
        
        .status-cancelled {
            background: #fef2f2;
            color: var(--danger);
        }
        
        .agent-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .agent-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .agent-details {
            flex: 1;
        }
        
        .agent-name {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.2rem;
        }
        
        .agent-contact {
            font-size: 0.85rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .agent-contact a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .agent-contact a:hover {
            text-decoration: underline;
        }
        
        .feedback-container {
            margin-top: 0.5rem;
        }
        
        .rating-stars {
            display: flex;
            gap: 0.2rem;
            margin-bottom: 0.3rem;
        }
        
        .star {
            color: #f59e0b;
            font-size: 1rem;
        }
        
        .feedback-text {
            font-size: 0.85rem;
            color: var(--gray);
            font-style: italic;
        }
        
        .feedback-form {
            margin-top: 0.75rem;
        }
        
        .form-group {
            margin-bottom: 0.75rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            font-size: 0.85rem;
            color: var(--dark);
            font-weight: 500;
        }
        
        .star-rating {
            display: flex;
            gap: 0.3rem;
            margin-bottom: 0.5rem;
        }
        
        .star-rating input {
            display: none;
        }
        
        .star-rating label {
            cursor: pointer;
            color: #e2e8f0;
            font-size: 1.5rem;
            transition: all 0.2s ease;
        }
        
        .star-rating input:checked ~ label {
            color: #f59e0b;
        }
        
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f59e0b;
        }
        
        .star-rating input:checked + label:hover,
        .star-rating input:checked ~ label:hover,
        .star-rating label:hover ~ input:checked ~ label,
        .star-rating input:checked ~ label:hover ~ label {
            color: #f59e0b;
        }
        
        textarea.form-control {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 80px;
            transition: all 0.2s ease;
        }
        
        textarea.form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
        }
        
        .empty-icon {
            font-size: 3rem;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }
        
        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .empty-description {
            color: var(--gray);
            max-width: 400px;
            margin: 0 auto 1.5rem;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-item {
            display: inline-flex;
        }
        
        .page-link {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            background: white;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }
        
        .page-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-light);
        }
        
        .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-item.disabled .page-link {
            color: var(--gray);
            pointer-events: none;
            background: #f8fafc;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }
        
        .modal.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: zoomIn 0.3s ease;
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .modal-close:hover {
            color: var(--danger);
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }
        
        .image-preview-modal .modal-content {
            max-width: 800px;
        }
        
        .image-preview-container {
            text-align: center;
        }
        
        .image-preview-container img {
            max-width: 100%;
            max-height: 70vh;
            border-radius: 8px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @media (max-width: 991.98px) {
            .dashboard-stats {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .issues-table {
                display: block;
                overflow-x: auto;
            }
        }
        
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .dashboard-stats {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1rem;
            }
            
            .stat-card {
                padding: 1.25rem;
            }
            
            .stat-value {
                font-size: 2rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }
            
            .issues-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .issues-actions {
                width: 100%;
                justify-content: space-between;
            }
        }
        
        @media (max-width: 575.98px) {
            .dashboard-stats {
                grid-template-columns: 1fr 1fr;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Your Reported Issues</h1>
            <p class="page-subtitle">Track and manage all your IT support requests in one place. View status updates, communicate with agents, and provide feedback on resolved issues.</p>
        </div>
    </div>
    
    <main class="container">
        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <div class="stat-card stat-pending">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Pending</div>
                <div class="stat-value"><?php echo $status_data['Pending']; ?></div>
                <div class="stat-description">Awaiting assignment</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $status_percentage['Pending']; ?>%"></div>
                </div>
            </div>
            
            <div class="stat-card stat-progress">
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-title">In Progress</div>
                <div class="stat-value"><?php echo $status_data['In Progress']; ?></div>
                <div class="stat-description">Being worked on</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $status_percentage['In Progress']; ?>%"></div>
                </div>
            </div>
            
            <div class="stat-card stat-resolved">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Resolved</div>
                <div class="stat-value"><?php echo $status_data['Resolved']; ?></div>
                <div class="stat-description">Successfully fixed</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $status_percentage['Resolved']; ?>%"></div>
                </div>
            </div>
            
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-title">Total Issues</div>
                <div class="stat-value"><?php echo $total_issues; ?></div>
                <div class="stat-description">All time</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 100%"></div>
                </div>
            </div>
        </div>
        
        <!-- Issues List -->
        <div class="issues-container">
            <div class="issues-header">
                <h2 class="issues-title">All Reported Issues</h2>
                <div class="issues-actions">
                    <a href="/views/report_issue.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Report New Issue
                    </a>
                    <div class="filter-dropdown">
                        <button class="btn btn-outline" id="filterBtn">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <div class="filter-menu" id="filterMenu">
                            <div class="filter-option active" data-filter="all">
                                <i class="fas fa-list"></i> All Issues
                            </div>
                            <div class="filter-option" data-filter="pending">
                                <i class="fas fa-clock"></i> Pending
                            </div>
                            <div class="filter-option" data-filter="progress">
                                <i class="fas fa-spinner"></i> In Progress
                            </div>
                            <div class="filter-option" data-filter="resolved">
                                <i class="fas fa-check-circle"></i> Resolved
                            </div>
                            <div class="filter-option" data-filter="cancelled">
                                <i class="fas fa-times-circle"></i> Cancelled
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (empty($issues)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <h3 class="empty-title">No issues reported yet</h3>
                    <p class="empty-description">You haven't reported any IT issues yet. Click the button below to report your first issue.</p>
                    <a href="/views/report_issue.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Report New Issue
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="issues-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Agent</th>
                                <th>Created</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($issues as $issue): ?>
                                <tr class="issue-row" data-status="<?php echo strtolower(str_replace(' ', '-', $issue['status'])); ?>">
                                    <td>
                                        <span class="issue-id">#<?php echo $issue['id']; ?></span>
                                    </td>
                                    <td>
                                        <div class="issue-description">
                                            <?php echo htmlspecialchars($issue['description']); ?>
                                        </div>
                                        
                                        <?php if (!empty($issue['image_path'])): ?>
                                            <div class="issue-media">
                                                <img src="<?php echo $issue['image_path']; ?>" alt="Issue Image" class="issue-image-preview" onclick="openImagePreview('<?php echo $issue['image_path']; ?>')">
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($issue['attached_file'])): ?>
                                            <div class="issue-media">
                                                <a href="<?php echo $issue['attached_file']; ?>" target="_blank" class="file-preview">
                                                    <i class="fas fa-file-pdf"></i> View Attachment
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($issue['category']); ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $issue['status'])); ?>">
                                            <?php if ($issue['status'] == 'Pending'): ?>
                                                <i class="fas fa-clock"></i>
                                            <?php elseif ($issue['status'] == 'In Progress'): ?>
                                                <i class="fas fa-spinner fa-spin"></i>
                                            <?php elseif ($issue['status'] == 'Resolved'): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php elseif ($issue['status'] == 'Cancelled'): ?>
                                                <i class="fas fa-times-circle"></i>
                                            <?php endif; ?>
                                            <?php echo $issue['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($issue['agent_id']): ?>
                                            <div class="agent-info">
                                                <div class="agent-avatar">
                                                    <?php echo strtoupper(substr($issue['agent_name'], 0, 1)); ?>
                                                </div>
                                                <div class="agent-details">
                                                    <div class="agent-name"><?php echo htmlspecialchars($issue['agent_name']); ?></div>
                                                    <div class="agent-contact">
                                                        <a href="tel:<?php echo $issue['agent_phone']; ?>">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                        <a href="mailto:<?php echo $issue['agent_email']; ?>">
                                                            <i class="fas fa-envelope"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Not assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $created_date = new DateTime($issue['created_at']);
                                            $now = new DateTime();
                                            $interval = $created_date->diff($now);
                                            
                                            if ($interval->days == 0) {
                                                if ($interval->h == 0) {
                                                    echo $interval->i . ' minutes ago';
                                                } else {
                                                    echo $interval->h . ' hours ago';
                                                }
                                            } elseif ($interval->days == 1) {
                                                echo 'Yesterday';
                                            } else {
                                                echo $created_date->format('M d, Y');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($issue['status'] == 'Resolved'): ?>
                                            <?php if (isset($issue['rating']) && $issue['rating']): ?>
                                                <div class="feedback-container">
                                                    <div class="rating-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <span class="star">
                                                                <?php if ($i <= $issue['rating']): ?>
                                                                    <i class="fas fa-star"></i>
                                                                <?php else: ?>
                                                                    <i class="far fa-star"></i>
                                                                <?php endif; ?>
                                                            </span>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <?php if (isset($issue['feedback']) && $issue['feedback']): ?>
                                                        <div class="feedback-text">
                                                            "<?php echo htmlspecialchars($issue['feedback']); ?>"
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline" onclick="openFeedbackModal(<?php echo $issue['id']; ?>)">
                                                    <i class="fas fa-star"></i> Rate
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Feedback available after resolution.</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Feedback Modal -->
    <div class="modal" id="feedbackModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Rate Your Experience</h3>
                <button class="modal-close" onclick="closeFeedbackModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm" action="/controllers/IssueController.php?action=submit_feedback" method="POST">
                    <input type="hidden" name="issue_id" id="feedbackIssueId">
                    
                    <div class="form-group">
                        <label>How would you rate the support?</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="feedback">Your feedback (optional)</label>
                        <textarea class="form-control" id="feedback" name="feedback" placeholder="Tell us about your experience..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeFeedbackModal()">Cancel</button>
                <button class="btn btn-primary" onclick="submitFeedback()">Submit</button>
            </div>
        </div>
    </div>
    
    <!-- Image Preview Modal -->
    <div class="modal image-preview-modal" id="imagePreviewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Issue Image</h3>
                <button class="modal-close" onclick="closeImagePreview()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="image-preview-container">
                    <img id="previewImage" src="" alt="Issue Image">
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Filter functionality
        const filterBtn = document.getElementById('filterBtn');
        const filterMenu = document.getElementById('filterMenu');
        const filterOptions = document.querySelectorAll('.filter-option');
        const issueRows = document.querySelectorAll('.issue-row');
        
        filterBtn.addEventListener('click', function() {
            filterMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', function(event) {
            if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.remove('show');
            }
        });
        
        filterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                filterOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                issueRows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        const status = row.getAttribute('data-status');
                        row.style.display = status === filter ? '' : 'none';
                    }
                });
                
                filterMenu.classList.remove('show');
            });
        });
        
        // Feedback Modal
        function openFeedbackModal(issueId) {
            document.getElementById('feedbackIssueId').value = issueId;
            document.getElementById('feedbackModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.remove('show');
            document.body.style.overflow = '';
        }
        
        function submitFeedback() {
            const form = document.getElementById('feedbackForm');
            const rating = form.querySelector('input[name="rating"]:checked');
            
            if (!rating) {
                Swal.fire({
                    icon: 'error',
                    title: 'Rating Required',
                    text: 'Please select a rating before submitting.',
                    confirmButtonColor: '#4361ee'
                });
                return;
            }
            
            // Submit the form using AJAX to prevent page reload
            const formData = new FormData(form);
            
            fetch('/controllers/UserController.php?action=submit_feedback', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .catch(error => {
                console.error('Error:', error);
                return { success: false, message: 'Network error' };
            })
            .then(data => {
                if (data && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You!',
                        text: 'Your feedback has been submitted successfully.',
                        confirmButtonColor: '#4361ee'
                    }).then(() => {
                        // Reload the page to show the updated feedback
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data && data.message ? data.message : 'Something went wrong. Please try again.',
                        confirmButtonColor: '#4361ee'
                    });
                }
            });
            
            // Close the modal
            closeFeedbackModal();
        }
        
        // Image Preview
        function openImagePreview(imageSrc) {
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('imagePreviewModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImagePreview() {
            document.getElementById('imagePreviewModal').classList.remove('show');
            document.body.style.overflow = '';
        }
    </script>
</body>
</html>