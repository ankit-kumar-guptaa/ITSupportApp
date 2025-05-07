<?php
// Admin authentication check
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: /views/login.php");
    exit;
}

// Get all blog posts
$stmt = $pdo->query("
    SELECT p.*, COALESCE(bu.name, u.name) as author_name 
    FROM blog_posts p 
    LEFT JOIN blog_users bu ON p.author_id = bu.id 
    LEFT JOIN users u ON p.author_id = u.id 
    ORDER BY p.created_at DESC
");
$posts = $stmt->fetchAll();

// Handle delete post
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $post_id = $_GET['delete'];
    
    // Get post image to delete
    $stmt = $pdo->prepare("SELECT featured_image FROM blog_posts WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();
    
    // Delete post
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$post_id]);
    
    // Delete image if exists
    if (!empty($post['featured_image'])) {
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/blog/' . $post['featured_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    header("Location: admin_blog.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Blog Management | IT Sahayta</title>
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
        
        .blog-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .blog-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        
        .blog-card .featured-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .blog-card.draft {
            border-left-color: var(--warning);
        }
        
        .blog-card.published {
            border-left-color: var(--success);
        }
        
        .badge-draft {
            background-color: #fef3c7;
            color: var(--warning);
        }
        
        .badge-published {
            background-color: #d1fae5;
            color: var(--success);
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
            <h2 class="mb-0">Blog Management</h2>
            <div>
                <a href="/admin/dashboard.php" class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
                <a href="/admin/blog_editor.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> New Blog Post
                </a>
            </div>
        </div>
        
        <!-- Blog Posts List -->
        <div class="row">
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No blog posts found.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card <?php echo $post['status']; ?> mb-4">
                            <?php if (!empty($post['featured_image'])): ?>
                                <div class="featured-image" style="background-image: url('/uploads/blog/<?php echo htmlspecialchars($post['featured_image']); ?>')"></div>
                            <?php endif; ?>
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge <?php echo $post['status'] === 'published' ? 'badge-published' : 'badge-draft'; ?> px-2 py-1">
                                        <?php echo ucfirst($post['status']); ?>
                                    </span>
                                    <div class="dropdown action-dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="/blog/post.php?id=<?php echo $post['id']; ?>" target="_blank">
                                                    <i class="fas fa-eye me-2 text-primary"></i> View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="/admin/blog_editor.php?id=<?php echo $post['id']; ?>">
                                                    <i class="fas fa-edit me-2 text-success"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="/admin/admin_blog.php?delete=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                                    <i class="fas fa-trash-alt me-2 text-danger"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <h5 class="mb-2"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <div class="d-flex justify-content-between text-muted small mb-2">
                                    <span><i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($post['author_name']); ?></span>
                                    <span><i class="fas fa-eye me-1"></i> <?php echo number_format($post['views']); ?></span>
                                </div>
                                <div class="text-muted small mb-3">
                                    <i class="fas fa-calendar me-1"></i> <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="/admin/blog_editor.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>