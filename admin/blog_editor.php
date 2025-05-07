<?php
// Admin authentication check
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: /views/login.php");
    exit;
}

// Create uploads directory if it doesn't exist
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/blog';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Initialize variables
$post = [
    'id' => '',
    'title' => '',
    'content' => '',
    'featured_image' => '',
    'status' => 'draft'
];
$errors = [];
$success_message = '';

// Check if editing existing post
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $existing_post = $stmt->fetch();
    
    if ($existing_post) {
        $post = $existing_post;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $post['title'] = trim($_POST['title'] ?? '');
    $post['content'] = $_POST['content'] ?? '';
    $post['status'] = $_POST['status'] ?? 'draft';
    
    if (empty($post['title'])) {
        $errors[] = "Title is required";
    }
    
    if (empty($post['content'])) {
        $errors[] = "Content is required";
    }
    
    // Handle image upload
    $featured_image = $post['featured_image']; // Keep existing image by default
    
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($_FILES['featured_image']['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, GIF, and WEBP images are allowed";
        } elseif ($_FILES['featured_image']['size'] > $max_size) {
            $errors[] = "Image size should be less than 5MB";
        } else {
            // Generate unique filename
            $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . '/' . $new_filename;
            
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                // Delete old image if exists
                if (!empty($post['featured_image']) && $post['id']) {
                    $old_image_path = $upload_dir . '/' . $post['featured_image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                
                $featured_image = $new_filename;
            } else {
                $errors[] = "Failed to upload image";
            }
        }
    }
    
    // If no errors, save to database
    if (empty($errors)) {
        if ($post['id']) {
            // Update existing post
            $stmt = $pdo->prepare("
                UPDATE blog_posts 
                SET title = ?, content = ?, featured_image = ?, status = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([
                $post['title'], 
                $post['content'], 
                $featured_image, 
                $post['status'], 
                $post['id']
            ]);
            $success_message = "Blog post updated successfully!";
        } else {
            // Create new post
            $stmt = $pdo->prepare("
                INSERT INTO blog_posts (title, content, featured_image, author_id, status, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            // यहां हमें सही author_id का उपयोग करना होगा
            // blog_users टेबल से admin का ID प्राप्त करें
            $author_stmt = $pdo->prepare("SELECT id FROM blog_users WHERE email = (SELECT email FROM users WHERE id = ?)");
            $author_stmt->execute([$_SESSION['user_id']]);
            $author = $author_stmt->fetch();
            $author_id = $author ? $author['id'] : 1; // डिफ़ॉल्ट admin ID 1 सेट करें
            
            $stmt->execute([
                $post['title'], 
                $post['content'], 
                $featured_image, 
                $author_id, 
                $post['status']
            ]);
            $post['id'] = $pdo->lastInsertId();
            $success_message = "Blog post created successfully!";
        }
        
        // Update post with new image filename
        $post['featured_image'] = $featured_image;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['id'] ? 'Edit' : 'Create'; ?> Blog Post | IT Sahayta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
        
        .editor-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 2rem;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        /* Quill editor customization */
        #editor-container {
            height: 400px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .ql-toolbar {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border-color: #e2e8f0 !important;
        }
        
        .ql-container {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border-color: #e2e8f0 !important;
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
            <h2 class="mb-0"><?php echo $post['id'] ? 'Edit' : 'Create'; ?> Blog Post</h2>
            <div>
                <a href="/admin/admin_blog.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Blog List
                </a>
            </div>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <div class="editor-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                    
                    <?php if (!empty($post['featured_image'])): ?>
                        <div class="mt-2">
                            <img src="/uploads/blog/<?php echo htmlspecialchars($post['featured_image']); ?>" class="image-preview" alt="Featured Image">
                            <p class="text-muted small">Current image. Upload a new one to replace it.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <div id="editor-container"><?php echo $post['content']; ?></div>
                    <input type="hidden" name="content" id="content">
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> <?php echo $post['id'] ? 'Update' : 'Create'; ?> Post
                    </button>
                    
                    <?php if ($post['id']): ?>
                        <a href="/blog/post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-eye me-1"></i> Preview
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });
        
        // Form submission - transfer Quill content to hidden field
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });
        
        // Image upload handler for Quill
        var toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', function() {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();
            
            input.onchange = function() {
                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'image', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            };
        });
    </script>
</body>
</html>
