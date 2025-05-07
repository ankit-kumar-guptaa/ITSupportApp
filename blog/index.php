<?php
// Initialize session
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Pagination
$posts_per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Get total posts count
$count_stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
$total_posts = $count_stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);

// Get posts for current page
$stmt = $pdo->prepare("
    SELECT p.*, COALESCE(bu.name, u.name) as author_name 
    FROM blog_posts p 
    LEFT JOIN blog_users bu ON p.author_id = bu.id 
    LEFT JOIN users u ON p.author_id = u.id 
    WHERE p.status = 'published' 
    ORDER BY p.created_at DESC 
    LIMIT ? OFFSET ?
");
$stmt->bindParam(1, $posts_per_page, PDO::PARAM_INT);
$stmt->bindParam(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta Blog - Latest IT Support Tips and News</title>
    <meta name="description" content="Read the latest IT support tips, tech news, and helpful guides from IT Sahayta experts.">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/assets.php'; ?>
    
    <!-- Include your CSS and other assets here -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <!-- Custom Blog CSS -->
    <link rel="stylesheet" href="/assets/css/blog.css">
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --secondary: #3f37c9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
        }
        
        /* Modern Blog Header */
        .blog-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 5rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .blog-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,208C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"%3E%3C/path%3E%3C/svg%3E');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
        }
        
        .blog-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .blog-header .lead {
            color: rgba(255,255,255,0.9);
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Modern Blog Cards */
        .blog-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .blog-card .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        
        .blog-card .card-body {
            padding: 1.5rem;
        }
        
        .blog-card .card-title {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            line-height: 1.4;
        }
        
        .blog-card .card-title a {
            color: var(--dark);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .blog-card .card-title a:hover {
            color: var(--primary);
        }
        
        .blog-card .card-text {
            color: var(--gray);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .blog-meta {
            display: flex;
            justify-content: space-between;
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 1rem;
        }
        
        .blog-meta span {
            display: flex;
            align-items: center;
        }
        
        .blog-meta i {
            margin-right: 5px;
        }
        
        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        /* Pagination Styling */
        .pagination {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }
        
        .pagination .page-link {
            border: none;
            color: var(--dark);
            margin: 0 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .pagination .page-item.disabled .page-link {
            color: var(--gray);
            background-color: transparent;
        }
        
        /* Category Pills */
        .category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .category-pill {
            background-color: white;
            color: var(--dark);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .category-pill:hover, .category-pill.active {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        /* Search Bar */
        .blog-search {
            max-width: 500px;
            margin: 0 auto 3rem;
            position: relative;
        }
        
        .blog-search input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .blog-search input:focus {
            box-shadow: 0 5px 25px rgba(67, 97, 238, 0.15);
            outline: none;
        }
        
        .blog-search button {
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            border-radius: 50px;
            padding: 0 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .blog-search button:hover {
            background: var(--secondary);
            transform: translateY(-1px);
        }
        
        /* No Posts Message */
        .no-posts {
            background: white;
            border-radius: 16px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        .no-posts i {
            font-size: 4rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .no-posts h3 {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .no-posts p {
            color: var(--gray);
            max-width: 500px;
            margin: 0 auto 1.5rem;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .blog-header {
                padding: 3rem 0;
            }
            
            .blog-header h1 {
                font-size: 2.5rem;
            }
            
            .blog-card .card-img-top {
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/header.php'; ?>

    <!-- Blog Header -->
    <header class="blog-header">
        <div class="container text-center">
            <h1>Our Blog</h1>
            <p class="lead">Latest insights, tips, and news from our IT experts</p>
        </div>
    </header>

    <!-- Blog Posts -->
    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="alert alert-info">
                No blog posts found. Check back soon for new content!
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card h-100">
                            <?php if (!empty($post['featured_image'])): ?>
                                <img src="/uploads/blog/<?php echo htmlspecialchars($post['featured_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php else: ?>
                                <div class="bg-light text-center py-5">
                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <!-- <a href="/blog/post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a> -->
                                    <a href="/blog/<?php echo $post['id']; ?>/<?php echo urlencode(str_replace(' ', '-', strtolower($post['title']))); ?>" class="text-decoration-none text-dark">
    <?php echo htmlspecialchars($post['title']); ?>
</a>
                                </h5>
                                <div class="card-text">
                                    <?php echo substr(strip_tags($post['content']), 0, 120) . '...'; ?>
                                </div>
                                <div class="mt-auto">
                                    <a href="/blog/post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                                    <div class="blog-meta">
                                        <!-- <span><i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($post['author_name']); ?></span> -->
                                          <span><i class="fas fa-user me-1"></i>IT Sahayata</span>
                                        <span><i class="fas fa-calendar me-1"></i> <?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Blog pagination" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <!-- <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>IT Sahayta</h5>
                    <p>Your trusted partner for all IT support needs.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li><a href="/services.php">Services</a></li>
                        <li><a href="/blog/index.php">Blog</a></li>
                        <li><a href="/contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Connect With Us</h5>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-dark"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> IT Sahayta. All rights reserved.</p>
            </div>
        </div>
    </footer> -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/footer.php'; ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>