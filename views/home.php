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
        
       

        /* Services Section */
        .services-section {
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .services-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234361ee' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        /* Modern Glass Service Card */
        .service-card {
            background: rgba(255,255,255,0.7);
            border-radius: 22px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(67,97,238,0.08);
            transition: transform 0.25s cubic-bezier(.4,2,.6,1), box-shadow 0.25s;
            position: relative;
            overflow: hidden;
            min-height: 420px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .service-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 16px 40px 0 rgba(67,97,238,0.12);
        }

        .service-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #4361ee 0%, #6c5ce7 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.7rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 16px rgba(67,97,238,0.10);
            transition: transform 0.4s cubic-bezier(.4,2,.6,1);
        }

        .service-card:hover .service-icon {
            transform: rotate(-8deg) scale(1.12);
            background: linear-gradient(135deg, #6c5ce7 0%, #4361ee 100%);
        }

        .service-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.7rem;
            color: #2d3436;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .service-description {
            color: #636e72;
            margin-bottom: 1.2rem;
            text-align: center;
            font-size: 1.02rem;
        }

        .service-features {
            list-style: none;
            padding: 0;
            margin: 0 0 1.2rem;
            text-align: left;
            width: 100%;
        }

        .service-features li {
            padding: 0.45rem 0 0.45rem 1.8rem;
            position: relative;
            font-size: 0.98rem;
            color: #495057;
        }

        .service-features li i {
            position: absolute;
            left: 0.5rem;
            color: #4361ee;
            font-size: 1.1rem;
        }

        .service-link {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            color: #4361ee;
            font-weight: 600;
            text-decoration: none;
            gap: 0.5rem;
            border-radius: 20px;
            padding: 0.5rem 1.2rem;
            background: rgba(67,97,238,0.07);
            transition: background 0.2s, color 0.2s;
        }

        .service-link:hover {
            background: #4361ee;
            color: #fff;
        }

        @media (max-width: 991px) {
            .service-card { min-height: 440px; }
        }

        @media (max-width: 767px) {
            .service-card { min-height: 0; }
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

  <!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <!-- Trust badge -->
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Trusted by 500+ Businesses</span>
                    </div>
                    
                    <!-- Main heading -->
                    <h1 class="hero-title">
                        Your Trusted <span class="highlight">IT Solutions</span> Partner
                    </h1>
                    
                    <p class="hero-subtitle">
                        We provide comprehensive IT services including cloud solutions, cybersecurity, 
                        network management, and software development to drive your business forward.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-cta">
                        <a href="#contact" class="btn btn-primary">
                            <i class="fas fa-headset"></i> Get Support Now
                        </a>
                        <a href="#services" class="btn btn-outline">
                            <i class="fas fa-th"></i> Our Services
                        </a>
                    </div>
                    
                    <!-- Key Metrics -->
                    <div class="metrics">
                        <div class="metric-item">
                            <div class="metric-value">24/7</div>
                            <div class="metric-label">Support</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">99%</div>
                            <div class="metric-label">Satisfaction</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">30min</div>
                            <div class="metric-label">Response Time</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="hero-image">
                    <!-- Main IT image -->
                    <img src="../assets/hero.png" alt="IT professionals working" class="main-img">
                    
                    <!-- Floating tech elements -->
                    <div class="tech-element cloud">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <div class="tech-element shield">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="tech-element server">
                        <i class="fas fa-server"></i>
                    </div>
                    
                    <!-- Client logos -->
                    <div class="client-logos">
                        <div class="logo-item">
                            <img src="https://purepng.com/public/uploads/large/purepng.com-microsoft-logo-iconlogobrand-logoiconslogos-251519939091wmudn.png" alt="Microsoft Partner">
                        </div>
                        <div class="logo-item">
                            <img src="https://tse4.mm.bing.net/th/id/OIP.cAALDaDujKm4Og8WiOOm2wHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Cisco Partner">
                        </div>
                        <div class="logo-item">
                            <img src="https://tse1.mm.bing.net/th/id/OIP.GfRMa4L8EDf-NWt5dZyJuwHaEb?rs=1&pid=ImgDetMain&o=7&rm=3" alt="AWS Partner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section - Light Theme */
.hero-section {
    padding: 100px 0;
    background-color: #f8fafc;
    position: relative;
    overflow: hidden;
}

/* Content styles */
.hero-content {
    position: relative;
    z-index: 2;
}

.trust-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #e0e7ff;
    color: #4338ca;
    padding: 8px 16px;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    color: #1e293b;
}

.highlight {
    color: #4338ca;
    position: relative;
}

.highlight::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 0;
    width: 100%;
    height: 8px;
    background-color: #c7d2fe;
    z-index: -1;
    border-radius: 4px;
}

.hero-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    margin-bottom: 2rem;
    max-width: 500px;
    line-height: 1.6;
}

/* Button styles */
.hero-cta {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #4338ca;
    color: white;
    border: 2px solid #4338ca;
}

.btn-primary:hover {
    background-color: #3730a3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(67, 56, 202, 0.2);
}

.btn-outline {
    background-color: transparent;
    color: #4338ca;
    border: 2px solid #4338ca;
}

.btn-outline:hover {
    background-color: #e0e7ff;
    transform: translateY(-2px);
}

/* Metrics */
.metrics {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
}

.metric-item {
    text-align: center;
}

.metric-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4338ca;
    margin-bottom: 4px;
}

.metric-label {
    font-size: 0.9rem;
    color: #64748b;
}

/* Hero image */
.hero-image {
    position: relative;
    padding: 20px;
}

.main-img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 2;
}

/* Tech elements */
.tech-element {
    position: absolute;
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #4338ca;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 3;
    animation: float 6s ease-in-out infinite;
}

.cloud {
    top: 20px;
    left: 20px;
    animation-delay: 0s;
}

.shield {
    bottom: 40px;
    right: 40px;
    animation-delay: 1s;
}

.server {
    top: 40px;
    right: 20px;
    animation-delay: 2s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

/* Client logos */
.client-logos {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    justify-content: center;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    position: relative;
    z-index: 2;
}

.logo-item img {
    height: 30px;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.logo-item:hover img {
    opacity: 1;
}

/* Responsive styles */
@media (max-width: 1199px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 991px) {
    .hero-section {
        padding: 80px 0;
    }
    
    .hero-image {
        margin-top: 50px;
    }
    
    .metrics {
        justify-content: center;
    }
}

@media (max-width: 767px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-cta {
        flex-direction: column;
    }
    
    .tech-element {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 575px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .metrics {
        gap: 1rem;
    }
    
    .metric-value {
        font-size: 1.2rem;
    }
}
</style>

<script>
// Simple animation trigger
document.addEventListener('DOMContentLoaded', function() {
    const techElements = document.querySelectorAll('.tech-element');
    
    techElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.5}s`;
    });
});
</script>

    <!-- Services Section -->
    <section id="services" class="section-padding">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Our Comprehensive IT Services</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">IT Sahayata offers end-to-end technology solutions to address all your business needs - from hardware support to custom software development.</p>
            
            <div class="row g-4">
                <!-- 1. Hardware Support -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h3 class="service-title">Hardware Support</h3>
                        <p class="service-description">Expert diagnosis and repair services for all your computer hardware issues, from desktops to servers.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Computer & laptop repairs</li>
                            <li><i class="fas fa-check-circle"></i> Server maintenance</li>
                            <li><i class="fas fa-check-circle"></i> Hardware upgrades & optimization</li>
                        </ul>
                        <a href="/services/hardware-support" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 2. Software Support -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="service-title">Software Support</h3>
                        <p class="service-description">Comprehensive software troubleshooting, installation, and maintenance services for optimal performance.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> OS installation & updates</li>
                            <li><i class="fas fa-check-circle"></i> Software troubleshooting</li>
                            <li><i class="fas fa-check-circle"></i> Application support & training</li>
                        </ul>
                        <a href="/services/software-support" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 3. Network Solutions -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h3 class="service-title">Network Solutions</h3>
                        <p class="service-description">Design, implementation, and management of secure and efficient network infrastructure for businesses.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Network design & setup</li>
                            <li><i class="fas fa-check-circle"></i> Wi-Fi optimization</li>
                            <li><i class="fas fa-check-circle"></i> Network security & monitoring</li>
                        </ul>
                        <a href="/services/network-solutions" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 4. Cloud Services -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <h3 class="service-title">Cloud Services</h3>
                        <p class="service-description">Seamless migration, management, and optimization of cloud infrastructure for enhanced flexibility and scalability.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Cloud migration & setup</li>
                            <li><i class="fas fa-check-circle"></i> SaaS implementation</li>
                            <li><i class="fas fa-check-circle"></i> Cloud security & backup</li>
                        </ul>
                        <a href="/services/cloud-services" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 5. Cybersecurity -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="service-title">Cybersecurity</h3>
                        <p class="service-description">Comprehensive security solutions to protect your business from evolving cyber threats and data breaches.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Security audits & assessments</li>
                            <li><i class="fas fa-check-circle"></i> Threat detection & prevention</li>
                            <li><i class="fas fa-check-circle"></i> Data encryption & protection</li>
                        </ul>
                        <a href="/services/cybersecurity" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 6. Data Management -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h3 class="service-title">Data Management</h3>
                        <p class="service-description">Effective data storage, backup, recovery, and management solutions to safeguard your valuable information.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Data backup & recovery</li>
                            <li><i class="fas fa-check-circle"></i> Storage solutions</li>
                            <li><i class="fas fa-check-circle"></i> Data migration & archiving</li>
                        </ul>
                        <a href="/services/data-management" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 7. Software Development -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h3 class="service-title">Software Development</h3>
                        <p class="service-description">Custom software solutions designed to streamline your business processes and enhance operational efficiency.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Custom application development</li>
                            <li><i class="fas fa-check-circle"></i> API integration</li>
                            <li><i class="fas fa-check-circle"></i> Legacy system modernization</li>
                        </ul>
                        <a href="/services/software-development" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 8. Website Development -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="800">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="service-title">Website Development</h3>
                        <p class="service-description">Professional, responsive websites that enhance your online presence and drive customer engagement.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Responsive web design</li>
                            <li><i class="fas fa-check-circle"></i> E-commerce solutions</li>
                            <li><i class="fas fa-check-circle"></i> CMS development</li>
                        </ul>
                        <a href="/services/website-development" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- 9. IT Consulting -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="900">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="service-title">IT Consulting</h3>
                        <p class="service-description">Strategic technology guidance to help your business leverage IT for growth, efficiency, and competitive advantage.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> IT strategy development</li>
                            <li><i class="fas fa-check-circle"></i> Digital transformation</li>
                            <li><i class="fas fa-check-circle"></i> Technology roadmapping</li>
                        </ul>
                        <a href="/services/it-consulting" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        
                        <a href="#" class="btn btn-primary btn-lg px-4 me-2">Get Protected Now</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg px-4">Learn More</a>
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
                        <a href="#" class="btn btn-outline-primary">Explore Development Services</a>
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
                        <a href="#" class="btn btn-outline-success">View Web Services</a>
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
                        <a href="#" class="btn btn-outline-info">Discover App Services</a>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
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