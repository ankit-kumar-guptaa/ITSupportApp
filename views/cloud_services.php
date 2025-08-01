<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Cloud Services | Secure & Scalable Cloud Solutions</title>
    <meta name="description" content="IT Sahayta offers comprehensive cloud services including cloud migration, storage solutions, cloud security, and managed cloud services for businesses of all sizes.">
    <?php include "assets.php"?>
    
    <style>
        /* Custom styles for cloud services page */
        .cloud-hero {
            background: linear-gradient(135deg, #0c2340 0%, #1e5799 100%);
            color: white;
            position: relative;
            overflow: hidden;
            padding: 120px 0;
        }
        
        .cloud-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .cloud-hero .shape {
            position: absolute;
            z-index: 0;
        }
        
        .cloud-hero .shape-1 {
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .cloud-hero .shape-2 {
            bottom: -80px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .cloud-hero .shape-3 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(29,78,216,0.1) 0%, rgba(30,87,153,0) 70%);
            border-radius: 50%;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        
        .benefits-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 10px 15px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }
        
        .benefit-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.2rem;
        }
        
        .experience-badge {
            position: absolute;
            bottom: -25px;
            right: 30px;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .badge-inner {
            text-align: center;
            color: white;
        }
        
        .badge-inner .number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            display: block;
        }
        
        .badge-inner .text {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-color: rgba(79, 70, 229, 0.2);
        }
        
        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%);
            z-index: 1;
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 1.8rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            color: white;
        }
        
        .service-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            border-radius: 20px;
            z-index: -1;
        }
        
        .service-features {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
        }
        
        .service-features li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .service-features li i {
            color: #4f46e5;
            font-size: 0.8rem;
        }
        
        .cloud-provider {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .cloud-provider:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .case-study-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .case-study-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .case-study-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }
        
        .case-study-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .case-study-card:hover .case-study-image img {
            transform: scale(1.1);
        }
        
        .industry-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .case-study-content {
            padding: 25px;
        }
        
        .results {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .result-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .result-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-radius: 50%;
            font-size: 0.8rem;
        }
        
        .stats-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: flex;
            gap: 15px;
        }
        
        .stats-item {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            min-width: 100px;
        }
        
        .stats-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4f46e5;
            line-height: 1;
        }
        
        .stats-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 5px;
        }
        
        .faq-accordion .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .faq-accordion .accordion-button {
            padding: 20px 25px;
            font-weight: 600;
            background: white;
            box-shadow: none;
        }
        
        .faq-accordion .accordion-button:not(.collapsed) {
            color: #4f46e5;
            background: white;
        }
        
        .faq-accordion .accordion-body {
            padding: 0 25px 20px;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        }
        
        .cta-card {
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 80%);
            z-index: -1;
            animation: rotate 30s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animated elements */
        .floating-clouds {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }
        
        .cloud {
            position: absolute;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .cloud-1 {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation: float-cloud 20s linear infinite;
        }
        
        .cloud-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 20%;
            animation: float-cloud 25s linear infinite;
        }
        
        .cloud-3 {
            width: 80px;
            height: 80px;
            top: 30%;
            right: 30%;
            animation: float-cloud 18s linear infinite;
        }
        
        .cloud-4 {
            width: 120px;
            height: 120px;
            bottom: 20%;
            right: 10%;
            animation: float-cloud 22s linear infinite;
        }
        
        @keyframes float-cloud {
            0% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-20px) translateX(20px); }
            50% { transform: translateY(0) translateX(40px); }
            75% { transform: translateY(20px) translateX(20px); }
            100% { transform: translateY(0) translateX(0); }
        }
        
        /* Animated background for sections */
        .animated-bg {
            position: relative;
            overflow: hidden;
        }
        
        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTI4MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0iI2ZmZmZmZiI+PHBhdGggZD0iTTAgNTEuNzZjMzYuMjEtMi4yNSA3Ny41Ny0zLjU4IDEyNi40Mi0zLjU4IDMyMCAwIDMyMCA1NyA2NDAgNTcgMjcxLjE1IDAgMzEyLjU4LTQwLjkxIDUxMy41OC01Ny40VjE0MEgwVjUxLjc2eiIgZmlsbC1vcGFjaXR5PSIuMiIvPjxwYXRoIGQ9Ik0wIDI0LjMxYzQzLjEtNS42OCA5NC41Ni03LjcgMTU0LjYxLTcuN2M0MTYuMzMgMCAzMzguMDYgNDkuMTYgNjM2LjA2IDQ5LjE2IDI3MS4xNSAwIDMxMi41OC0xMy4yNiA0ODkuMzMtMjQuNDZ2OTguN0gwVjI0LjMxeiIgZmlsbC1vcGFjaXR5PSIuMiIvPjxwYXRoIGQ9Ik0wIDB2MTMuODhDOTYuMDggNS4yOCAxOTAuMDkgMC4xNyAyOTAuNTEgMC4xN2M0MTYuMzMgMCAzNDcuMTMgMzIuMzMgNjQ1LjEzIDMyLjMzIDIyMi45NCAwIDI3MS40OS0xMy44OCAzNDQuMzYtMjAuMzRWMEgweiIgZmlsbC1vcGFjaXR5PSIuMiIvPjwvZz48L3N2Zz4=');
            background-size: 100% 70px;
            z-index: -1;
            opacity: 0.05;
            animation: wave 15s linear infinite;
        }
        
        @keyframes wave {
            0% { background-position-x: 0; }
            100% { background-position-x: 1280px; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
   <?php include 'loader.php'; ?>
<!-- Cloud Services Hero Section -->
<section class="cloud-hero py-5 position-relative overflow-hidden">
    <!-- Animated floating clouds -->
    <div class="floating-clouds">
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="cloud cloud-4"></div>
    </div>
    
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">IT Sahayta <span class="text-gradient">Cloud Solutions</span> for Digital Transformation</h1>
                <p class="lead mb-4">Secure, scalable, and intelligent cloud services designed to transform your business operations and drive innovation in today's digital landscape.</p>
                
                <div class="benefits-list mb-5">
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <span>Seamless cloud migration</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span>Enterprise-grade security</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span>Scalable infrastructure</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span>High-performance computing</span>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-3">
                    <a href="#cloud-services" class="btn btn-primary btn-lg px-4">Explore Services</a>
                    <a href="/views/free-consultation.php" class="btn btn-outline-light btn-lg px-4">Free Consultation</a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://img.freepik.com/free-photo/cloud-computing-technology-with-3d-render-cloud-storage_107791-16262.jpg" alt="IT Sahayta Cloud Computing Services" class="img-fluid rounded-4 shadow-lg">
                    <div class="experience-badge">
                        <div class="badge-inner">
                            <span class="number">10+</span>
                            <span class="text">Years Experience</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Elements -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</section>

<!-- Cloud Services Section -->
<section id="cloud-services" class="py-5 bg-light animated-bg">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">IT Sahayta Cloud <span class="text-gradient">Services</span></h2>
            <p class="section-subtitle">Comprehensive cloud solutions tailored for businesses of all sizes</p>
        </div>
        
        <div class="row g-4">
            <!-- Cloud Migration & Strategy -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100">
                    <div class="service-icon cloud-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h3>Cloud Migration & Strategy</h3>
                    <p>IT Sahayta provides seamless transition to the cloud with minimal disruption to your business operations.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Cloud readiness assessment</li>
                        <li><i class="fas fa-check"></i> Migration planning & execution</li>
                        <li><i class="fas fa-check"></i> Legacy system integration</li>
                        <li><i class="fas fa-check"></i> Post-migration support</li>
                    </ul>
                </div>
            </div>
            
            <!-- Cloud Storage Solutions -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100">
                    <div class="service-icon storage-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Cloud Storage Solutions</h3>
                    <p>Secure and scalable storage options tailored to your business needs and budget by IT Sahayta experts.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Object & block storage</li>
                        <li><i class="fas fa-check"></i> File sharing & collaboration</li>
                        <li><i class="fas fa-check"></i> Backup & disaster recovery</li>
                        <li><i class="fas fa-check"></i> Data archiving & retention</li>
                    </ul>
                </div>
            </div>
            
            <!-- Cloud Security -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100">
                    <div class="service-icon security-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Cloud Security</h3>
                    <p>IT Sahayta implements comprehensive security measures to protect your cloud infrastructure and data.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Identity & access management</li>
                        <li><i class="fas fa-check"></i> Data encryption</li>
                        <li><i class="fas fa-check"></i> Threat detection & response</li>
                        <li><i class="fas fa-check"></i> Compliance management</li>
                    </ul>
                </div>
            </div>
            
            <!-- Infrastructure as a Service (IaaS) -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card h-100">
                    <div class="service-icon iaas-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>Infrastructure as a Service (IaaS)</h3>
                    <p>Flexible and scalable cloud infrastructure from IT Sahayta to meet your computing needs.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Virtual machines & servers</li>
                        <li><i class="fas fa-check"></i> Network infrastructure</li>
                        <li><i class="fas fa-check"></i> Load balancing</li>
                        <li><i class="fas fa-check"></i> Auto-scaling resources</li>
                    </ul>
                </div>
            </div>
            
            <!-- Platform as a Service (PaaS) -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card h-100">
                    <div class="service-icon paas-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Platform as a Service (PaaS)</h3>
                    <p>IT Sahayta provides development platforms and tools to build, deploy, and manage applications.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Application hosting</li>
                        <li><i class="fas fa-check"></i> Database management</li>
                        <li><i class="fas fa-check"></i> Development frameworks</li>
                        <li><i class="fas fa-check"></i> API management</li>
                    </ul>
                </div>
            </div>
            
            <!-- Software as a Service (SaaS) -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="service-card h-100">
                    <div class="service-icon saas-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Software as a Service (SaaS)</h3>
                    <p>Cloud-based applications delivered on-demand by IT Sahayta without the need for installation.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Business applications</li>
                        <li><i class="fas fa-check"></i> Productivity tools</li>
                        <li><i class="fas fa-check"></i> Collaboration software</li>
                        <li><i class="fas fa-check"></i> Custom SaaS solutions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cloud Providers Section -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Cloud <span class="text-gradient">Platforms</span> We Support</h2>
            <p class="section-subtitle">IT Sahayta works with all major cloud providers to deliver the best solutions for your business</p>
        </div>
        
        <div class="row g-4 align-items-center justify-content-center">
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="cloud-provider text-center p-4">
                    <img src="https://img.freepik.com/free-icon/aws_318-565774.jpg" alt="Amazon Web Services" class="img-fluid mb-3" style="max-height: 80px;">
                    <h4>Amazon Web Services</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="cloud-provider text-center p-4">
                    <img src="https://img.freepik.com/free-icon/microsoft_318-566086.jpg" alt="Microsoft Azure" class="img-fluid mb-3" style="max-height: 80px;">
                    <h4>Microsoft Azure</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="cloud-provider text-center p-4">
                    <img src="https://img.freepik.com/free-icon/search_318-265146.jpg" alt="Google Cloud Platform" class="img-fluid mb-3" style="max-height: 80px;">
                    <h4>Google Cloud</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="cloud-provider text-center p-4">
                    <img src="https://img.freepik.com/free-icon/ibm_318-674254.jpg" alt="IBM Cloud" class="img-fluid mb-3" style="max-height: 80px;">
                    <h4>IBM Cloud</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cloud Benefits Section -->
<section class="py-5 bg-light animated-bg">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title">Why Choose <span class="text-gradient">IT Sahayta</span> Cloud Solutions?</h2>
                <p class="mb-4">Our cloud computing services offer numerous advantages over traditional on-premises infrastructure, enabling businesses to innovate faster while reducing IT costs.</p>
                
                <div class="accordion" id="cloudBenefitsAccordion">
                    <!-- Cost Efficiency -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#costEfficiency" aria-expanded="true">
                                <i class="fas fa-coins me-2 text-primary"></i> Cost Efficiency
                            </button>
                        </h2>
                        <div id="costEfficiency" class="accordion-collapse collapse show" data-bs-parent="#cloudBenefitsAccordion">
                            <div class="accordion-body">
                                IT Sahayta helps you reduce capital expenses by eliminating the need for hardware purchases and maintenance. Pay only for the resources you use with flexible pricing models that scale with your business needs.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Scalability -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scalability">
                                <i class="fas fa-expand-arrows-alt me-2 text-primary"></i> Scalability & Flexibility
                            </button>
                        </h2>
                        <div id="scalability" class="accordion-collapse collapse" data-bs-parent="#cloudBenefitsAccordion">
                            <div class="accordion-body">
                                With IT Sahayta cloud solutions, easily scale resources up or down based on demand without significant infrastructure changes. Adapt quickly to business growth or seasonal fluctuations without service disruption.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Business Continuity -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#businessContinuity">
                                <i class="fas fa-sync me-2 text-primary"></i> Business Continuity
                            </button>
                        </h2>
                        <div id="businessContinuity" class="accordion-collapse collapse" data-bs-parent="#cloudBenefitsAccordion">
                            <div class="accordion-body">
                                IT Sahayta ensures your business operations continue even during disasters with robust backup and recovery solutions. We leverage cloud providers' redundant systems across multiple geographic locations for maximum reliability.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Innovation -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#innovation">
                                <i class="fas fa-lightbulb me-2 text-primary"></i> Accelerated Innovation
                            </button>
                        </h2>
                        <div id="innovation" class="accordion-collapse collapse" data-bs-parent="#cloudBenefitsAccordion">
                            <div class="accordion-body">
                                With IT Sahayta, access cutting-edge technologies like AI, machine learning, and big data analytics without significant investment. Deploy new applications and services faster with reduced time-to-market.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://img.freepik.com/free-photo/cloud-computing-with-icons-business-process-diagrams_117856-2695.jpg" alt="IT Sahayta Cloud Computing Benefits" class="img-fluid rounded-4 shadow-lg">
                    <div class="stats-overlay">
                        <div class="stats-item">
                            <div class="stats-number">35%</div>
                            <div class="stats-text">Average Cost Savings</div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-number">99.9%</div>
                            <div class="stats-text">Uptime Guarantee</div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-number">3x</div>
                            <div class="stats-text">Faster Deployment</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Case Studies Section -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">IT Sahayta Cloud Success <span class="text-gradient">Stories</span></h2>
            <p class="section-subtitle">See how our cloud solutions have transformed businesses</p>
        </div>
        
        <div class="row g-4">
            <!-- Case Study 1 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="case-study-card h-100">
                    <div class="case-study-image">
                        <img src="https://img.freepik.com/free-photo/business-people-office_23-2147656637.jpg" alt="Financial Services Case Study" class="img-fluid">
                        <div class="industry-badge">Financial Services</div>
                    </div>
                    <div class="case-study-content">
                        <h3>National Bank's Cloud Migration</h3>
                        <p>IT Sahayta helped a national bank migrate their legacy systems to a secure cloud infrastructure, resulting in 40% cost reduction and improved customer experience.</p>
                        <div class="results">
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-chart-line"></i></div>
                                <div class="result-text">40% Cost Reduction</div>
                            </div>
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <div class="result-text">60% Faster Processing</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Case Study 2 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="case-study-card h-100">
                    <div class="case-study-image">
                        <img src="https://img.freepik.com/free-photo/doctor-with-stethoscope-hands-hospital-background_1423-1.jpg" alt="Healthcare Case Study" class="img-fluid">
                        <div class="industry-badge">Healthcare</div>
                    </div>
                    <div class="case-study-content">
                        <h3>Medical Records Cloud Solution</h3>
                        <p>IT Sahayta implemented a HIPAA-compliant cloud solution for a healthcare provider, enabling secure access to patient records and improving collaboration among medical staff.</p>
                        <div class="results">
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-lock"></i></div>
                                <div class="result-text">Enhanced Security</div>
                            </div>
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-clock"></i></div>
                                <div class="result-text">30% Time Savings</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Case Study 3 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="case-study-card h-100">
                    <div class="case-study-image">
                        <img src="https://img.freepik.com/free-photo/retail-store-shop-showroom-with-clothes-hangers_107420-65536.jpg" alt="Retail Case Study" class="img-fluid">
                        <div class="industry-badge">Retail</div>
                    </div>
                    <div class="case-study-content">
                        <h3>Retail Chain's Hybrid Cloud</h3>
                        <p>IT Sahayta designed and implemented a hybrid cloud solution for a retail chain, enabling seamless inventory management and improved customer experience across 50+ locations.</p>
                        <div class="results">
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-shopping-cart"></i></div>
                                <div class="result-text">25% Sales Increase</div>
                            </div>
                            <div class="result-item">
                                <div class="result-icon"><i class="fas fa-database"></i></div>
                                <div class="result-text">Real-time Inventory</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="/views/free-consultation.php" class="btn btn-primary btn-lg">Get Your Success Story Started</a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light animated-bg">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Frequently Asked <span class="text-gradient">Questions</span></h2>
            <p class="section-subtitle">Get answers to common questions about IT Sahayta cloud services</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion faq-accordion" id="cloudFaqAccordion">
                    <!-- Question 1 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                                How secure is IT Sahayta cloud computing for my business data?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#cloudFaqAccordion">
                            <div class="accordion-body">
                                IT Sahayta cloud computing is highly secure when implemented correctly. We partner with major cloud providers who invest billions in security measures that most individual businesses cannot match. Our team implements industry best practices for cloud security including encryption, multi-factor authentication, access controls, and regular security audits. We ensure your cloud environment complies with relevant regulations and industry standards.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How long does cloud migration with IT Sahayta typically take?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#cloudFaqAccordion">
                            <div class="accordion-body">
                                The timeline for cloud migration with IT Sahayta varies depending on the complexity of your existing infrastructure, the amount of data to be migrated, and your specific requirements. Simple migrations can be completed in a few weeks, while complex enterprise migrations may take several months. We provide a detailed migration plan with timelines during our initial assessment and work to minimize disruption to your business operations throughout the process.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Which cloud provider does IT Sahayta recommend for my business?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#cloudFaqAccordion">
                            <div class="accordion-body">
                                IT Sahayta recommends cloud providers based on your specific needs, budget, existing technology stack, and long-term goals. Each major provider (AWS, Azure, Google Cloud, etc.) has different strengths. We conduct a thorough assessment of your requirements and recommend the most suitable provider or a multi-cloud approach if appropriate. Our team is certified across all major platforms and can help you make an informed decision.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 4 -->
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How can IT Sahayta help control cloud costs and avoid unexpected expenses?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#cloudFaqAccordion">
                            <div class="accordion-body">
                                Cloud cost management is a key part of IT Sahayta's service. We implement cost optimization strategies including right-sizing resources, utilizing reserved instances for predictable workloads, setting up budget alerts, and regularly reviewing usage patterns. Our cloud management services include monthly cost analysis reports and recommendations for optimization. We can also implement automated scaling to ensure you only pay for resources when you need them.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 5 -->
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                What happens if I need to change cloud providers in the future with IT Sahayta?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#cloudFaqAccordion">
                            <div class="accordion-body">
                                IT Sahayta designs cloud architectures with portability in mind whenever possible, using containerization, infrastructure as code, and other practices that reduce vendor lock-in. If you need to change providers in the future, we can assist with the migration process. We also document all configurations and deployments thoroughly, which facilitates smoother transitions between providers if needed.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cta-card bg-gradient-primary text-white text-center p-5 rounded-4" data-aos="zoom-in">
                    <h2 class="display-5 fw-bold mb-4">Ready to Transform Your Business with IT Sahayta Cloud Technology?</h2>
                    <p class="lead mb-4">Our cloud experts are ready to help you design, implement, and manage the perfect cloud solution for your business needs.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="/views/free-consultation.php" class="btn btn-light btn-lg px-4">Schedule Free Consultation</a>
                        <a href="tel:+918888888888" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-phone-alt me-2"></i>Call Us Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Add floating clouds animation
    document.addEventListener('DOMContentLoaded', function() {
        const cloudHero = document.querySelector('.cloud-hero');
        if (cloudHero) {
            // Create random floating elements
            for (let i = 0; i < 10; i++) {
                const floatingEl = document.createElement('div');
                floatingEl.className = 'floating-element';
                floatingEl.style.position = 'absolute';
                floatingEl.style.width = Math.random() * 100 + 50 + 'px';
                floatingEl.style.height = floatingEl.style.width;
                floatingEl.style.background = 'rgba(255,255,255,0.03)';
                floatingEl.style.borderRadius = '50%';
                floatingEl.style.top = Math.random() * 100 + '%';
                floatingEl.style.left = Math.random() * 100 + '%';
                floatingEl.style.animation = `float-cloud ${Math.random() * 10 + 15}s linear infinite`;
                cloudHero.appendChild(floatingEl);
            }
        }
    });
</script>

</body>
</html>