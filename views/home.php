<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Professional IT Support Services in India | Hardware, Software & Network Solutions</title>
    <meta name="description" content="IT Sahayta provides 24/7 professional IT support services for businesses & individuals. Expert solutions for hardware repair, software issues, and network setup. Get instant help now!">
    <meta name="keywords" content="IT support services in Lucknow, IT support services in Delhi, Computer repair services Lucknow, Computer repair services Delhi, Laptop repair services Lucknow, Laptop repair services Delhi, Desktop repair services Lucknow, Desktop repair services Delhi, On-site IT support Lucknow, On-site IT support Delhi, Motherboard repair Lucknow, Motherboard repair Delhi, RAM upgrade services Lucknow, RAM upgrade services Delhi, Hard drive replacement Lucknow, Hard drive replacement Delhi, SSD installation services Lucknow, SSD installation services Delhi, Power supply repair Lucknow, Power supply repair Delhi, Operating system installation Lucknow, Operating system installation Delhi, Virus removal services Lucknow, Virus removal services Delhi, Software troubleshooting Lucknow, Software troubleshooting Delhi, Driver installation services Lucknow, Driver installation services Delhi, Application support services Lucknow, Application support services Delhi, Wi-Fi setup services Lucknow, Wi-Fi setup services Delhi, Network troubleshooting Lucknow, Network troubleshooting Delhi, VPN configuration services Lucknow, VPN configuration services Delhi, Router installation services Lucknow, Router installation services Delhi, Network security services Lucknow, Network security services Delhi, Home IT support Lucknow, Home IT support Delhi, Remote IT support Lucknow, Remote IT support Delhi, Home office setup services Lucknow, Home office setup services Delhi, Data backup services Lucknow, Data backup services Delhi, IT consultation services Lucknow, IT consultation services Delhi">
    <?php include "assets.php"?>

    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js"></script>
    
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- Custom Styles -->
    <style>
        /* Base Styles */
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-light: #e2e8f0;
            --border-medium: #cbd5e1;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 15px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.15);
            --shadow-primary: 0 4px 12px rgba(67, 97, 238, 0.2);
            --shadow-primary-lg: 0 8px 15px rgba(67, 97, 238, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
            background-color: #ffffff;
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            background: linear-gradient(to right, #1e293b, #4361ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 800px;
            margin: 2rem auto 4rem;
        }
        
       

     

        /* Process Section */
        .process-section {
            background-color: #f8fafc;
            position: relative;
            overflow: hidden;
        }

        .process-timeline {
            position: relative;
        }

        .process-timeline::before {
            content: '';
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 2px;
            background: var(--border-light);
            z-index: 0;
        }

        .process-step {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .process-step:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .process-number {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .process-step:hover .process-number {
            transform: scale(1.1);
            background: var(--primary-dark);
        }

        .process-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .process-description {
            color: var(--text-light);
        }
        
        .process-features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .process-features span {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .process-features span i {
            margin-right: 5px;
            font-size: 0.8rem;
        }

        /* Industry Solutions Section */
        .industry-section {
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .industry-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.5s ease;
            height: 250px;
            margin-bottom: 30px;
        }

        .industry-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .industry-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: all 0.5s ease;
        }

        .industry-card:hover .industry-bg {
            transform: scale(1.1);
        }

        .industry-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .industry-card:hover .industry-overlay {
            background: linear-gradient(to top, rgba(67, 97, 238, 0.8) 0%, rgba(67, 97, 238, 0.4) 100%);
        }

        .industry-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .industry-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .industry-card:hover .industry-description {
            max-height: 100px;
            opacity: 1;
        }

        .industry-link {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .industry-link:hover {
            gap: 0.8rem;
            color: white;
        }

        /* Digital Guardian Section */
        .digital-guardian {
            background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(121, 162, 220) 100%);
            color: black;
            position: relative;
            overflow: hidden;
        }

        .digital-guardian::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .guardian-content {
            position: relative;
            z-index: 1;
        }

        .guardian-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #ffffff, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .guardian-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .guardian-features {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem;
        }

        .guardian-features li {
            padding: 0.8rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
        }

        .guardian-features li:last-child {
            border-bottom: none;
        }

        .guardian-features i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: #93c5fd;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.2rem;
        }

        .guardian-image {
            position: relative;
        }

        .guardian-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        /* IT Solutions Showcase */
        .solutions-showcase {
            background-color: #f8fafc;
            position: relative;
            overflow: hidden;
        }

        .showcase-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.5s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .showcase-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .showcase-image {
            height: 200px;
            overflow: hidden;
        }

        .showcase-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .showcase-card:hover .showcase-image img {
            transform: scale(1.1);
        }

        .showcase-content {
            padding: 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .showcase-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .showcase-description {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .showcase-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .showcase-link:hover {
            color: var(--primary-dark);
            gap: 0.8rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.2;
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: var(--primary-color);
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: var(--primary-dark);
        }

        .btn-outline-white {
            background: transparent;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: white;
        }

        /* Parallax Sections */
        .parallax-section {
            position: relative;
            height: 400px;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .parallax-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30, 41, 59, 0.7);
        }

        .parallax-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 0 2rem;
        }

        .parallax-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .parallax-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Styles */
        @media (max-width: 991px) {
            .section-padding {
                padding: 70px 0;
            }

            .hero-section {
                min-height: auto;
                padding: 100px 0 70px;
            }

            .hero-title {
                font-size: 3rem;
            }

            .hero-image {
                margin-top: 3rem;
            }

            .process-container::before {
                display: none;
            }

            .parallax-section {
                background-attachment: scroll;
                height: 350px;
            }

            .parallax-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 767px) {
            .section-padding {
                padding: 50px 0;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-cta {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-primary, .btn-secondary, .btn-white, .btn-outline-white {
                width: 100%;
                justify-content: center;
            }

            .guardian-title {
                font-size: 2.2rem;
            }

            .guardian-image {
                margin-top: 2rem;
            }

            .parallax-section {
                height: 300px;
            }

            .parallax-title {
                font-size: 2rem;
            }

            .parallax-description {
                font-size: 1rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>
    <?php include 'loader.php'; ?>



    
<!-- Hero Section - IT Sahayata Light Theme -->
<section class="it-hero-light" id="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="it-hero-content-light">
                    <!-- Trust badge -->
                    <div class="it-trust-badge-light">
                        <i class="fas fa-robot"></i>
                        <span>AI + Expert Support Available</span>
                    </div>
                    
                    <!-- Main heading -->
                    <h1 class="it-hero-title-light">
                        आपकी हर <span class="it-highlight-light">IT समस्या</span> का 
                        <span class="it-ai-text-light">Smart समाधान</span>
                    </h1>
                    
                    <p class="it-hero-subtitle-light">
                        पहले AI से instant solution पाएं, फिर जरूरत हो तो हमारे experts 
                        आपके यहाँ आकर personally problem solve करते हैं। Complete IT support!
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="it-hero-actions-light">
                        <a href="/views/ai_chat.php" target="_blank" class="it-btn-light it-btn-ai-light">
                            <div class="it-btn-content-light">
                                <i class="fas fa-robot it-btn-icon-light"></i>
                                <div class="it-btn-text-light">
                                    <span class="it-btn-main-light">AI से Chat करें</span>
                                    <small class="it-btn-sub-light">Instant Solution</small>
                                </div>
                            </div>
                            <div class="it-sparkle-effect-light"></div>
                        </a>
                        
                        <a href="tel:+91-7703823008" class="it-btn-light it-btn-expert-light">
                            <div class="it-btn-content-light">
                                <i class="fas fa-user-tie it-btn-icon-light"></i>
                                <div class="it-btn-text-light">
                                    <span class="it-btn-main-light">Expert Call करें</span>
                                    <small class="it-btn-sub-light">7703823008</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Service Highlights -->
                    <div class="it-service-highlights-light">
                        <div class="it-service-item-light">
                            <i class="fas fa-laptop"></i>
                            <span>Computer Repair</span>
                        </div>
                        <div class="it-service-item-light">
                            <i class="fas fa-server"></i>
                            <span>Server Setup</span>
                        </div>
                        <div class="it-service-item-light">
                            <i class="fas fa-wifi"></i>
                            <span>Network Solutions</span>
                        </div>
                        <div class="it-service-item-light">
                            <i class="fas fa-shield-alt"></i>
                            <span>Cybersecurity</span>
                        </div>
                    </div>
                    
                    <!-- Key Metrics -->
                    <div class="it-metrics-light">
                        <div class="it-metric-card-light">
                            <div class="it-metric-value-light">5sec</div>
                            <div class="it-metric-label-light">AI Response</div>
                        </div>
                        <div class="it-metric-card-light">
                            <div class="it-metric-value-light">30min</div>
                            <div class="it-metric-label-light">Expert Reach</div>
                        </div>
                        <div class="it-metric-card-light">
                            <div class="it-metric-value-light">24/7</div>
                            <div class="it-metric-label-light">Available</div>
                        </div>
                        <div class="it-metric-card-light">
                            <div class="it-metric-value-light">99%</div>
                            <div class="it-metric-label-light">Success Rate</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="it-hero-visual-light">
                    <!-- Main Image -->
                    <div class="it-main-image-light">
                        <img src="../assets/hero.png" alt="IT Sahayata - Professional IT Support" class="it-hero-img-light">
                        <div class="it-image-overlay-light"></div>
                    </div>
                    
                    <!-- Floating Tech Icons -->
                    <div class="it-tech-float-light it-float-1-light">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div class="it-tech-float-light it-float-2-light">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="it-tech-float-light it-float-3-light">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="it-tech-float-light it-float-4-light">
                        <i class="fas fa-cogs"></i>
                    </div>
                    
                    <!-- Success Badge -->
                    <div class="it-success-badge-light">
                        <i class="fas fa-check-circle"></i>
                        <div class="it-badge-text-light">
                            <strong>500+</strong>
                            <span>Problems Solved</span>
                        </div>
                    </div>
                    
                    <!-- Live Stats -->
                    <div class="it-live-stats-light">
                        <div class="it-stat-item-light">
                            <div class="it-stat-dot-light"></div>
                            <span>AI solving issue now...</span>
                        </div>
                        <div class="it-stat-item-light">
                            <div class="it-stat-dot-light"></div>
                            <span>Expert on the way...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Smart Support Flow -->
        <div class="it-support-flow-light">
            <h3 class="it-flow-title-light">हमारा Smart Support Process</h3>
            <div class="it-flow-steps-light">
                <div class="it-step-light">
                    <div class="it-step-icon-light">
                        <i class="fas fa-comments"></i>
                        <span class="it-step-number-light">1</span>
                    </div>
                    <div class="it-step-content-light">
                        <h4>AI से Chat करें</h4>
                        <p>अपनी problem बताएं, instant solution पाएं</p>
                    </div>
                </div>
                
                <div class="it-step-arrow-light">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="it-step-light">
                    <div class="it-step-icon-light">
                        <i class="fas fa-brain"></i>
                        <span class="it-step-number-light">2</span>
                    </div>
                    <div class="it-step-content-light">
                        <h4>Smart Analysis</h4>
                        <p>AI आपकी problem analyze करके solution देगा</p>
                    </div>
                </div>
                
                <div class="it-step-arrow-light">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="it-step-light">
                    <div class="it-step-icon-light">
                        <i class="fas fa-user-tie"></i>
                        <span class="it-step-number-light">3</span>
                    </div>
                    <div class="it-step-content-light">
                        <h4>Expert Support</h4>
                        <p>जरूरत हो तो expert आपके पास आएंगे</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Elements -->
    <div class="it-bg-pattern-light"></div>
    <div class="it-bg-shapes-light">
        <div class="it-shape-1"></div>
        <div class="it-shape-2"></div>
        <div class="it-shape-3"></div>
    </div>
</section>

<style>
/* IT Sahayata Hero Section - Light Theme */
.it-hero-light {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
    position: relative;
    overflow: hidden;
    color: #1a202c;
    min-height: 100vh;
    display: flex;
    align-items: center;
}

/* Enhanced Background Effects */
.it-bg-pattern-light {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 20%, rgba(79, 70, 229, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(236, 72, 153, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 40% 60%, rgba(34, 197, 94, 0.06) 0%, transparent 50%);
    z-index: 1;
}

.it-bg-shapes-light {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.it-shape-1 {
    position: absolute;
    top: 10%;
    right: 10%;
    width: 200px;
    height: 200px;
    background: linear-gradient(45deg, rgba(79, 70, 229, 0.1), rgba(236, 72, 153, 0.05));
    border-radius: 50%;
    animation: itFloatShape 8s ease-in-out infinite;
}

.it-shape-2 {
    position: absolute;
    bottom: 20%;
    left: 5%;
    width: 150px;
    height: 150px;
    background: linear-gradient(45deg, rgba(34, 197, 94, 0.1), rgba(59, 130, 246, 0.05));
    border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
    animation: itFloatShape 10s ease-in-out infinite reverse;
}

.it-shape-3 {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, rgba(245, 101, 101, 0.08), rgba(251, 191, 36, 0.05));
    border-radius: 20px;
    transform: rotate(45deg);
    animation: itRotateShape 12s linear infinite;
}

@keyframes itFloatShape {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-30px) scale(1.1); }
}

@keyframes itRotateShape {
    0% { transform: rotate(45deg); }
    100% { transform: rotate(405deg); }
}

/* Content Styles */
.it-hero-content-light {
    position: relative;
    z-index: 5;
}

.it-trust-badge-light {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 700;
    margin-bottom: 30px;
    font-size: 0.95rem;
    box-shadow: 0 8px 32px rgba(79, 70, 229, 0.25);
    animation: itPulseGlowLight 3s ease-in-out infinite;
}

@keyframes itPulseGlowLight {
    0%, 100% { 
        box-shadow: 0 8px 32px rgba(79, 70, 229, 0.25);
        transform: scale(1);
    }
    50% { 
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.35);
        transform: scale(1.02);
    }
}

.it-hero-title-light {
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 25px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    color: #1e293b;
}

.it-highlight-light {
    color: #dc2626;
    position: relative;
}

.it-highlight-light::after {
    content: '';
    position: absolute;
    bottom: 8px;
    left: 0;
    width: 100%;
    height: 12px;
    background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.2), transparent);
    z-index: -1;
    border-radius: 6px;
    animation: itHighlightShimmerLight 2s ease-in-out infinite;
}

@keyframes itHighlightShimmerLight {
    0%, 100% { opacity: 0.3; transform: scaleX(1); }
    50% { opacity: 0.6; transform: scaleX(1.1); }
}

.it-ai-text-light {
    background: linear-gradient(45deg, #4f46e5, #7c3aed, #ec4899);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: itGradientShiftLight 4s ease-in-out infinite;
    font-weight: 900;
}

@keyframes itGradientShiftLight {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.it-hero-subtitle-light {
    font-size: 1.2rem;
    color: #64748b;
    margin-bottom: 35px;
    line-height: 1.7;
    max-width: 550px;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}

/* Action Buttons */
.it-hero-actions-light {
    display: flex;
    gap: 20px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.it-btn-light {
    position: relative;
    text-decoration: none;
    border-radius: 60px;
    overflow: hidden;
    transition: all 0.4s ease;
    min-width: 240px;
    display: block;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.it-btn-content-light {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px 30px;
    position: relative;
    z-index: 2;
}

.it-btn-icon-light {
    font-size: 1.6rem;
    flex-shrink: 0;
}

.it-btn-text-light {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.it-btn-main-light {
    font-weight: 800;
    font-size: 1.1rem;
    line-height: 1.2;
}

.it-btn-sub-light {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-top: 2px;
}

/* AI Button */
.it-btn-ai-light {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
    background-size: 200% 200%;
    color: white;
    animation: itGradientMoveLight 6s ease-in-out infinite;
}

@keyframes itGradientMoveLight {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.it-sparkle-effect-light {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.4), 
        transparent);
    transition: left 0.8s ease;
}

.it-btn-ai-light:hover .it-sparkle-effect-light {
    left: 100%;
}

.it-btn-ai-light:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 45px rgba(79, 70, 229, 0.3);
}

/* Expert Button */
.it-btn-expert-light {
    background: linear-gradient(45deg, #059669, #10b981);
    color: white;
}

.it-btn-expert-light:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 45px rgba(5, 150, 105, 0.3);
}

/* Service Highlights */
.it-service-highlights-light {
    display: flex;
    gap: 25px;
    margin-bottom: 35px;
    flex-wrap: wrap;
}

.it-service-item-light {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    padding: 12px 20px;
    border-radius: 30px;
    border: 1px solid rgba(79, 70, 229, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.it-service-item-light:hover {
    background: rgba(79, 70, 229, 0.1);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.15);
}

.it-service-item-light i {
    color: #4f46e5;
    font-size: 1.2rem;
}

.it-service-item-light span {
    font-weight: 600;
    font-size: 0.9rem;
    color: #374151;
}

/* Metrics */
.it-metrics-light {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.it-metric-card-light {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(15px);
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    border: 1px solid rgba(79, 70, 229, 0.1);
    transition: all 0.3s ease;
    flex: 1;
    min-width: 100px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.it-metric-card-light:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(79, 70, 229, 0.15);
}

.it-metric-value-light {
    font-size: 1.8rem;
    font-weight: 900;
    color: #4f46e5;
    margin-bottom: 8px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.it-metric-label-light {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Hero Visual */
.it-hero-visual-light {
    position: relative;
    z-index: 3;
}

.it-main-image-light {
    position: relative;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    background: white;
    padding: 10px;
    transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
    transition: all 0.4s ease;
}

.it-main-image-light:hover {
    transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.02);
    box-shadow: 0 35px 80px rgba(0, 0, 0, 0.2);
}

.it-hero-img-light {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 20px;
}

.it-image-overlay-light {
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    background: linear-gradient(45deg, 
        rgba(79, 70, 229, 0.05) 0%, 
        transparent 50%, 
        rgba(236, 72, 153, 0.05) 100%);
    border-radius: 20px;
}

/* Floating Tech Icons */
.it-tech-float-light {
    position: absolute;
    width: 70px;
    height: 70px;
    background: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    z-index: 4;
    border: 2px solid rgba(79, 70, 229, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.it-float-1-light {
    top: 20px;
    left: 20px;
    color: #dc2626;
    animation: itFloat1Light 6s ease-in-out infinite;
}

.it-float-2-light {
    top: 40px;
    right: 30px;
    color: #4f46e5;
    animation: itFloat2Light 8s ease-in-out infinite;
}

.it-float-3-light {
    bottom: 80px;
    left: 30px;
    color: #059669;
    animation: itFloat3Light 7s ease-in-out infinite;
}

.it-float-4-light {
    bottom: 30px;
    right: 20px;
    color: #d97706;
    animation: itFloat4Light 9s ease-in-out infinite;
}

@keyframes itFloat1Light {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
}

@keyframes itFloat2Light {
    0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
    50% { transform: translateY(-25px) rotate(-10deg) scale(1.1); }
}

@keyframes itFloat3Light {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    33% { transform: translateY(-15px) rotate(5deg); }
    66% { transform: translateY(-5px) rotate(-5deg); }
}

@keyframes itFloat4Light {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(15deg); }
    75% { transform: translateY(-15px) rotate(-15deg); }
}

/* Success Badge */
.it-success-badge-light {
    position: absolute;
    top: 20px;
    right: -20px;
    background: linear-gradient(45deg, #059669, #10b981);
    color: white;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: itBadgeSlidLight 1s ease-out;
}

@keyframes itBadgeSlidLight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.it-success-badge-light i {
    font-size: 1.5rem;
}

.it-badge-text-light strong {
    display: block;
    font-size: 1.2rem;
    line-height: 1;
}

.it-badge-text-light span {
    font-size: 0.8rem;
    opacity: 0.9;
}

/* Live Stats */
.it-live-stats-light {
    position: absolute;
    bottom: -10px;
    left: -30px;
    background: white;
    color: #374151;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    z-index: 5;
    animation: itStatsSlideLight 1s ease-out 0.5s both;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

@keyframes itStatsSlideLight {
    from {
        opacity: 0;
        transform: translateX(-100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.it-stat-item-light {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 0.85rem;
    font-weight: 600;
}

.it-stat-item-light:last-child {
    margin-bottom: 0;
}

.it-stat-dot-light {
    width: 8px;
    height: 8px;
    background: linear-gradient(45deg, #4f46e5, #10b981);
    border-radius: 50%;
    animation: itDotPulseLight 2s infinite;
}

@keyframes itDotPulseLight {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.3); }
}

/* Support Flow */
.it-support-flow-light {
    margin-top: 60px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    border: 1px solid rgba(79, 70, 229, 0.1);
    position: relative;
    z-index: 5;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
}

.it-flow-title-light {
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 40px;
    color: #1e293b;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.it-flow-steps-light {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}

.it-step-light {
    flex: 1;
    text-align: center;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 20px;
    border: 1px solid rgba(79, 70, 229, 0.1);
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.it-step-light:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(79, 70, 229, 0.15);
}

.it-step-icon-light {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
    position: relative;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.it-step-number-light {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 30px;
    height: 30px;
    background: linear-gradient(45deg, #dc2626, #ef4444);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 900;
    color: white;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
}

.it-step-content-light h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1e293b;
}

.it-step-content-light p {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0;
}

.it-step-arrow-light {
    color: #4f46e5;
    font-size: 1.5rem;
    animation: itArrowPulseLight 2s ease-in-out infinite;
}

@keyframes itArrowPulseLight {
    0%, 100% { transform: translateX(0); opacity: 0.7; }
    50% { transform: translateX(10px); opacity: 1; }
}

/* Responsive Design */
@media (max-width: 1199px) {
    .it-hero-title-light {
        font-size: 3rem;
    }
    
    .it-flow-steps-light {
        gap: 20px;
    }
    
    .it-shape-1, .it-shape-2 {
        opacity: 0.6;
    }
}

@media (max-width: 991px) {
    .it-hero-light {
        padding: 60px 0;
        min-height: auto;
    }
    
    .it-flow-steps-light {
        flex-direction: column;
        gap: 30px;
    }
    
    .it-step-arrow-light {
        transform: rotate(90deg);
    }
    
    .it-hero-actions-light {
        justify-content: center;
    }
    
    .it-service-highlights-light {
        justify-content: center;
    }
    
    .it-bg-shapes-light .it-shape-1,
    .it-bg-shapes-light .it-shape-2,
    .it-bg-shapes-light .it-shape-3 {
        opacity: 0.4;
    }
}

@media (max-width: 767px) {
    .it-hero-title-light {
        font-size: 2.5rem;
    }
    
    .it-hero-actions-light {
        flex-direction: column;
        align-items: stretch;
    }
    
    .it-btn-light {
        min-width: auto;
    }
    
    .it-service-highlights-light {
        gap: 15px;
    }
    
    .it-service-item-light {
        padding: 10px 15px;
    }
    
    .it-metrics-light {
        gap: 15px;
    }
    
    .it-metric-card-light {
        min-width: 80px;
        padding: 15px;
    }
    
    .it-support-flow-light {
        padding: 25px 20px;
        margin-top: 40px;
    }
    
    .it-flow-title-light {
        font-size: 1.6rem;
    }
    
    .it-tech-float-light {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}

@media (max-width: 575px) {
    .it-hero-title-light {
        font-size: 2rem;
    }
    
    .it-hero-subtitle-light {
        font-size: 1.1rem;
    }
    
    .it-btn-content-light {
        padding: 15px 20px;
    }
    
    .it-step-icon-light {
        width: 70px;
        height: 70px;
        font-size: 1.7rem;
    }
    
    .it-step-content-light h4 {
        font-size: 1.1rem;
    }
    
    .it-step-content-light p {
        font-size: 0.85rem;
    }
    
    .it-bg-shapes-light {
        display: none;
    }
}

/* Active Service Animation */
.it-service-item-light.it-active-light {
    background: rgba(79, 70, 229, 0.15) !important;
    transform: translateY(-5px) scale(1.05) !important;
    box-shadow: 0 12px 35px rgba(79, 70, 229, 0.25) !important;
}
</style>

<script>
// IT Sahayata Hero Section JavaScript - Light Theme
document.addEventListener('DOMContentLoaded', function() {
    // Service highlights rotation effect
    const serviceItems = document.querySelectorAll('.it-service-item-light');
    let currentService = 0;
    
    function highlightService() {
        serviceItems.forEach(item => item.classList.remove('it-active-light'));
        serviceItems[currentService].classList.add('it-active-light');
        currentService = (currentService + 1) % serviceItems.length;
    }
    
    setInterval(highlightService, 2500);
    
    // Metric cards animation on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const cards = entry.target.querySelectorAll('.it-metric-card-light');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.animation = 'itSlideUpLight 0.6s ease-out forwards';
                    }, index * 200);
                });
            }
        });
    }, observerOptions);
    
    const metricsSection = document.querySelector('.it-metrics-light');
    if (metricsSection) {
        observer.observe(metricsSection);
    }
    
    // Add slide up animation
    const slideStyle = document.createElement('style');
    slideStyle.textContent = `
        @keyframes itSlideUpLight {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(slideStyle);
    
    // Enhanced hover effects for buttons
    const buttons = document.querySelectorAll('.it-btn-light');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.03)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        button.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(-5px) scale(0.98)';
        });
        
        button.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-8px) scale(1.03)';
        });
    });
    
    // Phone button click tracking
    const phoneButton = document.querySelector('a[href^="tel:"]');
    if (phoneButton) {
        phoneButton.addEventListener('click', function() {
            console.log('Expert call initiated - Light Theme');
        });
    }
    
    // AI Chat button click tracking
    const aiButton = document.querySelector('.it-btn-ai-light');
    if (aiButton) {
        aiButton.addEventListener('click', function() {
            console.log('AI Chat opened - Light Theme');
        });
    }
    
    // Dynamic stats update with different colors
    const statDots = document.querySelectorAll('.it-stat-dot-light');
    statDots.forEach((dot, index) => {
        setInterval(() => {
            dot.style.background = index === 0 ? 
                'linear-gradient(45deg, #10b981, #059669)' : 
                'linear-gradient(45deg, #dc2626, #ef4444)';
            
            setTimeout(() => {
                dot.style.background = 'linear-gradient(45deg, #4f46e5, #10b981)';
            }, 1000);
        }, 3000 + (index * 500));
    });
    
    // Smooth parallax effect for background shapes
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const shapes = document.querySelectorAll('.it-bg-shapes-light > div');
        
        shapes.forEach((shape, index) => {
            const speed = 0.5 + (index * 0.2);
            shape.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
});
</script>


   <!-- NEXT-GEN IT SERVICES SECTION -->
<section id="services" class="next-gen-services">
    <!-- Floating Tech Elements -->
    <div class="tech-elements">
        <div class="element-1"></div>
        <div class="element-2"></div>
        <div class="element-3"></div>
    </div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Innovative Solutions</span>
            <h2>
                <span class="gradient-text">Premium IT Services</span>  
                <br> 
                For Your Business Growth
            </h2>
            <div class="divider">
                <span class="line"></span>
                <span class="dot"></span>
                <span class="line"></span>
            </div>
            <p class="section-desc">
                We provide cutting-edge IT solutions to optimize performance, enhance security, and drive digital transformation.
            </p>
        </div>

        <!-- SERVICES GRID -->
        <div class="services-grid">
            <!-- 1. Hardware Support -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-desktop"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3>Hardware Support</h3>
                    <p>Expert diagnosis & repair for desktops, laptops, and servers.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Computer & laptop repairs</li>
                        <li><i class="fas fa-check-circle"></i> Server maintenance</li>
                        <li><i class="fas fa-check-circle"></i> Hardware upgrades</li>
                    </ul>
                    <a href="/views/hardware_support.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 2. Software Support -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3>Software Support</h3>
                    <p>Installation, troubleshooting & optimization for all software.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> OS installation</li>
                        <li><i class="fas fa-check-circle"></i> Software troubleshooting</li>
                        <li><i class="fas fa-check-circle"></i> Application training</li>
                    </ul>
                    <a href="/views/software_support.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 3. Network Solutions -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-network-wired"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3>Network Solutions</h3>
                    <p>Secure & scalable network infrastructure for businesses.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Network setup</li>
                        <li><i class="fas fa-check-circle"></i> Wi-Fi optimization</li>
                        <li><i class="fas fa-check-circle"></i> Security monitoring</li>
                    </ul>
                    <a href="/views/network-solutions.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 4. Cloud Services -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-cloud"></i>
                        <div class="icon-pulse"></div>
                        <span class="service-badge trending">Trending</span>
                    </div>
                    <h3>Cloud Services</h3>
                    <p>Seamless cloud migration, management & security.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Cloud migration</li>
                        <li><i class="fas fa-check-circle"></i> SaaS implementation</li>
                        <li><i class="fas fa-check-circle"></i> Cloud backup</li>
                    </ul>
                    <a href="/views/cloud_services.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 5. Cybersecurity -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                        <div class="icon-pulse"></div>
                        <span class="service-badge premium">Premium</span>
                    </div>
                    <h3>Cybersecurity</h3>
                    <p>Protection against cyber threats & data breaches.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Security audits</li>
                        <li><i class="fas fa-check-circle"></i> Threat detection</li>
                        <li><i class="fas fa-check-circle"></i> Data encryption</li>
                    </ul>
                    <a href="/views/cybersecurity.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 6. Data Management -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-database"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3>Data Management</h3>
                    <p>Secure storage, backup & recovery solutions.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Data backup</li>
                        <li><i class="fas fa-check-circle"></i> Storage solutions</li>
                        <li><i class="fas fa-check-circle"></i> Data migration</li>
                    </ul>
                    <a href="/views/data_management.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 7. Software Development -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-code"></i>
                        <div class="icon-pulse"></div>
                        <span class="service-badge hot">Hot</span>
                    </div>
                    <h3>Software Development</h3>
                    <p>Custom solutions for business automation.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Custom applications</li>
                        <li><i class="fas fa-check-circle"></i> API integration</li>
                        <li><i class="fas fa-check-circle"></i> System modernization</li>
                    </ul>
                    <a href="/views/software_development.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 8. Website Development -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-laptop-code"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3>Website Development</h3>
                    <p>Professional, responsive websites for businesses.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Responsive design</li>
                        <li><i class="fas fa-check-circle"></i> E-commerce solutions</li>
                        <li><i class="fas fa-check-circle"></i> CMS development</li>
                    </ul>
                    <a href="/views/website_development.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 9. IT Consulting -->
            <div class="service-card" data-tilt data-tilt-glare data-tilt-max-glare="0.2">
                <div class="card-bg"></div>
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-lightbulb"></i>
                        <div class="icon-pulse"></div>
                        <span class="service-badge expert">Expert</span>
                    </div>
                    <h3>IT Consulting</h3>
                    <p>Strategic IT planning for business growth.</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> IT strategy</li>
                        <li><i class="fas fa-check-circle"></i> Digital transformation</li>
                        <li><i class="fas fa-check-circle"></i> Technology roadmaps</li>
                    </ul>
                    <a href="/views/it_consulting.php" class="explore-btn">
                        <span>Explore Service</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- CTA SECTION -->
        <div class="cta-section">
            <h3>Need Custom IT Solutions?</h3>
            <p>Get in touch for a free consultation!</p>
            <div class="cta-buttons">
                <a href="/views/free-consultation.php" class="cta-btn primary">
                    <i class="fas fa-calendar-check"></i> Book Now
                </a>
                <a href="tel:+919876543210" class="cta-btn secondary">
                    <i class="fas fa-phone-alt"></i> Call Us
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* LIGHT THEME SERVICES STYLING */
.next-gen-services {
    padding: 100px 0;
    background: #f9fafb;
    position: relative;
    overflow: hidden;
}

.tech-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
}

.element-1, .element-2, .element-3 {
    position: absolute;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.05);
    filter: blur(60px);
}

.element-1 {
    width: 300px;
    height: 300px;
    top: -100px;
    left: -100px;
    animation: float 15s infinite ease-in-out;
}

.element-2 {
    width: 400px;
    height: 400px;
    bottom: -150px;
    right: -100px;
    animation: float 20s infinite ease-in-out reverse;
}

.element-3 {
    width: 200px;
    height: 200px;
    top: 50%;
    left: 30%;
    animation: float 12s infinite ease-in-out;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(20px, 20px); }
    50% { transform: translate(0, 30px); }
    75% { transform: translate(-20px, 10px); }
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-tag {
    display: inline-block;
    background: rgba(99, 102, 241, 0.1);
    color: #6366F1;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 48px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
    margin-bottom: 20px;
}

.gradient-text {
    background: linear-gradient(90deg, #6366F1, #8B5CF6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 25px;
}

.line {
    width: 50px;
    height: 2px;
    background: linear-gradient(90deg, #6366F1, #8B5CF6);
}

.dot {
    width: 8px;
    height: 8px;
    background: #8B5CF6;
    border-radius: 50%;
    box-shadow: 0 0 15px rgba(139, 92, 246, 0.3);
}

.section-desc {
    color: #64748b;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* SERVICES GRID STYLING */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
    margin-bottom: 60px;
}

.service-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(99, 102, 241, 0.1);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.4s ease;
    transform-style: preserve-3d;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(99, 102, 241, 0.1);
    border-color: rgba(99, 102, 241, 0.3);
}

.card-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.03), rgba(139, 92, 246, 0.03));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.service-card:hover .card-bg {
    opacity: 1;
}

.card-content {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.service-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    position: relative;
    color: white;
    font-size: 28px;
    background: linear-gradient(135deg, #6366F1, #8B5CF6);
    box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
}

.icon-pulse {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    70% { transform: scale(1.3); opacity: 0; }
    100% { transform: scale(1); opacity: 0; }
}

.service-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: white;
    z-index: 2;
}

.service-badge.trending {
    background: linear-gradient(135deg, #EC4899, #F43F5E);
}

.service-badge.premium {
    background: linear-gradient(135deg, #F59E0B, #EF4444);
}

.service-badge.hot {
    background: linear-gradient(135deg, #10B981, #3B82F6);
}

.service-badge.expert {
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
}

.service-card h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 15px;
}

.service-card p {
    color: #64748b;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.features {
    margin-bottom: 25px;
}

.features li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    color: #475569;
    font-size: 14px;
}

.features i {
    color: #8B5CF6;
    font-size: 14px;
}

.explore-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #6366F1;
    font-weight: 600;
    font-size: 15px;
    margin-top: auto;
    text-decoration: none;
    transition: all 0.3s ease;
}

.explore-btn:hover {
    color: #8B5CF6;
    gap: 12px;
}

.explore-btn i {
    transition: transform 0.3s ease;
}

.explore-btn:hover i {
    transform: translateX(5px);
}

/* CTA SECTION STYLING */
.cta-section {
    background: linear-gradient(135deg, #6366F1, #8B5CF6);
    border-radius: 16px;
    padding: 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
}

.cta-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.cta-section::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.cta-section h3 {
    font-size: 32px;
    font-weight: 700;
    color: white;
    margin-bottom: 15px;
    position: relative;
    z-index: 2;
}

.cta-section p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin-bottom: 30px;
    position: relative;
    z-index: 2;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    position: relative;
    z-index: 2;
}

.cta-btn {
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.cta-btn.primary {
    background: white;
    color: #6366F1;
}

.cta-btn.primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
}

.cta-btn.secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.cta-btn.secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
}

/* RESPONSIVE DESIGN */
@media (max-width: 1024px) {
    .services-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .section-header h2 {
        font-size: 36px;
    }
    
    .cta-section {
        padding: 40px 20px;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
    
    .cta-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .section-header h2 {
        font-size: 28px;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .service-card {
        padding: 25px;
    }
}
</style>
    <!-- Parallax Section -->
    <section class="parallax-section" style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=2070')">
        <div class="parallax-overlay"></div>
        <div class="parallax-content">
            <h2 class="parallax-title" data-aos="fade-up">Technology Solutions That Drive Success</h2>
            <p class="parallax-description" data-aos="fade-up" data-aos-delay="100">Our expert team delivers innovative IT solutions that help businesses thrive in the digital age.</p>
            <a href="/views/free-consultation.php" class="btn-primary" data-aos="fade-up" data-aos-delay="200" style="
    padding: 10px;
    border-radius: 10px;
    text-decoration: none;
">
                <i class="fas fa-headset"></i> Schedule a Consultation
            </a>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section section-padding bg-light" id="process">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Our Streamlined Support Process</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">At IT Sahayata, we follow a systematic approach to ensure efficient resolution of your IT challenges and implementation of technology solutions.</p>
            
            <div class="process-timeline">
                <div class="row">
                    <!-- Step 1 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="process-step">
                            <div class="process-number">1</div>
                            <div class="process-content">
                                <h3 class="process-title">Initial Consultation</h3>
                                <p class="process-description">We begin by understanding your specific needs, challenges, and objectives through a comprehensive consultation with our expert team.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> Needs assessment</span>
                                    <span><i class="fas fa-check-circle"></i> Challenge identification</span>
                                    <span><i class="fas fa-check-circle"></i> Priority setting</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="process-step">
                            <div class="process-number">2</div>
                            <div class="process-content">
                                <h3 class="process-title">Solution Design</h3>
                                <p class="process-description">Our technical experts develop a customized solution tailored to your specific requirements, considering both immediate needs and long-term goals.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> Custom solution development</span>
                                    <span><i class="fas fa-check-circle"></i> Technology selection</span>
                                    <span><i class="fas fa-check-circle"></i> Cost-benefit analysis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="process-step">
                            <div class="process-number">3</div>
                            <div class="process-content">
                                <h3 class="process-title">Implementation</h3>
                                <p class="process-description">We execute the solution with minimal disruption to your operations, ensuring all systems are properly configured and optimized for peak performance.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> Scheduled deployment</span>
                                    <span><i class="fas fa-check-circle"></i> Minimal downtime</span>
                                    <span><i class="fas fa-check-circle"></i> Real-time monitoring</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="process-step">
                            <div class="process-number">4</div>
                            <div class="process-content">
                                <h3 class="process-title">Testing & Quality Assurance</h3>
                                <p class="process-description">Rigorous testing ensures all implemented solutions work flawlessly and meet the highest standards of performance, security, and reliability.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> Comprehensive testing</span>
                                    <span><i class="fas fa-check-circle"></i> Performance validation</span>
                                    <span><i class="fas fa-check-circle"></i> Security verification</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="process-step">
                            <div class="process-number">5</div>
                            <div class="process-content">
                                <h3 class="process-title">Training & Knowledge Transfer</h3>
                                <p class="process-description">We provide comprehensive training to ensure your team can effectively use and manage the new systems and technologies with confidence.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> User training sessions</span>
                                    <span><i class="fas fa-check-circle"></i> Documentation provision</span>
                                    <span><i class="fas fa-check-circle"></i> Best practices sharing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 6 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="process-step">
                            <div class="process-number">6</div>
                            <div class="process-content">
                                <h3 class="process-title">Ongoing Support & Optimization</h3>
                                <p class="process-description">Our relationship continues with proactive monitoring, maintenance, and support to ensure long-term success and continuous improvement of your IT systems.</p>
                                <div class="process-features">
                                    <span><i class="fas fa-check-circle"></i> 24/7 monitoring</span>
                                    <span><i class="fas fa-check-circle"></i> Regular maintenance</span>
                                    <span><i class="fas fa-check-circle"></i> Performance optimization</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="700">
                <a href="/support-process" class="btn btn-primary btn-lg">Learn More About Our Process</a>
            </div>
        </div>
    </section>

    <!-- Industry Solutions Section -->
    <section class="industry-section section-padding" id="industries">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Industry Solutions</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">We provide specialized IT solutions tailored to the unique needs of various industries, helping businesses overcome specific challenges.</p>
            
            <div class="row">
                <!-- Healthcare -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?q=80&w=2070')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Healthcare</h3>
                            <p class="industry-description">Secure solutions for patient data management, telemedicine platforms, and healthcare compliance.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Education -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Education</h3>
                            <p class="industry-description">Digital learning environments, campus networks, and student information systems.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Finance -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Finance</h3>
                            <p class="industry-description">Secure banking systems, compliance solutions, and financial data protection.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Retail -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Retail</h3>
                            <p class="industry-description">POS systems, inventory management, and e-commerce solutions.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Manufacturing -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?q=80&w=2070')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Manufacturing</h3>
                            <p class="industry-description">Industrial automation, supply chain management, and IoT solutions.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                             <!-- Hospitality -->
                             <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="industry-card">
                        <div class="industry-bg" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070')"></div>
                        <div class="industry-overlay">
                            <h3 class="industry-title">Hospitality</h3>
                            <p class="industry-description">POS systems, guest management software, and network solutions.</p>
                            <a href="#" class="industry-link">Explore Solutions <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Digital Guardian Section -->
    <section class="digital-guardian py-5" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="digital-guardian-content" data-aos="fade-right">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Digital Protection</span>
                        <h2 class="display-5 fw-bold mb-4">Your Digital Guardian Against Cyber Threats</h2>
                        <p class="lead text-muted mb-4">We provide comprehensive cybersecurity solutions to protect your business from evolving digital threats. Our multi-layered approach ensures your data, systems, and networks remain secure.</p>
                        
                        <div class="security-features mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="security-icon me-3 bg-success bg-opacity-10 text-success rounded-circle p-3">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Advanced Threat Protection</h5>
                                    <p class="text-muted mb-0">Real-time monitoring and prevention against malware, ransomware, and zero-day attacks</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="security-icon me-3 bg-danger bg-opacity-10 text-danger rounded-circle p-3">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Data Encryption</h5>
                                    <p class="text-muted mb-0">End-to-end encryption for sensitive data both at rest and in transit</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="security-icon me-3 bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Security Training</h5>
                                    <p class="text-muted mb-0">Comprehensive security awareness training for your team</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- <a href="#" class="btn btn-primary btn-lg px-4 me-2">Get Protected Now</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg px-4">Learn More</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="digital-guardian-image text-center" data-aos="fade-left">
                        <img src="/assets/digi_protect.gif" alt="Digital Security Protection" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- IT Solutions Showcase -->
    <section class="solutions-showcase py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Our Expertise</span>
                <h2 class="display-5 fw-bold">Comprehensive IT Solutions</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">From hardware support to software development, we provide end-to-end IT solutions tailored to your specific needs.</p>
            </div>

            <div class="row g-4">
                <!-- Software Development -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="solution-card h-100 bg-white rounded-4 p-4 shadow-sm border-top border-primary border-4">
                        <div class="solution-icon mb-4 bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-block">
                            <i class="fas fa-code fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">Software Development</h3>
                        <p class="text-muted mb-4">Custom software solutions designed to streamline your business processes and enhance productivity.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Custom Application Development</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> API Integration Services</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Legacy System Modernization</li>
                        </ul>
                        <a href="/views/software_development.php" class="btn btn-outline-primary">Explore Development Services</a>
                    </div>
                </div>

                <!-- Website Development -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="solution-card h-100 bg-white rounded-4 p-4 shadow-sm border-top border-success border-4">
                        <div class="solution-icon mb-4 bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block">
                            <i class="fas fa-laptop-code fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">Website Development</h3>
                        <p class="text-muted mb-4">Professional, responsive websites that engage visitors and convert them into customers.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Responsive Web Design</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> E-commerce Solutions</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> CMS Development</li>
                        </ul>
                        <a href="/views/website_development.php" class="btn btn-outline-success">View Web Services</a>
                    </div>
                </div>

                <!-- App Development -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="solution-card h-100 bg-white rounded-4 p-4 shadow-sm border-top border-info border-4">
                        <div class="solution-icon mb-4 bg-info bg-opacity-10 text-info rounded-circle p-3 d-inline-block">
                            <i class="fas fa-mobile-alt fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">App Development</h3>
                        <p class="text-muted mb-4">Native and cross-platform mobile applications that deliver exceptional user experiences.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> iOS & Android Development</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Cross-Platform Solutions</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> App Maintenance & Support</li>
                        </ul>
                        <a href="/views/software_development.php" class="btn btn-outline-info">Discover App Services</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="cta-card bg-primary text-white p-5 rounded-4 shadow-lg" data-aos="fade-up">
                        <div class="row align-items-center">
                            <div class="col-lg-8 mb-4 mb-lg-0">
                                <h2 class="display-5 fw-bold mb-3">Ready to transform your IT infrastructure?</h2>
                                <p class="lead mb-0">Schedule a free consultation with our experts and discover how we can help your business thrive in the digital age.</p>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <a href="/views/free-consultation.php" class="btn btn-light btn-lg px-4 fw-semibold" >Get Free Consultation</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="position-absolute top-0 end-0 d-none d-lg-block" style="transform: translate(20%, -30%)">
            <div class="bg-warning opacity-10 rounded-circle" style="width: 300px; height: 300px;"></div>
        </div>
        <div class="position-absolute bottom-0 start-0 d-none d-lg-block" style="transform: translate(-20%, 30%)">
            <div class="bg-info opacity-10 rounded-circle" style="width: 250px; height: 250px;"></div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

  
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js"></script>
    
    <!-- Initialize Scripts -->
    <script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false,
        disable: window.innerWidth < 768 // Disable on mobile for better performance
    });

</script>
</body>
</html>