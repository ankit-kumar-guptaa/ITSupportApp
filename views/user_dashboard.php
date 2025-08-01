<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
require '../config/db.php';

// Fetch user details
$stmt = $pdo->prepare("SELECT id, name, email, phone_number, address, password, role, is_verified FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    // If user not found, redirect to login
    session_unset();
    session_destroy();
    header("Location: /views/login.php?error=User not found");
    exit;
}

// Fetch total reported issues
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM issues WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_issues = $stmt->fetch()['total'];

// Fetch reported issues with agent details
$stmt = $pdo->prepare("SELECT i.*, a.name as agent_name, a.phone_number as agent_phone 
                       FROM issues i 
                       LEFT JOIN agents a ON i.agent_id = a.id 
                       WHERE i.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$reported_issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - User Dashboard | Manage Your IT Support</title>
    <meta name="description" content="Access your user dashboard at IT Sahayta to manage your profile, report issues, and track your IT support requests.">
    <?php include "assets.php"?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #60a5fa;
            --secondary: #10b981;
            --secondary-light: #34d399;
            --accent: #8b5cf6;
            --warning: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            --info: #06b6d4;
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --white: #ffffff;
            --black: #000000;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-2xl: 2rem;
            --radius-full: 9999px;
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, #fafbff 100%);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
            font-feature-settings: 'kern' 1, 'liga' 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Animated Background Particles */
        .crad-bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
            opacity: 0.6;
        }

        .crad-particle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
            animation: cradFloatParticle 15s infinite linear;
        }

        .crad-particle:nth-child(1) {
            width: 20px;
            height: 20px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .crad-particle:nth-child(2) {
            width: 30px;
            height: 30px;
            top: 50%;
            right: 20%;
            animation-delay: 5s;
        }

        .crad-particle:nth-child(3) {
            width: 15px;
            height: 15px;
            bottom: 30%;
            left: 30%;
            animation-delay: 10s;
        }

        .crad-particle:nth-child(4) {
            width: 25px;
            height: 25px;
            top: 80%;
            right: 10%;
            animation-delay: 2s;
        }

        .crad-particle:nth-child(5) {
            width: 18px;
            height: 18px;
            top: 10%;
            right: 50%;
            animation-delay: 7s;
        }

        @keyframes cradFloatParticle {
            0% {
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.7;
            }
            33% {
                transform: translateY(-30px) rotate(120deg) scale(1.1);
                opacity: 1;
            }
            66% {
                transform: translateY(15px) rotate(240deg) scale(0.9);
                opacity: 0.8;
            }
            100% {
                transform: translateY(0px) rotate(360deg) scale(1);
                opacity: 0.7;
            }
        }

        /* Main Section */
        .crad-dashboard-section {
            padding: 2rem 0;
            min-height: 100vh;
        }

        .crad-dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Enhanced Dashboard Header */
        .crad-dashboard-header {
            background: linear-gradient(135deg, var(--white) 0%, #fefefe 100%);
            border-radius: var(--radius-2xl);
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .crad-dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.02), rgba(139, 92, 246, 0.02));
            z-index: 1;
        }

        .crad-dashboard-header:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-2xl);
        }

        .crad-user-welcome {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .crad-user-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            border: 4px solid var(--white);
            position: relative;
            transition: var(--transition);
            animation: cradAvatarGlow 4s ease-in-out infinite;
        }

        @keyframes cradAvatarGlow {
            0%, 100% {
                box-shadow: var(--shadow-lg), 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
            50% {
                box-shadow: var(--shadow-xl), 0 0 0 20px rgba(59, 130, 246, 0.1);
            }
        }

        .crad-user-avatar:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .crad-user-avatar i {
            font-size: 2.5rem;
            color: var(--white);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .crad-welcome-text h2 {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .crad-user-role {
            display: flex;
            align-items: center;
            color: var(--gray-600);
            font-size: 1.125rem;
            font-weight: 500;
        }

        .crad-user-role i {
            margin-right: 0.75rem;
            color: var(--primary);
            font-size: 1.25rem;
        }

        .crad-dashboard-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .crad-action-button {
            display: inline-flex;
            align-items: center;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border-radius: var(--radius-full);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .crad-action-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .crad-action-button:hover::before {
            left: 100%;
        }

        .crad-action-button:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .crad-action-button i {
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        /* Enhanced Notifications */
        .crad-notification-container {
            margin-bottom: 2rem;
        }

        .crad-notification {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-xl);
            margin-bottom: 1rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            animation: cradSlideIn 0.5s ease-out;
        }

        @keyframes cradSlideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .crad-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .crad-notification.success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .crad-notification.success::before {
            background: var(--success);
        }

        .crad-notification.error {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .crad-notification.error::before {
            background: var(--danger);
        }

        .crad-notification:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .crad-notification i {
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .crad-notification p {
            flex: 1;
            margin: 0;
            font-weight: 500;
        }

        .crad-close-notification {
            background: rgba(0, 0, 0, 0.1);
            border: none;
            color: currentColor;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius);
            transition: var(--transition-fast);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .crad-close-notification:hover {
            background: rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        /* Enhanced Stats Cards */
        .crad-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .crad-stat-card {
            background: linear-gradient(135deg, var(--white) 0%, #fefefe 100%);
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .crad-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .crad-stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .crad-stat-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: var(--transition);
            position: relative;
        }

        .crad-stat-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: var(--radius-lg);
            opacity: 0.1;
            transition: var(--transition);
        }

        .crad-stat-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .crad-stat-icon.total {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: var(--primary);
        }

        .crad-stat-icon.pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: var(--warning);
        }

        .crad-stat-icon.progress {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: var(--success);
        }

        .crad-stat-icon.resolved {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--accent);
        }

        .crad-stat-icon i {
            font-size: 2rem;
            position: relative;
            z-index: 1;
        }

        .crad-stat-info h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--gray-800), var(--gray-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .crad-stat-info p {
            color: var(--gray-600);
            font-size: 1rem;
            font-weight: 500;
        }

        /* Enhanced Dashboard Content */
        .crad-dashboard-content {
            background: linear-gradient(135deg, var(--white) 0%, #fefefe 100%);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .crad-dashboard-content:hover {
            box-shadow: var(--shadow-2xl);
        }

        /* Enhanced Tabs */
        .crad-tabs-container {
            width: 100%;
        }

        .crad-tabs-nav {
            display: flex;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-bottom: 1px solid var(--gray-200);
            overflow-x: auto;
            scrollbar-width: none;
        }

        .crad-tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .crad-tab-btn {
            padding: 1.5rem 2rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-600);
            transition: var(--transition);
            white-space: nowrap;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 0;
        }

        .crad-tab-btn i {
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        .crad-tab-btn::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .crad-tab-btn:hover {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.05);
        }

        .crad-tab-btn:hover::before {
            width: 50%;
        }

        .crad-tab-btn.active {
            color: var(--primary);
            background: var(--white);
            font-weight: 600;
        }

        .crad-tab-btn.active::before {
            width: 100%;
        }

        /* Tab Content */
        .crad-tab-content {
            display: none;
            padding: 2.5rem;
            animation: cradFadeIn 0.6s ease;
        }

        .crad-tab-content.active {
            display: block;
        }

        @keyframes cradFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Content Cards */
        .crad-content-card {
            background: linear-gradient(135deg, var(--white) 0%, #fefefe 100%);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .crad-content-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .crad-card-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-bottom: 1px solid var(--gray-200);
        }

        .crad-card-header h3 {
            margin: 0;
            font-size: 1.375rem;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            font-weight: 700;
        }

        .crad-card-header h3 i {
            margin-right: 0.75rem;
            color: var(--primary);
            font-size: 1.25rem;
        }

        .crad-card-body {
            padding: 2rem;
        }

        /* User Details Grid */
        .crad-user-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .crad-detail-item {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--gray-50), #fafbff);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .crad-detail-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .crad-detail-item:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .crad-detail-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            flex-shrink: 0;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .crad-detail-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .crad-detail-icon i {
            color: var(--white);
            font-size: 1.375rem;
        }

        .crad-detail-info h4 {
            margin: 0 0 0.5rem 0;
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .crad-detail-info p {
            margin: 0;
            font-size: 1.125rem;
            color: var(--gray-800);
            font-weight: 600;
            word-break: break-word;
        }

        /* Form Styles */
        .crad-form-modern {
            max-width: 100%;
        }

        .crad-form-group {
            margin-bottom: 1.5rem;
        }

        .crad-form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gray-800);
            font-size: 0.95rem;
        }

        .crad-input-with-icon {
            position: relative;
        }

        .crad-input-with-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1.125rem;
            transition: var(--transition-fast);
        }

        .crad-input-with-icon.textarea i {
            top: 1rem;
            transform: none;
        }

        .crad-form-group input,
        .crad-form-group textarea,
        .crad-form-group select {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
            color: var(--gray-800);
            font-family: inherit;
        }

        .crad-form-group input:focus,
        .crad-form-group textarea:focus,
        .crad-form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .crad-form-group input:focus + .crad-input-with-icon i,
        .crad-form-group textarea:focus + .crad-input-with-icon i,
        .crad-form-group select:focus + .crad-input-with-icon i {
            color: var(--primary);
        }

        .crad-form-button {
            display: inline-flex;
            align-items: center;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: var(--radius-lg);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
        }

        .crad-form-button:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .crad-form-button i {
            margin-right: 0.5rem;
        }

        /* Issues Container */
        .crad-issues-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .crad-issue-card {
            background: linear-gradient(135deg, var(--white) 0%, #fefefe 100%);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--gray-200);
            position: relative;
        }

        .crad-issue-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .crad-issue-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .crad-issue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-bottom: 1px solid var(--gray-200);
        }

        .crad-issue-id {
            font-weight: 700;
            color: var(--gray-800);
            font-size: 1.125rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .crad-status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-fast);
        }

        .crad-status-badge:hover {
            transform: scale(1.05);
        }

        .crad-status-badge i {
            margin-right: 0.5rem;
        }

        .crad-status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .crad-status-progress {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .crad-status-resolved {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #3730a3;
            border: 1px solid #8b5cf6;
        }

        .crad-issue-body {
            padding: 1.5rem;
        }

        .crad-issue-category {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 500;
            border: 1px solid #93c5fd;
        }

        .crad-issue-category i {
            margin-right: 0.5rem;
        }

        .crad-issue-description {
            margin-bottom: 1rem;
            color: var(--gray-600);
            line-height: 1.7;
            font-size: 1rem;
        }

        .crad-issue-attachment {
            margin-top: 1rem;
        }

        .crad-image-preview {
            display: block;
            position: relative;
            width: 100%;
            max-width: 200px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .crad-image-preview img {
            width: 100%;
            height: auto;
            display: block;
            transition: var(--transition);
        }

        .crad-image-preview:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .crad-image-preview:hover img {
            transform: scale(1.1);
        }

        .crad-file-link {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-radius: var(--radius-lg);
            color: var(--gray-800);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            border: 1px solid var(--gray-200);
        }

        .crad-file-link i {
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .crad-file-link:hover {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .crad-file-link:hover i {
            color: var(--white);
        }

        .crad-issue-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-top: 1px solid var(--gray-200);
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .crad-issue-date,
        .crad-issue-agent {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .crad-issue-date i,
        .crad-issue-agent i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .crad-agent-name {
            font-weight: 600;
            margin-right: 0.5rem;
            color: var(--gray-800);
        }

        .crad-agent-phone {
            color: var(--gray-600);
        }

        .crad-no-agent {
            color: var(--gray-400);
            font-style: italic;
        }

        /* Feedback Section */
        .crad-feedback-section {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--gray-50), #fafbff);
            border-top: 1px solid var(--gray-200);
        }

        .crad-feedback-header {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            font-size: 1.125rem;
        }

        .crad-feedback-header i {
            margin-right: 0.75rem;
            color: #fbbf24;
        }

        .crad-feedback-submitted {
            background: var(--white);
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .crad-feedback-rating {
            margin: 1rem 0;
            text-align: center;
        }

        .crad-feedback-rating i {
            font-size: 1.5rem;
            margin: 0 0.25rem;
        }

        .crad-feedback-rating i.fas.fa-star {
            color: #fbbf24;
        }

        .crad-feedback-rating i.far.fa-star {
            color: var(--gray-300);
        }

        .crad-feedback-comments {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--radius);
            margin-top: 1rem;
            font-style: italic;
            color: var(--gray-600);
            line-height: 1.6;
            border-left: 3px solid var(--primary);
        }

        .crad-feedback-thanks {
            margin-top: 1rem;
            color: var(--success);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .crad-feedback-thanks i {
            margin-right: 0.5rem;
        }

        .crad-feedback-form {
            background: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .crad-rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin: 1.5rem 0;
        }

        .crad-rating-stars input {
            display: none;
        }

        .crad-rating-stars label {
            cursor: pointer;
            font-size: 2rem;
            color: var(--gray-300);
            transition: var(--transition-fast);
            margin: 0 0.25rem;
        }

        .crad-rating-stars label:hover,
        .crad-rating-stars label:hover ~ label,
        .crad-rating-stars input:checked ~ label {
            color: #fbbf24;
            transform: scale(1.1);
        }

        .crad-feedback-textarea {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .crad-feedback-textarea textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }

        .crad-feedback-textarea textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .crad-feedback-submit {
            text-align: center;
        }

        .crad-feedback-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border: none;
            padding: 0.875rem 2rem;
            border-radius: var(--radius-lg);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            display: inline-flex;
            align-items: center;
        }

        .crad-feedback-btn i {
            margin-right: 0.5rem;
        }

        .crad-feedback-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Empty State */
        .crad-empty-state {
            text-align: center;
            padding: 4rem 1.5rem;
            color: var(--gray-500);
        }

        .crad-empty-state i {
            color: var(--gray-300);
            margin-bottom: 1.5rem;
            font-size: 4rem;
        }

        .crad-empty-state p {
            margin-bottom: 2rem;
            font-size: 1.25rem;
            font-weight: 500;
        }

        /* Danger Zone */
        .crad-danger-zone {
            border: 2px solid #fecaca;
            background: linear-gradient(135deg, #fef2f2, #fecaca);
        }

        .crad-danger-zone .crad-card-header {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-bottom-color: #fca5a5;
        }

        .crad-danger-zone .crad-card-header h3 {
            color: #991b1b;
        }

        .crad-danger-zone .crad-card-header h3 i {
            color: var(--danger);
        }

        .crad-warning-message {
            display: flex;
            align-items: flex-start;
            padding: 1.25rem;
            background: rgba(254, 202, 202, 0.5);
            border-radius: var(--radius-lg);
            margin-bottom: 1.25rem;
            border-left: 4px solid var(--danger);
        }

        .crad-warning-message i {
            color: var(--danger);
            font-size: 1.5rem;
            margin-right: 1rem;
            margin-top: 0.125rem;
        }

        .crad-warning-message p {
            color: #991b1b;
            font-weight: 500;
            line-height: 1.6;
        }

        .crad-form-button.danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            box-shadow: var(--shadow-md);
        }

        .crad-form-button.danger:hover {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            box-shadow: var(--shadow-lg);
        }

        /* Toggle Password */
        .crad-toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius);
            transition: var(--transition-fast);
        }

        .crad-toggle-password:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        /* Lightbox */
        .crad-lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            animation: cradFadeIn 0.3s forwards;
        }

        .crad-lightbox img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-2xl);
            transform: scale(0.9);
            animation: cradScaleIn 0.3s forwards;
        }

        @keyframes cradScaleIn {
            to {
                transform: scale(1);
            }
        }

        .crad-lightbox-close {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            color: var(--gray-800);
            font-size: 1.5rem;
            cursor: pointer;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            box-shadow: var(--shadow-lg);
        }

        .crad-lightbox-close:hover {
            background: var(--white);
            transform: scale(1.1) rotate(90deg);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .crad-dashboard-stats {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .crad-issues-container {
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .crad-dashboard-container {
                padding: 0 1rem;
            }

            .crad-dashboard-header {
                padding: 2rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .crad-user-welcome {
                margin-bottom: 1.5rem;
            }

            .crad-dashboard-actions {
                width: 100%;
                justify-content: center;
            }

            .crad-dashboard-stats {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1rem;
            }

            .crad-user-details {
                grid-template-columns: 1fr;
            }

            .crad-issues-container {
                grid-template-columns: 1fr;
            }

            .crad-tab-content {
                padding: 2rem 1.5rem;
            }

            .crad-issue-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .crad-dashboard-header {
                padding: 1.5rem 1rem;
            }

            .crad-user-welcome {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .crad-user-avatar {
                margin-bottom: 1rem;
                width: 80px;
                height: 80px;
            }

            .crad-user-avatar i {
                font-size: 2rem;
            }

            .crad-welcome-text h2 {
                font-size: 2rem;
            }

            .crad-stat-card {
                padding: 1.5rem;
            }

            .crad-stat-icon {
                width: 56px;
                height: 56px;
            }

            .crad-stat-info h3 {
                font-size: 2rem;
            }

            .crad-tab-btn {
                padding: 1.25rem 1.5rem;
                font-size: 0.9rem;
            }

            .crad-tabs-nav {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Particles -->
    <div class="crad-bg-particles">
        <div class="crad-particle"></div>
        <div class="crad-particle"></div>
        <div class="crad-particle"></div>
        <div class="crad-particle"></div>
        <div class="crad-particle"></div>
    </div>

    <?php include 'header.php'; ?>
       <?php include 'loader.php'; ?>
    
    <main>
        <section class="crad-dashboard-section">
            <div class="crad-dashboard-container">
                <!-- Enhanced Dashboard Header -->
                <div class="crad-dashboard-header">
                    <div class="crad-user-welcome">
                        <div class="crad-user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="crad-welcome-text">
                            <h2>Welcome, <?php echo htmlspecialchars($userData['name']); ?>!</h2>
                            <p class="crad-user-role"><i class="fas fa-shield-alt"></i> User Account</p>
                        </div>
                    </div>
                    
                    <div class="crad-dashboard-actions">
                        <a href="/views/report_issue.php" class="crad-action-button">
                            <i class="fas fa-plus-circle"></i> Report New Issue
                        </a>
                    </div>
                </div>

                <!-- Enhanced Notifications -->
                <?php if (isset($_GET['success']) || isset($_GET['error'])): ?>
                    <div class="crad-notification-container">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="crad-notification success">
                                <i class="fas fa-check-circle"></i>
                                <p><?php echo htmlspecialchars($_GET['success']); ?></p>
                                <button class="crad-close-notification"><i class="fas fa-times"></i></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error'])): ?>
                            <div class="crad-notification error">
                                <i class="fas fa-exclamation-circle"></i>
                                <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                                <button class="crad-close-notification"><i class="fas fa-times"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Enhanced Stats Cards -->
                <div class="crad-dashboard-stats">
                    <div class="crad-stat-card">
                        <div class="crad-stat-icon total">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="crad-stat-info">
                            <h3><?php echo $total_issues; ?></h3>
                            <p>Total Issues</p>
                        </div>
                    </div>
                    
                    <?php
                    // Count issues by status
                    $pending = 0;
                    $inProgress = 0;
                    $resolved = 0;
                    
                    foreach ($reported_issues as $issue) {
                        if ($issue['status'] == 'Pending') $pending++;
                        if ($issue['status'] == 'In Progress') $inProgress++;
                        if ($issue['status'] == 'Resolved') $resolved++;
                    }
                    ?>
                    
                    <div class="crad-stat-card">
                        <div class="crad-stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="crad-stat-info">
                            <h3><?php echo $pending; ?></h3>
                            <p>Pending</p>
                        </div>
                    </div>
                    
                    <div class="crad-stat-card">
                        <div class="crad-stat-icon progress">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="crad-stat-info">
                            <h3><?php echo $inProgress; ?></h3>
                            <p>In Progress</p>
                        </div>
                    </div>
                    
                    <div class="crad-stat-card">
                        <div class="crad-stat-icon resolved">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="crad-stat-info">
                            <h3><?php echo $resolved; ?></h3>
                            <p>Resolved</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Dashboard Content -->
                <div class="crad-dashboard-content">
                    <!-- Enhanced Tabs Navigation -->
                    <div class="crad-tabs-container">
                        <div class="crad-tabs-nav">
                            <button class="crad-tab-btn active" data-tab="details">
                                <i class="fas fa-user"></i> Your Details
                            </button>
                            <button class="crad-tab-btn" data-tab="update">
                                <i class="fas fa-edit"></i> Update Profile
                            </button>
                            <button class="crad-tab-btn" data-tab="issues">
                                <i class="fas fa-ticket-alt"></i> Reported Issues
                            </button>
                            <button class="crad-tab-btn" data-tab="settings">
                                <i class="fas fa-cog"></i> Settings
                            </button>
                        </div>

                        <!-- Tab Content: Your Details -->
                        <div id="details" class="crad-tab-content active">
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-id-card"></i> Your Details</h3>
                                </div>
                                <div class="crad-card-body">
                                    <div class="crad-user-details">
                                        <div class="crad-detail-item">
                                            <div class="crad-detail-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="crad-detail-info">
                                                <h4>Name</h4>
                                                <p><?php echo htmlspecialchars($userData['name']); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="crad-detail-item">
                                            <div class="crad-detail-icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="crad-detail-info">
                                                <h4>Email</h4>
                                                <p><?php echo htmlspecialchars($userData['email'] ?? 'Not provided'); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="crad-detail-item">
                                            <div class="crad-detail-icon">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="crad-detail-info">
                                                <h4>Phone Number</h4>
                                                <p><?php echo htmlspecialchars($userData['phone_number'] ?? 'Not provided'); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="crad-detail-item">
                                            <div class="crad-detail-icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div class="crad-detail-info">
                                                <h4>Address</h4>
                                                <p><?php echo htmlspecialchars($userData['address'] ?? 'Not provided'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Content: Update Profile -->
                        <div id="update" class="crad-tab-content">
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-envelope"></i> Update Email</h3>
                                </div>
                                <div class="crad-card-body">
                                    <form action="/controllers/UserController.php?action=update_email_request" method="POST" class="crad-form-modern">
                                        <div class="crad-form-group">
                                            <label for="email">New Email</label>
                                            <div class="crad-input-with-icon">
                                                <i class="fas fa-envelope"></i>
                                                <input type="email" id="email" name="email" required placeholder="Enter new email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="crad-form-button">
                                            <i class="fas fa-paper-plane"></i> Send OTP
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-phone"></i> Update Phone Number</h3>
                                </div>
                                <div class="crad-card-body">
                                    <form action="/controllers/UserController.php?action=update_phone" method="POST" class="crad-form-modern">
                                        <div class="crad-form-group">
                                            <label for="phone_number">New Phone Number</label>
                                            <div class="crad-input-with-icon">
                                                <i class="fas fa-phone"></i>
                                                <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" value="<?php echo htmlspecialchars($userData['phone_number'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="crad-form-button">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-map-marker-alt"></i> Update Address</h3>
                                </div>
                                <div class="crad-card-body">
                                    <form action="/controllers/UserController.php?action=update_address" method="POST" class="crad-form-modern">
                                        <div class="crad-form-group">
                                            <label for="address">New Address</label>
                                            <div class="crad-input-with-icon textarea">
                                                <i class="fas fa-home"></i>
                                                <textarea id="address" name="address" required placeholder="Enter new address"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="crad-form-button">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Content: Reported Issues -->
                        <div id="issues" class="crad-tab-content">
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-ticket-alt"></i> Your Reported Issues</h3>
                                </div>
                                <div class="crad-card-body">
                                    <?php if (empty($reported_issues)): ?>
                                        <div class="crad-empty-state">
                                            <i class="fas fa-ticket-alt"></i>
                                            <p>You haven't reported any issues yet.</p>
                                            <a href="/views/report_issue.php" class="crad-form-button">
                                                <i class="fas fa-plus-circle"></i> Report Your First Issue
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="crad-issues-container">
                                            <?php foreach ($reported_issues as $issue): ?>
                                                <div class="crad-issue-card">
                                                    <div class="crad-issue-header">
                                                        <div class="crad-issue-id">#<?php echo $issue['id']; ?></div>
                                                        <?php 
                                                            $status_class = '';
                                                            $status_icon = '';
                                                            switch($issue['status']) {
                                                                case 'Pending':
                                                                    $status_class = 'crad-status-pending';
                                                                    $status_icon = 'clock';
                                                                    break;
                                                                case 'In Progress':
                                                                    $status_class = 'crad-status-progress';
                                                                    $status_icon = 'spinner';
                                                                    break;
                                                                case 'Resolved':
                                                                    $status_class = 'crad-status-resolved';
                                                                    $status_icon = 'check-circle';
                                                                    break;
                                                                default:
                                                                    $status_class = 'crad-status-default';
                                                                    $status_icon = 'info-circle';
                                                            }
                                                        ?>
                                                        <div class="crad-status-badge <?php echo $status_class; ?>">
                                                            <i class="fas fa-<?php echo $status_icon; ?>"></i> <?php echo htmlspecialchars($issue['status']); ?>
                                                        </div>
                                                    </div>
                                                    <div class="crad-issue-body">
                                                        <div class="crad-issue-category">
                                                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($issue['category']); ?>
                                                        </div>
                                                        <div class="crad-issue-description">
                                                            <?php echo htmlspecialchars($issue['description']); ?>
                                                        </div>
                                                        
                                                        <?php if (!empty($issue['image_path'])): ?>
                                                            <div class="crad-issue-attachment">
                                                                <a href="<?php echo $issue['image_path']; ?>" target="_blank" class="crad-image-preview">
                                                                    <img src="<?php echo $issue['image_path']; ?>" alt="Issue Image">
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($issue['attached_file'])): ?>
                                                            <div class="crad-issue-attachment">
                                                                <a href="<?php echo $issue['attached_file']; ?>" target="_blank" class="crad-file-link">
                                                                    <i class="fas fa-file-pdf"></i> View Attached File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="crad-issue-footer">
                                                        <div class="crad-issue-date">
                                                            <i class="fas fa-calendar-alt"></i> <?php echo date('Y-m-d H:i', strtotime($issue['created_at'])); ?>
                                                        </div>
                                                        <div class="crad-issue-agent">
                                                            <i class="fas fa-user-tie"></i> 
                                                            <?php if ($issue['agent_id']): ?>
                                                                <span class="crad-agent-name"><?php echo htmlspecialchars($issue['agent_name']); ?></span>
                                                                <span class="crad-agent-phone"><?php echo htmlspecialchars($issue['agent_phone']); ?></span>
                                                            <?php else: ?>
                                                                <span class="crad-no-agent">Not assigned yet</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if ($issue['status'] == 'Resolved'): ?>
                                                        <div class="crad-feedback-section">
                                                            <?php
                                                            // Check if feedback already submitted
                                                            $stmt = $pdo->prepare("SELECT * FROM feedback WHERE issue_id = ? AND user_id = ?");
                                                            $stmt->execute([$issue['id'], $_SESSION['user_id']]);
                                                            $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            
                                                            <?php if ($feedback): ?>
                                                                <div class="crad-feedback-header">
                                                                    <span><i class="fas fa-star"></i> Your Feedback</span>
                                                                </div>
                                                                <div class="crad-feedback-submitted">
                                                                    <div class="crad-feedback-rating">
                                                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                                                            <?php if($i <= $feedback['rating']): ?>
                                                                                <i class="fas fa-star"></i>
                                                                            <?php else: ?>
                                                                                <i class="far fa-star"></i>
                                                                            <?php endif; ?>
                                                                        <?php endfor; ?>
                                                                    </div>
                                                                    
                                                                    <div class="crad-feedback-comments">
                                                                        <?php echo htmlspecialchars($feedback['comments']); ?>
                                                                    </div>
                                                                    
                                                                    <div class="crad-feedback-thanks">
                                                                        <i class="fas fa-check-circle"></i> Thank you! Your feedback is important to us
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="crad-feedback-header">
                                                                    <span><i class="fas fa-star"></i> Please Share Your Feedback</span>
                                                                </div>
                                                                <form action="/controllers/UserController.php?action=submit_feedback" method="POST" class="crad-feedback-form">
                                                                    <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                                                    
                                                                    <div class="crad-rating-stars">
                                                                        <input type="radio" id="star5_<?php echo $issue['id']; ?>" name="rating" value="5" required />
                                                                        <label for="star5_<?php echo $issue['id']; ?>">★</label>
                                                                        <input type="radio" id="star4_<?php echo $issue['id']; ?>" name="rating" value="4" />
                                                                        <label for="star4_<?php echo $issue['id']; ?>">★</label>
                                                                        <input type="radio" id="star3_<?php echo $issue['id']; ?>" name="rating" value="3" />
                                                                        <label for="star3_<?php echo $issue['id']; ?>">★</label>
                                                                        <input type="radio" id="star2_<?php echo $issue['id']; ?>" name="rating" value="2" />
                                                                        <label for="star2_<?php echo $issue['id']; ?>">★</label>
                                                                        <input type="radio" id="star1_<?php echo $issue['id']; ?>" name="rating" value="1" />
                                                                        <label for="star1_<?php echo $issue['id']; ?>">★</label>
                                                                    </div>
                                                                    
                                                                    <div class="crad-feedback-textarea">
                                                                        <textarea name="comments" placeholder="Tell us about your experience..." required></textarea>
                                                                    </div>
                                                                    
                                                                    <div class="crad-feedback-submit">
                                                                        <button type="submit" class="crad-feedback-btn">
                                                                            <i class="fas fa-paper-plane"></i> Submit Feedback
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Content: Settings -->
                        <div id="settings" class="crad-tab-content">
                            <div class="crad-content-card">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-lock"></i> Change Password</h3>
                                </div>
                                <div class="crad-card-body">
                                    <form action="/controllers/UserController.php?action=change_password" method="POST" class="crad-form-modern">
                                        <div class="crad-form-group">
                                            <label for="current_password">Current Password</label>
                                            <div class="crad-input-with-icon">
                                                <i class="fas fa-lock"></i>
                                                <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                                                <button type="button" class="crad-toggle-password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="crad-form-group">
                                            <label for="new_password">New Password</label>
                                            <div class="crad-input-with-icon">
                                                <i class="fas fa-key"></i>
                                                <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                                                <button type="button" class="crad-toggle-password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="submit" class="crad-form-button">
                                            <i class="fas fa-save"></i> Change Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="crad-content-card crad-danger-zone">
                                <div class="crad-card-header">
                                    <h3><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
                                </div>
                                <div class="crad-card-body">
                                    <div class="crad-warning-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <p>Warning: This action cannot be undone. All your data, including reported issues, will be permanently deleted.</p>
                                    </div>
                                    <form action="/controllers/UserController.php?action=delete_account" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                        <button type="submit" class="crad-form-button danger">
                                            <i class="fas fa-trash-alt"></i> Delete Account
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Navigation
            const tabButtons = document.querySelectorAll('.crad-tab-btn');
            const tabContents = document.querySelectorAll('.crad-tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                    
                    localStorage.setItem('activeTab', tabId);
                });
            });
            
            // Restore active tab from localStorage
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                const activeButton = document.querySelector(`.crad-tab-btn[data-tab="${activeTab}"]`);
                if (activeButton) {
                    activeButton.click();
                }
            }
            
            // Close notification
            const closeButtons = document.querySelectorAll('.crad-close-notification');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const notification = this.closest('.crad-notification');
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(-100px)';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 300);
                });
            });
            
            // Auto-hide notifications after 5 seconds
            const notifications = document.querySelectorAll('.crad-notification');
            if (notifications.length > 0) {
                setTimeout(() => {
                    notifications.forEach(notification => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(-100px)';
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 300);
                    });
                }, 5000);
            }
            
            // Image preview lightbox
            const imageLinks = document.querySelectorAll('.crad-image-preview');
            imageLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const imgSrc = this.getAttribute('href');
                    const lightbox = document.createElement('div');
                    lightbox.className = 'crad-lightbox';
                    
                    const img = document.createElement('img');
                    img.src = imgSrc;
                    
                    const closeBtn = document.createElement('button');
                    closeBtn.className = 'crad-lightbox-close';
                    closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    
                    lightbox.appendChild(img);
                    lightbox.appendChild(closeBtn);
                    document.body.appendChild(lightbox);
                    
                    document.body.style.overflow = 'hidden';
                    
                    lightbox.addEventListener('click', function() {
                        document.body.style.overflow = '';
                        lightbox.remove();
                    });
                    
                    img.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                    
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            document.body.style.overflow = '';
                            lightbox.remove();
                        }
                    });
                    
                    closeBtn.addEventListener('click', function() {
                        document.body.style.overflow = '';
                        lightbox.remove();
                    });
                });
            });

            // Toggle password visibility
            const toggleButtons = document.querySelectorAll('.crad-toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Confirm delete account
            const deleteAccountForm = document.querySelector('form[action*="delete_account"]');
            if (deleteAccountForm) {
                deleteAccountForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const confirmed = confirm('Are you sure you want to delete your account? This action cannot be undone.');
                    
                    if (confirmed) {
                        const doubleConfirmed = confirm('This is your final warning. Your account and all data will be permanently deleted. Are you absolutely sure?');
                        if (doubleConfirmed) {
                            this.submit();
                        }
                    }
                });
            }

            // Enhanced hover effects
            const cards = document.querySelectorAll('.crad-stat-card, .crad-issue-card, .crad-content-card, .crad-detail-item');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = this.style.transform || 'translateY(-5px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
