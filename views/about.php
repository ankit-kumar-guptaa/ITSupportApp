<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | IT Sahayata - Professional IT Support Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #2e59d9;
            --secondary:rgb(52, 109, 232);
            --dark: #2e3a4d;
            --light: #f8f9fc;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        h1, h2, h3, h4 {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Hero Section */
        .hero-about {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.85) 0%, rgba(63, 57, 173, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 150px 0 120px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-about::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="%23f8f9fc"></path></svg>');
            background-size: cover;
            transform: rotate(180deg);
            z-index: 1;
        }
        .hero-title {
            font-size: 4rem;
            text-shadow: 0 3px 6px rgba(0,0,0,0.16);
            line-height: 1.2;
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        /* G20 Section */
        .g20-section {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }
        .g20-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/G20_logo_%282023%29.svg/1200px-G20_logo_%282023%29.svg.png') no-repeat;
            background-size: contain;
            opacity: 0.1;
            z-index: 0;
        }
        .g20-badge {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #d4af37, #f9d423);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
            z-index: 2;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .g20-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .g20-img {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 550px;
        }
        .g20-img:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .g20-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* New Creative Sections */
        .values-section {
            background: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') fixed;
            background-size: cover;
            position: relative;
            color: white;
        }
        .values-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.9) 0%, rgba(69 81 118 / 85%) 100%);
        }
        .value-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s;
            height: 100%;
        }
        .value-card:hover {
            transform: translateY(-10px);
            background: rgba(255,255,255,0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .tech-stack {
            background: var(--light);
        }
        .tech-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            text-align: center;
            height: 100%;
        }
        .tech-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .tech-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient);
            color: white;
            font-size: 30px;
            border-radius: 20px;
        }
        
        .testimonial-section {
            background: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80') fixed;
            background-size: cover;
            position: relative;
            color: white;
        }
        .testimonial-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(46, 89, 217, 0.9) 0%, rgba(69 81 118 / 85%) 100%);
        }
        .testimonial-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s;
            height: 100%;
        }
        .testimonial-card:hover {
            transform: translateY(-10px);
            background: rgba(255,255,255,0.2);
        }
        .client-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            margin: 0 auto 20px;
        }
        
        .impact-section .impact-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }
        .impact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .impact-card img {
            height: 200px;
            object-fit: cover;
        }
        .impact-card .card-body {
            position: relative;
            z-index: 2;
        }
        .impact-badge {
            position: absolute;
            top: -20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Navigation -->


    <!-- Hero Section -->
    <section class="hero-about text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="hero-title fw-bold mb-4 animate__animated animate__fadeInDown">Transforming IT Support <br>Through Innovation</h1>
            <p class="lead fs-3 animate__animated animate__fadeInUp animate__delay-1s">Your trusted technology partner since 2015</p>
            <a href="#our-story" class="btn btn-light btn-lg mt-4 px-4 py-3 animate__animated animate__fadeInUp animate__delay-2s">
                <i class="fas fa-arrow-down me-2"></i> Explore Our Journey
            </a>
        </div>
    </section>

    <!-- About Content -->
    <section id="our-story" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="IT Sahayata Team" 
                             class="img-fluid rounded-4 shadow floating">
                        <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-3 shadow m-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-2">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Best IT Support 2023</h6>
                                    <small class="text-muted">Tech Magazine Award</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="badge bg-primary mb-3">Our Story</span>
                    <h2 class="fw-bold mb-4">From Humble Beginnings to Industry Leaders</h2>
                    <p class="lead">IT Sahayata began in 2015 as a small IT repair shop in New Delhi with just 3 technicians and a vision to revolutionize IT support in India.</p>
                    <p>Today, we're proud to be one of the fastest-growing IT support providers in the country, with offices in Delhi and Lucknow, serving over 500 clients nationwide. Our team of 50+ certified professionals brings an average of 8 years of experience across diverse industries.</p>
                    <p>What truly sets us apart is our customer-first philosophy. We don't just fix problems - we build long-term partnerships that help businesses thrive in an increasingly digital world.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-users text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">50+</h4>
                                    <p class="mb-0 text-muted">Certified Professionals</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-smile text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">98%</h4>
                                    <p class="mb-0 text-muted">Client Satisfaction</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="values-section py-5 position-relative">
        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="text-center mb-5">
                <span class="badge bg-white text-primary mb-3">Our DNA</span>
                <h2 class="fw-bold text-white mb-3">Core Values That Drive Us</h2>
                <p class="lead text-white opacity-75">The principles that guide every decision we make</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <div class="bg-white text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-heart fs-3"></i>
                            </div>
                        </div>
                        <h4 class="text-center mb-3">Passion for Excellence</h4>
                        <p class="text-center">We're obsessed with delivering exceptional service that exceeds expectations. Good enough is never good enough for us.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <div class="bg-white text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-lightbulb fs-3"></i>
                            </div>
                        </div>
                        <h4 class="text-center mb-3">Innovative Thinking</h4>
                        <p class="text-center">We constantly challenge the status quo to find better, smarter ways to solve your IT challenges.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <div class="bg-white text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-handshake fs-3"></i>
                            </div>
                        </div>
                        <h4 class="text-center mb-3">Integrity First</h4>
                        <p class="text-center">We do what's right, not what's easy. Honesty and transparency are at the heart of everything we do.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <div class="bg-white text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-users fs-3"></i>
                            </div>
                        </div>
                        <h4 class="text-center mb-3">Collaborative Spirit</h4>
                        <p class="text-center">We believe the best solutions come from teamwork - both within our company and with our clients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- G20 Summit Participation -->
    <section class="g20-section py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="g20-gallery">
                        <!-- Replace these with your actual G20 images -->
                        <div class="g20-img">
                            <img src="https://media.licdn.com/dms/image/v2/D4D22AQEO4q6WP-HI0Q/feedshare-shrink_800/feedshare-shrink_800/0/1694801332644?e=1749081600&v=beta&t=17MjazCta4ufllvbFbooDeiwOjrjpMQ2j9tp6IVz--Y" alt="IT Sahayata at G20">
                        </div>
                        <div class="g20-img">
                            <img src="https://media.licdn.com/dms/image/v2/D4D22AQF1PuR-bsOptw/feedshare-shrink_2048_1536/feedshare-shrink_2048_1536/0/1694801837838?e=1749081600&v=beta&t=h4xRG3MKCaRVXJWQ2BjrwoDL1OuIqouQ-RpK2US-W0U" alt="Our Team at G20">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 position-relative">
                    <div class="g20-badge">
                        <i class="fas fa-award fs-4"></i>
                    </div>
                    <span class="badge bg-primary mb-3">Proud Achievement</span>
                    <h2 class="fw-bold mb-4">Official IT Support Provider for G20 Summit 2023</h2>
                    <p class="lead">A milestone that reflects our technical expertise and commitment to excellence.</p>
                    <p>Being selected to provide IT support for this prestigious global event was both an honor and a testament to our capabilities. Our team worked tirelessly to ensure flawless technology operations throughout the summit.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-laptop-code text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">150+</h4>
                                        <p class="mb-0 text-muted">Devices Supported</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-clock text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">15 min</h4>
                                        <p class="mb-0 text-muted">Avg Response Time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-check-circle text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">100%</h4>
                                        <p class="mb-0 text-muted">Uptime Achieved</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-users text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">25</h4>
                                        <p class="mb-0 text-muted">Technicians Deployed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Stack Section -->
    <section class="tech-stack py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-3">Our Expertise</span>
                <h2 class="fw-bold mb-3">Technology Stack We Master</h2>
                <p class="lead text-muted">Comprehensive solutions across all major platforms and technologies</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fab fa-windows"></i>
                        </div>
                        <h6>Windows</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fab fa-apple"></i>
                        </div>
                        <h6>macOS</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fab fa-linux"></i>
                        </div>
                        <h6>Linux</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h6>Networking</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <h6>Cloud</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tech-item">
                        <div class="tech-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h6>Security</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section py-5 position-relative">
        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="text-center mb-5">
                <span class="badge bg-white text-primary mb-3">Client Voices</span>
                <h2 class="fw-bold text-white mb-3">What Our Clients Say</h2>
                <p class="lead text-white opacity-75">Don't just take our word for it - hear from those we've served</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <!-- <div class="text-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="client-img" alt="Client">
                        </div> -->
                        <div class="text-center mb-4">
                            <i class="fas fa-quote-left text-primary fs-1 opacity-25"></i>
                        </div>
                        <p class="text-center mb-4">"IT Sahayata transformed our IT infrastructure. Their team resolved issues we'd struggled with for years in just days. The G20 selection proves their capabilities."</p>
                        <h5 class="text-center mb-1">Rajesh Mehta</h5>
                        <p class="text-center text-white opacity-75">CEO, TechNova Solutions</p>
                        <div class="text-center mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <!-- <div class="text-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="client-img" alt="Client">
                        </div> -->
                        <div class="text-center mb-4">
                            <i class="fas fa-quote-left text-primary fs-1 opacity-25"></i>
                        </div>
                        <p class="text-center mb-4">"Their G20 performance was flawless. We've used their services since 2018 and they've never disappointed. Fast, professional, and truly care about our business."</p>
                        <h5 class="text-center mb-1">Priya Chatterjee</h5>
                        <p class="text-center text-white opacity-75">Director, EduTech Innovations</p>
                        <div class="text-center mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="testimonial-card">
                        <!-- <div class="text-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="client-img" alt="Client">
                        </div> -->
                        <div class="text-center mb-4">
                            <i class="fas fa-quote-left text-primary fs-1 opacity-25"></i>
                        </div>
                        <p class="text-center mb-4">"After seeing their work at the G20 summit, we knew they were the right partner. They've reduced our IT costs by 40% while improving reliability dramatically."</p>
                        <h5 class="text-center mb-1">Amit Patel</h5>
                        <p class="text-center text-white opacity-75">CTO, FinSecure</p>
                        <div class="text-center mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="impact-section py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-3">Our Impact</span>
                <h2 class="fw-bold mb-3">Transforming Businesses</h2>
                <p class="lead text-muted">Real results that make a difference</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="impact-card">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             class="card-img-top" 
                             alt="Business Transformation">
                        <div class="card-body">
                            <div class="impact-badge">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4 class="mb-3">Operational Efficiency</h4>
                            <p>Average 65% reduction in IT-related downtime for our clients, leading to significant productivity gains.</p>
                            <a href="#" class="btn btn-link text-primary ps-0">Read Case Study <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="impact-card">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1415&q=80" 
                             class="card-img-top" 
                             alt="Security Improvement">
                        <div class="card-body">
                            <div class="impact-badge">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h4 class="mb-3">Security Enhancement</h4>
                            <p>100% of our clients experience zero successful cyber attacks after implementing our security protocols.</p>
                            <a href="#" class="btn btn-link text-primary ps-0">Read Case Study <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="impact-card">
                        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" 
                             class="card-img-top" 
                             alt="Cost Savings">
                        <div class="card-body">
                            <div class="impact-badge">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                            <h4 class="mb-3">Cost Optimization</h4>
                            <p>Average 40% reduction in IT operational costs while improving service quality and reliability.</p>
                            <a href="#" class="btn btn-link text-primary ps-0">Read Case Study <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">Ready to Transform Your IT Experience?</h2>
                    <p class="lead mb-0">Join 500+ businesses who trust IT Sahayata for their technology needs.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="contact.php" class="btn btn-light btn-lg px-4 py-3 me-3">
                        <i class="fas fa-phone-alt me-2"></i> Contact Us
                    </a>
                    <a href="services.php" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-laptop-code me-2"></i> Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</body>
</html>