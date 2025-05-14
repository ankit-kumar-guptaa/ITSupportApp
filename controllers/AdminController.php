<?php
session_start();
require '../config/db.php';
require '../config/email.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /views/login.php?error=Please login as an admin!");
    exit;
}

// Delete User
if ($action === 'delete_user') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];

        // Delete user's issues
        $stmt = $pdo->prepare("DELETE FROM issues WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        header("Location: /views/admin_dashboard.php?success=User deleted successfully!");
        exit;
    }
}

// Delete Agent
if ($action === 'delete_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];

        // Unassign agent from issues
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = NULL WHERE agent_id = ?");
        $stmt->execute([$agent_id]);

        // Delete agent
        $stmt = $pdo->prepare("DELETE FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);

        header("Location: /views/admin_dashboard.php?success=Agent deleted successfully!");
        exit;
    }
}

// Approve Agent
if ($action === 'approve_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];

        // Update agent status to approved
        $stmt = $pdo->prepare("UPDATE agents SET status = 'approved' WHERE id = ?");
        $stmt->execute([$agent_id]);

        // Fetch agent email
        $stmt = $pdo->prepare("SELECT email, name FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch();

        // Send approval email
        $subject = "Agent Account Approved - IT Support Hub";
        $body = "Dear {$agent['name']},<br><br>Your agent account has been approved. You can now log in to your dashboard.<br><br>Thank you,<br>IT Support Hub Team";
        sendEmail($agent['email'], $subject, $body);

        header("Location: /views/admin_dashboard.php?success=Agent approved successfully!");
        exit;
    }
}

// Reject Agent
if ($action === 'reject_agent') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];
        $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);

        // Fetch agent email
        $stmt = $pdo->prepare("SELECT email, name FROM agents WHERE id = ?");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch();

        // Update agent status to rejected
        $stmt = $pdo->prepare("UPDATE agents SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$agent_id]);

        // Send rejection email
        $subject = "Agent Account Rejected - IT Support Hub";
        $body = "Dear {$agent['name']},<br><br>Your agent account has been rejected. Reason: $reason<br><br>Thank you,<br>IT Support Hub Team";
        sendEmail($agent['email'], $subject, $body);

        header("Location: /views/admin_dashboard.php?success=Agent rejected successfully!");
        exit;
    }
}

// Assign Issue to Agent
if ($action === 'assign_issue') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = isset($_POST['issue_id']) ? (int)$_POST['issue_id'] : 0;
        $agent_id = isset($_POST['agent_id']) ? (int)$_POST['agent_id'] : 0;

        // Validate inputs
        if ($issue_id <= 0 || $agent_id <= 0) {
            header("Location: /views/admin_dashboard.php?error=Invalid issue or agent selected!");
            exit;
        }

        // Check if issue exists
        $stmt = $pdo->prepare("SELECT * FROM issues WHERE id = ?");
        $stmt->execute([$issue_id]);
        $issue = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$issue) {
            header("Location: /views/admin_dashboard.php?error=Issue not found!");
            exit;
        }

        // Check if agent exists and is approved
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE id = ? AND status = 'approved'");
        $stmt->execute([$agent_id]);
        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$agent) {
            header("Location: /views/admin_dashboard.php?error=Agent not found or not approved!");
            exit;
        }

        // Update issue with agent_id and set status to in_progress
        $stmt = $pdo->prepare("UPDATE issues SET agent_id = ?, status = 'in_progress', updated_at = NOW() WHERE id = ?");
        $stmt->execute([$agent_id, $issue_id]);

        // Log the action in activity logs (if you have activity logs table)
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, role, action, ip_address, created_at) 
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], 'admin', "Assigned issue ID $issue_id to agent ID $agent_id", $ip_address]);

        // Redirect with success message
        header("Location: /views/admin_dashboard.php?success=Agent assigned successfully!");
        exit;
    }
}

// Update Issue Status
if ($action === 'update_issue_status') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];
        $status = $_POST['status'];

        // Update issue status
        $stmt = $pdo->prepare("UPDATE issues SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $issue_id]);

        header("Location: /views/admin_dashboard.php?success=Issue status updated successfully!");
        exit;
    }
}

// Delete Issue
if ($action === 'delete_issue') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $issue_id = $_POST['issue_id'];

        // Delete issue
        $stmt = $pdo->prepare("DELETE FROM issues WHERE id = ?");
        $stmt->execute([$issue_id]);

        header("Location: /views/admin_dashboard.php?success=Issue deleted successfully!");
        exit;
    }
}

// Send Message to Agent
if ($action === 'send_message') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $agent_id = $_POST['agent_id'];
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Save message to database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_role, recipient_id, recipient_role, message, created_at) 
                               VALUES (?, 'admin', ?, 'agent', ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $agent_id, $message]);

        header("Location: /views/admin_dashboard.php?success=Message sent to agent successfully!");
        exit;
    }
}


// Search and Sort for Users
if ($action === 'search_sort_users') {
    $search_users = isset($_GET['search_users']) ? $_GET['search_users'] : '';
    $sort_users = isset($_GET['sort_users']) ? $_GET['sort_users'] : 'name_asc';

    $query = "SELECT * FROM users WHERE 1=1";
    $params = [];

    if (!empty($search_users)) {
        $query .= " AND (name LIKE ? OR email LIKE ?)";
        $params[] = "%$search_users%";
        $params[] = "%$search_users%";
    }

    if ($sort_users == 'name_asc') {
        $query .= " ORDER BY name ASC";
    } elseif ($sort_users == 'name_desc') {
        $query .= " ORDER BY name DESC";
    } elseif ($sort_users == 'created_at_asc') {
        $query .= " ORDER BY created_at ASC";
    } elseif ($sort_users == 'created_at_desc') {
        $query .= " ORDER BY created_at DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pass data back to admin_dashboard.php (you can use session or redirect with query params)
    $_SESSION['filtered_users'] = $users;
    header("Location: /views/admin_dashboard.php?tab=users");
    exit;
}

// Search and Sort for Agents
if ($action === 'search_sort_agents') {
    $search_agents = isset($_GET['search_agents']) ? $_GET['search_agents'] : '';
    $sort_agents = isset($_GET['sort_agents']) ? $_GET['sort_agents'] : 'name_asc';

    $query = "SELECT * FROM agents WHERE 1=1";
    $params = [];

    if (!empty($search_agents)) {
        $query .= " AND (name LIKE ? OR email LIKE ?)";
        $params[] = "%$search_agents%";
        $params[] = "%$search_agents%";
    }

    if ($sort_agents == 'name_asc') {
        $query .= " ORDER BY name ASC";
    } elseif ($sort_agents == 'name_desc') {
        $query .= " ORDER BY name DESC";
    } elseif ($sort_agents == 'created_at_asc') {
        $query .= " ORDER BY created_at ASC";
    } elseif ($sort_agents == 'created_at_desc') {
        $query .= " ORDER BY created_at DESC";
    } elseif ($sort_agents == 'status_asc') {
        $query .= " ORDER BY status ASC";
    } elseif ($sort_agents == 'status_desc') {
        $query .= " ORDER BY status DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_agents'] = $agents;
    header("Location: /views/admin_dashboard.php?tab=agents");
    exit;
}

// Search and Sort for Pending Agents
if ($action === 'search_sort_pending_agents') {
    $search_pending_agents = isset($_GET['search_pending_agents']) ? $_GET['search_pending_agents'] : '';
    $sort_pending_agents = isset($_GET['sort_pending_agents']) ? $_GET['sort_pending_agents'] : 'name_asc';

    $query = "SELECT * FROM agents WHERE status = 'pending'";
    $params = [];

    if (!empty($search_pending_agents)) {
        $query .= " AND (name LIKE ? OR email LIKE ?)";
        $params[] = "%$search_pending_agents%";
        $params[] = "%$search_pending_agents%";
    }

    if ($sort_pending_agents == 'name_asc') {
        $query .= " ORDER BY name ASC";
    } elseif ($sort_pending_agents == 'name_desc') {
        $query .= " ORDER BY name DESC";
    } elseif ($sort_pending_agents == 'created_at_asc') {
        $query .= " ORDER BY created_at ASC";
    } elseif ($sort_pending_agents == 'created_at_desc') {
        $query .= " ORDER BY created_at DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $pending_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_pending_agents'] = $pending_agents;
    header("Location: /views/admin_dashboard.php?tab=pending_agents");
    exit;
}

// Search and Sort for Issues
if ($action === 'search_sort_issues') {
    $search_issues = isset($_GET['search_issues']) ? $_GET['search_issues'] : '';
    $sort_issues = isset($_GET['sort_issues']) ? $_GET['sort_issues'] : 'created_at_desc';

    $query = "SELECT i.*, u.name as user_name, a.name as agent_name 
              FROM issues i 
              LEFT JOIN users u ON i.user_id = u.id 
              LEFT JOIN agents a ON i.agent_id = a.id 
              WHERE 1=1";
    $params = [];

    if (!empty($search_issues)) {
        $query .= " AND (i.description LIKE ? OR u.name LIKE ?)";
        $params[] = "%$search_issues%";
        $params[] = "%$search_issues%";
    }

    if ($sort_issues == 'created_at_desc') {
        $query .= " ORDER BY i.created_at DESC";
    } elseif ($sort_issues == 'created_at_asc') {
        $query .= " ORDER BY i.created_at ASC";
    } elseif ($sort_issues == 'status_asc') {
        $query .= " ORDER BY i.status ASC";
    } elseif ($sort_issues == 'status_desc') {
        $query .= " ORDER BY i.status DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_issues'] = $issues;
    header("Location: /views/admin_dashboard.php?tab=issues");
    exit;
}

// Search and Sort for Messages
if ($action === 'search_sort_messages') {
    $search_messages = isset($_GET['search_messages']) ? $_GET['search_messages'] : '';
    $sort_messages = isset($_GET['sort_messages']) ? $_GET['sort_messages'] : 'created_at_desc';

    $query = "SELECT m.*, a.name as agent_name 
              FROM messages m 
              JOIN agents a ON m.sender_id = a.id 
              WHERE m.recipient_role = 'admin' AND m.recipient_id = ?";
    $params = [$_SESSION['user_id']];

    if (!empty($search_messages)) {
        $query .= " AND (m.message LIKE ? OR a.name LIKE ?)";
        $params[] = "%$search_messages%";
        $params[] = "%$search_messages%";
    }

    if ($sort_messages == 'created_at_desc') {
        $query .= " ORDER BY m.created_at DESC";
    } elseif ($sort_messages == 'created_at_asc') {
        $query .= " ORDER BY m.created_at ASC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_messages'] = $messages;
    header("Location: /views/admin_dashboard.php?tab=messages");
    exit;
}

// Search and Sort for Activity Logs
if ($action === 'search_sort_activity_logs') {
    $search_logs = isset($_GET['search_logs']) ? $_GET['search_logs'] : '';
    $sort_logs = isset($_GET['sort_logs']) ? $_GET['sort_logs'] : 'created_at_desc';

    $query = "SELECT al.*, u.name as user_name 
              FROM activity_logs al 
              LEFT JOIN users u ON al.user_id = u.id AND al.role = 'user' 
              LEFT JOIN agents a ON al.user_id = a.id AND al.role = 'agent' 
              WHERE 1=1";
    $params = [];

    if (!empty($search_logs)) {
        $query .= " AND (al.action LIKE ? OR al.role LIKE ?)";
        $params[] = "%$search_logs%";
        $params[] = "%$search_logs%";
    }

    if ($sort_logs == 'created_at_desc') {
        $query .= " ORDER BY al.created_at DESC";
    } elseif ($sort_logs == 'created_at_asc') {
        $query .= " ORDER BY al.created_at ASC";
    } elseif ($sort_logs == 'role_asc') {
        $query .= " ORDER BY al.role ASC";
    } elseif ($sort_logs == 'role_desc') {
        $query .= " ORDER BY al.role DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $activity_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_activity_logs'] = $activity_logs;
    header("Location: /views/admin_dashboard.php?tab=activity_logs");
    exit;
}

// Search and Sort for Feedback
if ($action === 'search_sort_feedback') {
    $search_feedback = isset($_GET['search_feedback']) ? $_GET['search_feedback'] : '';
    $sort_feedback = isset($_GET['sort_feedback']) ? $_GET['sort_feedback'] : 'created_at_desc';

    $query = "SELECT f.*, i.description as issue_description, u.name as user_name 
              FROM feedback f 
              JOIN issues i ON f.issue_id = i.id 
              JOIN users u ON f.user_id = u.id 
              WHERE 1=1";
    $params = [];

    if (!empty($search_feedback)) {
        $query .= " AND (f.comments LIKE ? OR u.name LIKE ?)";
        $params[] = "%$search_feedback%";
        $params[] = "%$search_feedback%";
    }

    if ($sort_feedback == 'created_at_desc') {
        $query .= " ORDER BY f.created_at DESC";
    } elseif ($sort_feedback == 'created_at_asc') {
        $query .= " ORDER BY f.created_at ASC";
    } elseif ($sort_feedback == 'rating_desc') {
        $query .= " ORDER BY f.rating DESC";
    } elseif ($sort_feedback == 'rating_asc') {
        $query .= " ORDER BY f.rating ASC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['filtered_feedbacks'] = $feedbacks;
    header("Location: /views/admin_dashboard.php?tab=feedback");
    exit;
}


class AdminController {
    private $conn;

    public function __construct() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Database connection
        require_once '../config/db.php';
        global $pdo;
        $this->conn = $pdo;
        $this->conn = $database->getConnection();
        
        // Handle actions
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            
            switch ($action) {
                case 'admin_register':
                    $this->adminRegister();
                    break;
                // Other actions can be added here
            }
        }
    }
    
    private function adminRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $code = $_POST['code'] ?? '';
            
            // Validate admin code
            if ($code !== "ADMIN-2025-XYZ123") {
                $_SESSION['error'] = "Invalid admin code. Please enter the correct code.";
                header("Location: /ITSupportApp/views/admin_register.php");
                exit;
            }
            
            // Check if email already exists
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = "This email is already registered.";
                header("Location: /ITSupportApp/views/admin_register.php");
                exit;
            }
            
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Register admin user
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
            
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $_SESSION['success'] = "Admin registration successful! You can now login.";
                header("Location: /ITSupportApp/views/login.php");
                exit;
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
                header("Location: /ITSupportApp/views/admin_register.php");
                exit;
            }
        }
    }
}

// Initialize controller
$controller = new AdminController();
?>