<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - AI-Powered IT Support | 24/7 Tech Assistance</title>
    <meta name="description" content="Get instant IT solutions with our AI assistant. Hardware, software, network support & more. Contact: 7703823008">
    <?php include "assets.php" ?>
    
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --primary-light: #8579ef;
            --secondary: #00cec9;
            --dark: #2d3436;
            --light: #f5f6fa;
            --gray: #636e72;
            --success: #00b894;
            --warning: #fdcb6e;
            --danger: #d63031;
            --card-bg: #ffffff;
            --body-bg: #f9f9f9;
            --chat-bg: #ffffff;
            --user-bubble: #6c5ce7;
            --ai-bubble: #f1f2f6;
        }

        .dark-mode {
            --primary: #a29bfe;
            --primary-dark: #6c5ce7;
            --primary-light: #b8b3ff;
            --secondary: #55efc4;
            --dark: #f5f6fa;
            --light: #2d3436;
            --gray: #b2bec3;
            --card-bg: #1e272e;
            --body-bg: #0c0f14;
            --chat-bg: #1e272e;
            --user-bubble: #6c5ce7;
            --ai-bubble: #2d3436;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            color: var(--dark);
            transition: all 0.4s ease;
            overflow-x: hidden;
        }

        /* Floating Particles Background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(108, 92, 231, 0.3);
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Hero Section - 3D Glass Effect */
        .ai-chat-hero {
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.1) 0%, rgba(0, 206, 201, 0.1) 100%);
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-container {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(108, 92, 231, 0.2);
        }

        .hero-subtitle {
            font-size: 1.35rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            max-width: 600px;
            font-weight: 400;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(108, 92, 231, 0.4);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(108, 92, 231, 0.5);
        }

        .hero-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .hero-cta:hover::before {
            left: 100%;
        }

        .hero-image {
            position: relative;
            perspective: 1000px;
        }

        .hero-image-inner {
            position: relative;
            transform-style: preserve-3d;
            animation: float3d 8s ease-in-out infinite;
        }

        @keyframes float3d {
            0%, 100% {
                transform: translateY(0) rotateY(0deg);
            }
            50% {
                transform: translateY(-20px) rotateY(5deg);
            }
        }

        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: rotateX(10deg) rotateY(-15deg);
        }

        /* AI Chat Container - Neumorphic Design */
        .ai-chat-container {
            max-width: 1200px;
            margin: -80px auto 0;
            position: relative;
            z-index: 10;
        }

        .ai-chat-card {
            background: var(--card-bg);
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode .ai-chat-card {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
        }

        .ai-chat-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 22px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .ai-chat-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
        }

        .ai-chat-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .ai-chat-avatar {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .ai-chat-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            background-color: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--success);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Chat Messages Area */
        .ai-chat-messages {
            padding: 25px;
            height: 500px;
            overflow-y: auto;
            background-color: var(--chat-bg);
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .message {
            max-width: 85%;
            padding: 18px;
            border-radius: 20px;
            position: relative;
            animation: fadeIn 0.4s ease;
            line-height: 1.6;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .user-message {
            align-self: flex-end;
            background: var(--user-bubble);
            color: white;
            border-bottom-right-radius: 5px;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        .ai-message {
            align-self: flex-start;
            background: var(--ai-bubble);
            color: var(--dark);
            border-bottom-left-radius: 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        /* Service Card in AI Response */
        .service-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .dark-mode .service-card {
            background: rgba(0, 0, 0, 0.2);
        }

        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-card h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--primary);
            font-weight: 600;
        }

        .service-card p {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .service-card .service-cta {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .service-card .service-cta:hover {
            background: var(--primary-dark);
        }

        /* Contact Floating Button */
        .contact-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
            cursor: pointer;
            transition: all 0.4s ease;
            font-size: 1.5rem;
            animation: pulse-float 2s infinite;
        }

        @keyframes pulse-float {
            0% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
            }
            50% {
                transform: translateY(-5px) scale(1.05);
                box-shadow: 0 15px 40px rgba(108, 92, 231, 0.5);
            }
            100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
            }
        }

        .contact-float:hover {
            transform: scale(1.1);
            animation: none;
        }

        .contact-card {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 300px;
            background: var(--card-bg);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            transform: scale(0);
            transform-origin: bottom right;
            transition: all 0.3s ease;
            opacity: 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-card.show {
            transform: scale(1);
            opacity: 1;
        }

        .contact-card h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .contact-card p {
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .contact-number {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .contact-number i {
            color: var(--primary);
            font-size: 1.3rem;
        }

        .contact-social {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .contact-social a {
            color: var(--gray);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .contact-social a:hover {
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Chat Input Area */
        .ai-chat-input-container {
            padding: 20px 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background-color: var(--card-bg);
            display: flex;
            gap: 15px;
            align-items: center;
            position: relative;
        }

        .dark-mode .ai-chat-input-container {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .ai-chat-input {
            flex: 1;
            padding: 16px 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
            background-color: var(--chat-bg);
            color: var(--dark);
        }

        .dark-mode .ai-chat-input {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ai-chat-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        .ai-chat-send-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 15px;
            padding: 0 25px;
            height: 52px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(108, 92, 231, 0.3);
        }

        .ai-chat-send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        }

        .ai-chat-send-btn:active {
            transform: translateY(0);
        }

        .ai-chat-send-btn i {
            margin-left: 8px;
        }

        /* Thinking Animation */
        .thinking {
            align-self: flex-start;
            background: var(--ai-bubble);
            color: var(--gray);
            padding: 14px 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .thinking .dot {
            width: 10px;
            height: 10px;
            background-color: var(--gray);
            border-radius: 50%;
            animation: bounce 1.5s infinite;
        }

        .thinking .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .thinking .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Services Section - Modern Grid */
        .services-section {
            padding: 100px 0;
            background-color: var(--body-bg);
            position: relative;
            overflow: hidden;
        }

        .services-container {
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
            text-align: center;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--gray);
            text-align: center;
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .service-item {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .dark-mode .service-item {
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .service-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.1) 0%, rgba(0, 206, 201, 0.1) 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            color: var(--primary);
            font-size: 28px;
        }

        .service-item h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .service-item p {
            color: var(--gray);
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .service-cta {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .service-cta i {
            margin-left: 8px;
            transition: all 0.3s ease;
        }

        .service-cta:hover {
            color: var(--primary-dark);
        }

        .service-cta:hover i {
            transform: translateX(5px);
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 100;
            width: 50px;
            height: 50px;
            background: var(--card-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark-mode-toggle:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .dark-mode .dark-mode-toggle {
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 992px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .ai-chat-messages {
                height: 400px;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.15rem;
            }
            
            .ai-chat-card {
                border-radius: 20px;
            }
            
            .ai-chat-messages {
                height: 350px;
                padding: 20px;
            }
            
            .message {
                max-width: 90%;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .service-item {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .ai-chat-header {
                padding: 18px;
            }
            
            .ai-chat-input-container {
                padding: 15px 20px;
            }
            
            .ai-chat-send-btn {
                padding: 0 20px;
                height: 50px;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .contact-float {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                bottom: 20px;
                right: 20px;
            }
            
            .contact-card {
                width: 280px;
                bottom: 70px;
            }
        }

        /* Add this to your <style> section */
        .code-canvas {
            background: #181c24;
            color: #fff;
            border-radius: 10px;
            padding: 16px;
            margin: 12px 0;
            font-family: 'Fira Mono', 'Consolas', monospace;
            font-size: 0.97rem;
            overflow-x: auto;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .code-canvas pre {
            margin: 0;
            background: none;
            color: inherit;
        }
        .code-canvas code {
            background: none;
            color: inherit;
            font-size: inherit;
        }
    </style>
</head>
<body>

<!-- Floating Particles Background -->
<div class="particles" id="particles"></div>

<?php include 'header.php'; ?>

<!-- AI Chat Hero Section -->
<section class="ai-chat-hero">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h1 class="hero-title">IT Solutions at Your Fingertips</h1>
                <p class="hero-subtitle">Our AI assistant provides instant tech support 24/7. From hardware issues to software bugs, get expert solutions in seconds.</p>
                
                <a href="#ai-chat" class="hero-cta">
                    Chat with IT Expert <i class="fas fa-comment-dots ml-2" style="padding-left: 5px;"></i>
                </a>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-image">
                    <div class="hero-image-inner">
                        <img src="../assets/it-ai.png" alt="AI Chat Assistant" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AI Chat Section -->
<section id="ai-chat" class="py-5">
    <div class="container ai-chat-container">
        <div class="ai-chat-card">
            <div class="ai-chat-header">
                <h3 class="ai-chat-title">
                    <div class="ai-chat-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    IT Sahayata AI Assistant
                </h3>
                <div class="ai-chat-status">
                    <div class="status-indicator"></div>
                    <span>Online Now</span>
                </div>
            </div>
            
            <div id="ai-chat-messages" class="ai-chat-messages">
                <!-- AI welcome message -->
                <div class="message ai-message">
                    <p>👋 Hello! I'm your IT Sahayata AI assistant. How can I help you today?</p>
                    <p>You can ask me about:</p>
                    <ul>
                        <li>Computer and laptop repairs</li>
                        <li>Software installation & troubleshooting</li>
                        <li>Network setup and Wi-Fi issues</li>
                        <li>Virus removal and security</li>
                        <li>Data recovery and backup</li>
                    </ul>
                    <div class="service-card">
                        <h4>Need Professional Help?</h4>
                        <p>For complex issues, our certified technicians are available for on-site and remote support.</p>
                        <a href="#" class="service-cta">Contact IT Sahayata</a>
                    </div>
                </div>
            </div>
            
            <div class="ai-chat-input-container">
                <input type="text" id="ai-chat-input" class="ai-chat-input" placeholder="Describe your IT problem..." autocomplete="off">
                <button id="ai-chat-send" class="ai-chat-send-btn">Send <i class="fas fa-paper-plane"></i></button>
                <button id="ai-chat-stop" class="ai-chat-send-btn" style="display: none; background: var(--danger);">
                    Stop <i class="fas fa-stop"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container services-container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Our Comprehensive <span class="text-gradient">IT Services</span></h2>
            <p class="section-subtitle">End-to-end technology solutions for all your business and personal needs</p>
        </div>
        
        <div class="services-grid">
            <!-- Service 1 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3>Hardware Support</h3>
                <p>Expert diagnosis and repair services for all your computer hardware issues, from desktops to servers.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <!-- Service 2 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3>Software Support</h3>
                <p>Comprehensive software troubleshooting, installation, and maintenance services for optimal performance.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <!-- Service 3 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h3>Network Solutions</h3>
                <p>Design, implementation, and management of secure and efficient network infrastructure for businesses.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <!-- Service 4 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h3>Cloud Services</h3>
                <p>Seamless migration, management, and optimization of cloud infrastructure for enhanced flexibility.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <!-- Service 5 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="500">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Cybersecurity</h3>
                <p>Comprehensive security solutions to protect your business from evolving cyber threats and data breaches.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <!-- Service 6 -->
            <div class="service-item" data-aos="fade-up" data-aos-delay="600">
                <div class="service-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h3>Data Management</h3>
                <p>Effective data storage, backup, recovery, and management solutions to safeguard your information.</p>
                <a href="#" class="service-cta">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Floating Button -->
<div class="contact-float" id="contactFloat">
    <i class="fas fa-phone-alt"></i>
    <div class="contact-card" id="contactCard">
        <h3>Contact IT Sahayata</h3>
        <p>For immediate assistance or professional IT services:</p>
        <div class="contact-number">
            <i class="fas fa-phone"></i>
            <span>7703823008</span>
        </div>
        <p>Available 24/7 for emergency support</p>
        <div class="contact-social">
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-telegram"></i></a>
            <a href="#"><i class="fas fa-envelope"></i></a>
        </div>
    </div>
</div>

<!-- Dark Mode Toggle -->
<div class="dark-mode-toggle" id="darkModeToggle">
    <i class="fas fa-moon"></i>
</div>

<?php include 'footer.php'; ?>

<!-- AI Chat JavaScript --><script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('ai-chat-messages');
        const chatInput = document.getElementById('ai-chat-input');
        const chatSendBtn = document.getElementById('ai-chat-send');
        const chatStopBtn = document.getElementById('ai-chat-stop');
        const darkModeToggle = document.getElementById('darkModeToggle');
        const contactFloat = document.getElementById('contactFloat');
        const contactCard = document.getElementById('contactCard');
        let isGenerating = false;
        let stopGeneration = false;
        
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 5px and 15px
                const size = Math.random() * 10 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random animation duration between 10s and 20s
                const duration = Math.random() * 10 + 10;
                particle.style.animationDuration = `${duration}s`;
                
                // Random delay
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                particlesContainer.appendChild(particle);
            }
        }
        
        createParticles();
        
        // Dark Mode Toggle
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                localStorage.setItem('darkMode', 'enabled');
            } else {
                darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                localStorage.setItem('darkMode', 'disabled');
            }
        });
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }
        
        // Contact Float Toggle
        contactFloat.addEventListener('click', function() {
            contactCard.classList.toggle('show');
        });
        
        // Close contact card when clicking outside
        document.addEventListener('click', function(e) {
            if (!contactFloat.contains(e.target) && !contactCard.contains(e.target)) {
                contactCard.classList.remove('show');
            }
        });
        
        // Function to add a message to the chat
        function addMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'message user-message' : 'message ai-message';

            if (!isUser) {
                // --- Markdown to HTML conversion ---

                // 1. Code blocks (```lang ... ```
                text = text.replace(/```([\s\S]*?)```/g, function(match, code) {
                    return `<div class="code-canvas"><pre><code>${escapeHtml(code.trim())}</code></pre></div>`;
                });

                // 2. Inline code (`code`)
                text = text.replace(/`([^`]+)`/g, '<code>$1</code>');

                // 3. Numbered lists (fix: group consecutive lines)
                text = text.replace(/((?:^\d+\..*(?:\n|$))+)/gm, function(match) {
                    const items = match.trim().split(/\n/).filter(Boolean).map(line => {
                        return line.replace(/^\d+\.\s*/, '');
                    });
                    return '<ol>' + items.map(item => `<li>${item}</li>`).join('') + '</ol>';
                });

                // 4. Bullet lists (group consecutive lines)
                text = text.replace(/((?:^[-*].*(?:\n|$))+)/gm, function(match) {
                    const items = match.trim().split(/\n/).filter(Boolean).map(line => {
                        return line.replace(/^[-*]\s*/, '');
                    });
                    return '<ul>' + items.map(item => `<li>${item}</li>`).join('') + '</ul>';
                });

                // 5. Paragraphs
                text = text.replace(/\n{2,}/g, '</p><p>');
                text = '<p>' + text.replace(/\n/g, '<br>') + '</p>';

                // 6. Links
                text = text.replace(/\[([^\]]+)\]\(([^\)]+)\)/g, '<a href="$2" target="_blank">$1</a>');

                // 7. Bold & Italic
                text = text.replace(/\*\*([^\*]+)\*\*/g, '<strong>$1</strong>');
                text = text.replace(/\*([^\*]+)\*/g, '<em>$1</em>');

                // 8. Images
                text = text.replace(/!\[([^\]]*)\]\(([^\)]+)\)/g, '<img src="$2" alt="$1" style="max-width:100%;border-radius:8px;margin:10px 0;">');

                messageDiv.innerHTML = text;

                // Service recommendation card (as before)
                const serviceKeywords = ['repair', 'hardware', 'complex', 'professional', 'technician', 'contact', 'service', 'support'];
                const shouldRecommendService = serviceKeywords.some(keyword =>
                    text.toLowerCase().includes(keyword.toLowerCase())
                );
                if (shouldRecommendService) {
                    const serviceCard = document.createElement('div');
                    serviceCard.className = 'service-card';
                    serviceCard.innerHTML = `
                        <h4>Need Professional IT Support?</h4>
                        <p>IT Sahayata offers comprehensive services for complex issues:</p>
                        <ul>
                            <li>On-site hardware repairs</li>
                            <li>Professional network setup</li>
                            <li>Data recovery services</li>
                            <li>24/7 emergency support</li>
                        </ul>
                        <p>Contact us at: <strong>7703823008</strong></p>
                        <a href="tel:7703823008" class="service-cta">Call Now</a>
                    `;
                    messageDiv.appendChild(serviceCard);
                }
            } else {
                messageDiv.textContent = text;
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Helper to escape HTML for code blocks
        function escapeHtml(text) {
            return text.replace(/[&<>"']/g, function(m) {
                return ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
                })[m];
            });
        }

        // Typing animation: paragraph-by-paragraph
        async function simulateStreamResponse(responseText) {
            removeThinking();
            addMessage(responseText);
        }
        
        // Function to show thinking animation
        function showThinking() {
            const thinkingDiv = document.createElement('div');
            thinkingDiv.className = 'thinking';
            thinkingDiv.id = 'thinking-indicator';
            
            thinkingDiv.innerHTML = 'IT Sahayata AI is thinking'
                + '<div class="dot"></div>'
                + '<div class="dot"></div>'
                + '<div class="dot"></div>';
                
            chatMessages.appendChild(thinkingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Function to remove thinking animation
        function removeThinking() {
            const thinkingDiv = document.getElementById('thinking-indicator');
            if (thinkingDiv) {
                thinkingDiv.remove();
            }
        }
        
        // Function to send message to AI and get response
        async function sendToAI(userInput) {
            try {
                // Get base URL
                const pathArray = window.location.pathname.split('/');
                const appDirIndex = pathArray.indexOf('ITSupportApp');
                let baseUrl = '';
                
                if (appDirIndex !== -1) {
                    const basePath = pathArray.slice(0, appDirIndex + 1).join('/');
                    baseUrl = window.location.origin + basePath;
                } else {
                    baseUrl = window.location.origin;
                }
                
                // Enhanced prompt with service recommendations
                const enforcedPrompt = `
                You are "IT Sahayata", a helpful AI support expert for IT (hardware, software, internet, devices, tech problems). 
                Give friendly, practical, and clear solutions to any queries that are related to IT, computers, networks, devices, internet, digital services, software, hardware etc.

                Important guidelines:
                1. If a user is having a general conversation or greeting, respond naturally but always be helpful regarding IT support.
                2. Never reply: "I help with IT problems only." Instead, always try to answer helpfully.
                3. Respond in a positive and helpful human tone; your goal is to genuinely solve problems.
                4. When appropriate, mention that IT Sahayata offers affordable professional services for complex issues.
                5. For hardware problems that can't be solved remotely, suggest that the user might benefit from our affordable on-site repair services (contact: 7703823008).
                6. For data recovery or security issues, mention that we offer specialized services at competitive rates.
                7. For network setup or troubleshooting, mention that our technicians can provide professional assistance.
                8. Always prioritize solving the user's problem first, then subtly mention our services only if relevant.
                9. Format your responses properly with paragraphs, bullet points, and numbered lists when appropriate.
                10. For complex issues, include a service recommendation card with our contact number (7703823008).

                User message:
                ${userInput}
                `.trim();
                
                const response = await fetch(baseUrl + '/ask_gemini.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ prompt: enforcedPrompt })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                return (data.result || '').replace(/^AI:/i, '').trim();
                
            } catch (error) {
                console.error('Error:', error);
                return 'Sorry, I encountered an error while processing your request. Please try again or contact our support team at 7703823008 for immediate assistance.';
            }
        }
        
        // Handle stop button click
        chatStopBtn.addEventListener('click', function() {
            stopGeneration = true;
            chatStopBtn.style.display = 'none';
            chatSendBtn.style.display = 'flex';
            isGenerating = false;
            
            // Remove thinking indicator
            removeThinking();
            
            // Remove temporary streaming message if exists
            const tempStream = document.getElementById('temp-stream');
            if (tempStream) {
                chatMessages.removeChild(tempStream);
            }
        });
        
        // Handle send button click
        chatSendBtn.addEventListener('click', async function() {
            const userText = chatInput.value.trim();
            if (!userText || isGenerating) return;
            
            // Add user message to chat
            addMessage(userText, true);
            chatInput.value = '';
            chatInput.disabled = true;
            chatSendBtn.style.display = 'none';
            chatStopBtn.style.display = 'flex';
            isGenerating = true;
            stopGeneration = false;
            
            // Show thinking animation
            showThinking();
            
            // Get AI response
            const aiResponse = await sendToAI(userText); // <-- FIXED HERE
            
            // Remove thinking animation and simulate streaming
            if (!stopGeneration) {
                await simulateStreamResponse(aiResponse);
            }
            
            // Re-enable input
            chatInput.disabled = false;
            chatStopBtn.style.display = 'none';
            chatSendBtn.style.display = 'flex';
            isGenerating = false;
            chatInput.focus();
        });
        
        // Handle Enter key press
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey && !isGenerating) {
                e.preventDefault();
                chatSendBtn.click();
            }
        });
        
        // Focus input on page load
        chatInput.focus();
    });
</script>

<!-- AOS Initialization -->
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
</script>

</body>
</html>