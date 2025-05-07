<?php
// Initialize session
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Check if post ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /blog/index.php");
    exit;
}

$post_id = $_GET['id'];

// Get post details
$stmt = $pdo->prepare("
    SELECT p.*, COALESCE(bu.name, u.name) as author_name 
    FROM blog_posts p 
    LEFT JOIN blog_users bu ON p.author_id = bu.id 
    LEFT JOIN users u ON p.author_id = u.id 
    WHERE p.id = ? AND p.status = 'published'
");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

// If post not found or not published, redirect to blog index
if (!$post) {
    header("Location: /blog/index.php");
    exit;
}

// Increment view count
$update_views = $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
$update_views->execute([$post_id]);

// Get related posts (same author or similar title)
$stmt = $pdo->prepare("
    SELECT p.id, p.title, p.featured_image, p.created_at 
    FROM blog_posts p 
    WHERE p.id != ? AND p.status = 'published' AND 
    (p.author_id = ? OR p.title LIKE ?) 
    ORDER BY p.created_at DESC 
    LIMIT 3
");
$similar_title = '%' . substr($post['title'], 0, 20) . '%';
$stmt->execute([$post_id, $post['author_id'], $similar_title]);
$related_posts = $stmt->fetchAll();

// Format post date
$post_date = date('F j, Y', strtotime($post['created_at']));

// Generate SEO-friendly meta description
$meta_description = substr(strip_tags($post['content']), 0, 160);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?php echo htmlspecialchars($post['title']); ?> | IT Sahayta Blog</title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?> | IT Sahayta Blog">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if (!empty($post['featured_image'])): ?>
    <meta property="og:image" content="<?php echo "https://$_SERVER[HTTP_HOST]/uploads/blog/" . htmlspecialchars($post['featured_image']); ?>">
    <?php endif; ?>
   
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($post['title']); ?> | IT Sahayta Blog">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if (!empty($post['featured_image'])): ?>
    <meta property="twitter:image" content="<?php echo "https://$_SERVER[HTTP_HOST]/uploads/blog/" . htmlspecialchars($post['featured_image']); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL for SEO -->
    <link rel="canonical" href="<?php echo "https://$_SERVER[HTTP_HOST]/blog/post.php?id=$post_id"; ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    /* रीसेट और बेसिक स्टाइल्स */
    *, *::before, *::after {
        box-sizing: border-box;
    }
    
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --primary-light: #e0e7ff;
        --secondary: #3f37c9;
        --dark: #1e293b;
        --light: #f8fafc;
        --gray: #94a3b8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --border-radius: 16px;
        --box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        --transition: all 0.3s ease;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fa;
        color: var(--dark);
        line-height: 1.7;
    }
    
    /* नेविगेशन बार फिक्स */
    .navbar {
        margin: 0 !important;
        padding: 0.5rem 1rem !important;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }
    
    /* ब्लॉग हेडर */
    .blog-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 2.5rem 0;
        position: relative;
        overflow: hidden;
        margin-top: 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
    
    /* ब्रेडक्रम्ब नेविगेशन */
  /* ब्रेडक्रम्ब नेविगेशन */
.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    z-index: 2;
    position: relative;
    display: flex;
    align-items: center;
    gap: 5px;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.breadcrumb-item a:hover {
    color: white;
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}

.breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.8);
    padding: 8px 15px;
    border-radius: 30px;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px);
    font-weight: 500;
}

.breadcrumb-item+.breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.9);
    content: "→";
    padding: 0 8px;
    font-size: 1.2em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    animation: arrowPulse 2s infinite;
}

@keyframes arrowPulse {
    0% { transform: translateX(0); }
    50% { transform: translateX(3px); }
    100% { transform: translateX(0); }
}
    
    /* मुख्य कंटेंट कंटेनर */
    .blog-content {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .blog-content::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, transparent 50%, rgba(67, 97, 238, 0.05) 50%);
        border-radius: 0 0 0 150px;
        z-index: 0;
    }
    
    .blog-content h1 {
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        line-height: 1.3;
        color: var(--dark);
        position: relative;
    }
    
    .blog-content h2, .blog-content h3 {
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--dark);
        position: relative;
    }
    
    .blog-content h2::before {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), transparent);
        border-radius: 3px;
    }
    
    .blog-content p {
        margin-bottom: 1.5rem;
        font-size: 1.05rem;
        color: #4b5563;
    }
    
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    
    .blog-content a {
        color: var(--primary);
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: var(--transition);
        font-weight: 500;
    }
    
    .blog-content a:hover {
        border-bottom-color: var(--primary);
        color: var(--primary-dark);
    }
    
    .blog-content blockquote {
        border-left: 4px solid var(--primary);
        padding: 1.2rem 1.5rem;
        background-color: var(--primary-light);
        margin: 1.8rem 0;
        border-radius: 0 12px 12px 0;
        font-style: italic;
        position: relative;
    }
    
    .blog-content blockquote::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: 10px;
        font-size: 3rem;
        color: rgba(67, 97, 238, 0.2);
        font-family: Georgia, serif;
    }
    
    .blog-content code {
        background-color: #f1f5f9;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9rem;
        color: var(--secondary);
        font-family: 'Consolas', monospace;
    }
    
    .blog-content pre {
        background-color: #1e293b;
        color: #f8fafc;
        padding: 1.5rem;
        border-radius: 12px;
        overflow-x: auto;
        margin: 1.5rem 0;
        position: relative;
    }
    
    .blog-content pre::before {
        content: 'Code';
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(255,255,255,0.1);
        padding: 0.2rem 0.8rem;
        font-size: 0.7rem;
        border-radius: 0 12px 0 8px;
        color: rgba(255,255,255,0.7);
    }
    
    .blog-content pre code {
        background-color: transparent;
        color: inherit;
        padding: 0;
        font-size: 0.9rem;
    }
    
    /* फीचर्ड इमेज */
    .blog-featured-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: var(--transition);
        border: 5px solid white;
    }
    
    .blog-featured-image:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    /* ब्लॉग मेटा इंफॉर्मेशन */
    .blog-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--gray);
        font-size: 0.95rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        position: relative;
    }
    
    .blog-meta::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), transparent);
        border-radius: 3px;
    }
    
    .blog-meta span {
        display: inline-flex;
        align-items: center;
        margin-right: 1rem;
    }
    
    .blog-meta i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .view-counter {
        display: inline-flex;
        align-items: center;
        background-color: var(--primary-light);
        color: var(--primary);
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.1);
        transition: var(--transition);
    }
    
    .view-counter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }
    
    .view-counter i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    /* सोशल शेयरिंग */
    .social-share {
        display: flex;
        gap: 12px;
        margin: 2.5rem 0;
    }
    
    .social-share a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        color: white;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    
    .social-share a::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        transform: translateY(100%);
        transition: var(--transition);
    }
    
    .social-share a:hover::before {
        transform: translateY(0);
    }
    
    .social-share .facebook {
        background-color: #3b5998;
    }
    
    .social-share .twitter {
        background-color: #1da1f2;
    }
    
    .social-share .linkedin {
        background-color: #0077b5;
    }
    
    .social-share .whatsapp {
        background-color: #25d366;
    }
    
    .social-share a:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    /* संबंधित लेख */
    .card {
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        margin-bottom: 2rem;
        background: white;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 1.2rem 1.5rem;
        font-weight: 600;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .card-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.1);
        border-radius: 0 0 0 80px;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .related-post {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        position: relative;
    }
    
    .related-post::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), transparent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    
    .related-post:hover::after {
        transform: scaleX(1);
    }
    
    .related-post:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    
    .related-post img {
        height: 150px;
        object-fit: cover;
        transition: all 0.5s;
        width: 100%;
    }
    
    .related-post:hover img {
        transform: scale(1.05);
    }
    
    .related-post h6 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        color: var(--dark);
        transition: var(--transition);
        padding: 0.8rem;
    }
    
    .related-post:hover h6 {
        color: var(--primary);
    }
    
    /* हेल्प कार्ड */
    .card .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
        border-radius: 8px;
        padding: 0.8rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .card .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }
    
    .card .btn-primary:hover::before {
        left: 100%;
    }
    
    .card .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
    }
    

    
    /* रेस्पॉन्सिव एडजस्टमेंट्स */
    @media (max-width: 991px) {
        .blog-content h1 {
            font-size: 2rem;
        }
        
        .blog-content {
            padding: 1.5rem;
        }
        
        .sticky-top {
            position: relative;
            top: 0;
        }
    }
    
    @media (max-width: 767px) {
        .blog-header {
            padding: 2rem 0;
        }
        
        .blog-content h1 {
            font-size: 1.8rem;
        }
        
        .blog-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .social-share {
            justify-content: center;
        }
    }
    
    /* कंटेंट टाइपोग्राफी एन्हांसमेंट्स */
    .blog-content-body {
        font-size: 1.05rem;
        line-height: 1.8;
        position: relative;
        z-index: 1;
    }
    
    .blog-content-body h2 {
        font-size: 1.8rem;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        color: var(--dark);
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .blog-content-body h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary);
        border-radius: 3px;
    }
    
    .blog-content-body h3 {
        font-size: 1.5rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--dark);
    }
    
    .blog-content-body img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: var(--transition);
        border: 5px solid white;
    }
    
    .blog-content-body img:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .blog-content-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 2rem 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .blog-content-body table th {
        background-color: var(--primary-light);
        color: var(--primary);
        font-weight: 600;
        text-align: left;
        padding: 1rem;
    }
    
    .blog-content-body table td {
        padding: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .blog-content-body table tr:nth-child(even) {
        background-color: #f8fafc;
    }
    
    /* पेज कंटेनर फिक्स */
    .py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }
    
    /* एनिमेशन इफेक्ट्स */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .blog-content {
        animation: fadeIn 0.5s ease-out;
    }
    
    .card {
        animation: fadeIn 0.5s ease-out 0.2s;
        animation-fill-mode: both;
    }
</style>
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/header.php'; ?>

    <!-- Blog Header -->
       <!-- Blog Header -->
       <header class="blog-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="/blog/index.php" class="text-white">Blog</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page"><?php echo htmlspecialchars($post['title']); ?></li>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Blog Content -->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <article class="blog-content">
                    <h1 class="mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
                    
                    <div class="blog-meta">
                        <div>
                            <!-- <span><i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($post['author_name']); ?></span> -->

                             <span><i class="fas fa-user me-1"></i>IT Sahayata</span>
                            <span class="ms-3"><i class="fas fa-calendar me-1"></i> <?php echo $post_date; ?></span>
                        </div>
                        <div class="view-counter">
                            <i class="fas fa-eye"></i> <?php echo number_format($post['views']); ?> views
                        </div>
                    </div>
                    
                    <?php if (!empty($post['featured_image'])): ?>
                        <img src="/uploads/blog/<?php echo htmlspecialchars($post['featured_image']); ?>" class="blog-featured-image" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php endif; ?>
                    
                    <div class="blog-content-body">
                        <?php echo $post['content']; ?>
                    </div>
                    
                    <!-- Social Sharing -->
                    <div class="mt-5">
                        <h5>Share this article:</h5>
                        <div class="social-share">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&title=<?php echo urlencode($post['title']); ?>" target="_blank" class="linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($post['title'] . " - https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" target="_blank" class="whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="sticky-top" style="top: 2rem;">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Related Articles</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($related_posts)): ?>
                                <p class="text-muted">No related articles found.</p>
                            <?php else: ?>
                                <?php foreach ($related_posts as $related): ?>
                                    <div class="mb-3">
                                        <a href="/blog/post.php?id=<?php echo $related['id']; ?>" class="text-decoration-none">
                                            <div class="row g-0">
                                                <?php if (!empty($related['featured_image'])): ?>
                                                <div class="col-4">
                                                    <img src="/uploads/blog/<?php echo htmlspecialchars($related['featured_image']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($related['title']); ?>">
                                                </div>
                                                <?php endif; ?>
                                                <div class="<?php echo !empty($related['featured_image']) ? 'col-8 ps-3' : 'col-12'; ?>">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($related['title']); ?></h6>
                                                    <small class="text-muted"><?php echo date('M j, Y', strtotime($related['created_at'])); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Need Help?</h5>
                        </div>
                        <div class="card-body">
                            <p>Our IT experts are ready to assist you with any technical issues.</p>
                            <a href="../views/contact.php" class="btn btn-primary w-100">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/footer.php'; ?>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
