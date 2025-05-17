<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Hardware Support Services | Expert Computer Repair</title>
    <meta name="description" content="Professional hardware support and repair services for computers, laptops, servers, and peripherals. Get expert diagnostics, component replacement, and upgrades.">
    <meta name="keywords" content="hardware support, computer repair, laptop repair, hardware troubleshooting, component replacement, hardware upgrade, IT support services">
    <?php include "assets.php"?>
    <style>
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
        }
        
        /* Hero Section Styles */
        .hardware-hero {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            position: relative;
            padding: 100px 0;
            overflow: hidden;
        }
        
        .hardware-hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"%3E%3Cpath fill="%234361ee" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,208C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"%3E%3C/path%3E%3C/svg%3E');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }
        
        .z-1 {
            position: relative;
            z-index: 1;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            padding: 10px 15px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .benefit-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.9);
        }
        
        .benefit-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
            font-size: 18px;
        }
        
        /* Hardware Illustration */
        .hardware-illustration {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transform: perspective(1000px) rotateY(-5deg);
            transition: all 0.5s ease;
        }
        
        .hardware-illustration:hover {
            transform: perspective(1000px) rotateY(0deg);
        }
        
        .hardware-illustration img {
            transition: all 0.5s ease;
        }
        
        .hardware-illustration:hover img {
            transform: scale(1.05);
        }
        
        .floating-badge {
            position: absolute;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        /* Service Cards */
        .service-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 28px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .service-card:hover .service-icon {
            background-color: var(--primary) !important;
            color: white !important;
            transform: scale(1.1) rotate(10deg);
        }
        
        .service-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .service-features li {
            padding: 8px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
        }
        
        .service-features li:last-child {
            border-bottom: none;
        }
        
        /* Process Steps */
        .process-step {
            position: relative;
            padding-left: 80px;
            margin-bottom: 40px;
        }
        
        .step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }
        
        .process-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 30px;
            top: 60px;
            width: 2px;
            height: calc(100% - 30px);
            background: var(--primary-light);
        }
        
        /* Hardware Components Section */
        .component-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .component-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .component-img {
            height: 200px;
            overflow: hidden;
        }
        
        .component-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .component-card:hover .component-img img {
            transform: scale(1.1);
        }
        
        /* FAQ Section */
        .faq-item {
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .faq-item:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
        
        .faq-question {
            padding: 20px;
            background-color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background-color: rgba(224, 231, 255, 0.2);
        }
        
        .faq-item.active .faq-answer {
            padding: 20px;
            max-height: 1000px;
        }
        
        .faq-toggle {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            transition: all 0.3s ease;
        }
        
        .faq-item.active .faq-toggle {
            transform: rotate(45deg);
            background-color: var(--primary);
            color: white;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,181.3C960,181,1056,203,1152,208C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"%3E%3C/path%3E%3C/svg%3E');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
        }
        
        .cta-content {
            position: relative;
            z-index: 1;
        }
        
        .cta-btn {
            background-color: white;
            font-weight: 600;
            padding: 15px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .cta-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background-color: var(--light);
        }
        
        /* Testimonial Section */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .client-info {
            display: flex;
            align-items: center;
        }
        
        .client-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }
        
        .client-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .quote-icon {
            font-size: 50px;
            color: rgba(67, 97, 238, 0.1);
            line-height: 1;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<!-- Hardware Support Hero Section -->
<section class="hardware-hero position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Expert <span class="text-gradient">Hardware Support</span> Services</h1>
                <p class="lead mb-4">Professional diagnosis, repair, and maintenance for all your computer hardware needs. From component replacement to performance upgrades, we've got you covered.</p>
                
                <div class="benefits-list mb-5">
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Certified Hardware Technicians</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Genuine Replacement Parts</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>90-Day Repair Warranty</span>
                    </div>
                </div>
                
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="/views/book_slot.php" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-tools me-2"></i> Book Repair Service
                    </a>
                    <a href="tel:+917703823008" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fas fa-phone-alt me-2"></i> Call Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hardware-illustration p-4 p-lg-5">
                    <img src="https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Hardware Support Services" class="img-fluid rounded-4 shadow">
                    <div class="floating-badge bg-success text-white">
                        <i class="fas fa-shield-alt me-2"></i> Expert Repairs
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hardware Services Section -->
<section class="hardware-services py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Our <span class="text-gradient">Hardware Services</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Comprehensive hardware support solutions for businesses and individuals</p>
        </div>

        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="h4 mb-3">Computer & Laptop Repair</h3>
                    <p class="text-muted mb-4">Expert diagnosis and repair services for desktops and laptops of all brands including Dell, HP, Lenovo, Apple, and more.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Motherboard repairs</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Screen replacements</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Keyboard & trackpad fixes</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3 class="h4 mb-3">Server & Network Hardware</h3>
                    <p class="text-muted mb-4">Professional maintenance and repair of server infrastructure, network devices, and enterprise hardware systems.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Server diagnostics</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Router & switch repair</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Rack installation</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3 class="h4 mb-3">Component Upgrades</h3>
                    <p class="text-muted mb-4">Performance enhancement through strategic hardware upgrades tailored to your specific needs and budget.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> RAM & storage upgrades</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Graphics card installation</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> CPU upgrades</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-hdd"></i>
                    </div>
                    <h3 class="h4 mb-3">Data Recovery</h3>
                    <p class="text-muted mb-4">Specialized recovery services for data from damaged, failed, or corrupted storage devices and hard drives.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Hard drive recovery</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> SSD data retrieval</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> RAID recovery</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 5 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="h4 mb-3">Printer & Peripheral Repair</h3>
                    <p class="text-muted mb-4">Troubleshooting and repair services for printers, scanners, and other essential office peripherals.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Printer maintenance</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Scanner repairs</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Peripheral configuration</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 6 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-fan"></i>
                    </div>
                    <h3 class="h4 mb-3">Cooling & Performance</h3>
                    <p class="text-muted mb-4">Optimization of system cooling and thermal management to ensure peak performance and hardware longevity.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Thermal paste application</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Fan replacement</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Cooling system upgrades</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Process Section -->
<section class="process-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h2 class="display-5 fw-bold mb-4">Our <span class="text-gradient">Repair Process</span></h2>
                <p class="lead mb-5">We follow a systematic approach to diagnose and fix hardware issues efficiently</p>
                
                <div class="process-steps">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h3 class="h5 mb-2">Initial Diagnosis</h3>
                        <p class="text-muted">We perform a comprehensive assessment to identify the root cause of hardware issues.</p>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h3 class="h5 mb-2">Detailed Quote</h3>
                        <p class="text-muted">You receive a transparent cost estimate with no hidden fees before any work begins.</p>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h3 class="h5 mb-2">Expert Repair</h3>
                        <p class="text-muted">Our certified technicians perform the repair using genuine parts and components.</p>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h3 class="h5 mb-2">Quality Testing</h3>
                        <p class="text-muted">We thoroughly test all repairs to ensure optimal performance and reliability.</p>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">5</div>
                        <h3 class="h5 mb-2">Warranty Support</h3>
                        <p class="text-muted">All our hardware repairs come with a 90-day warranty for your peace of mind.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Hardware Repair Process" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Hardware Components Section -->
<section class="components-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Hardware <span class="text-gradient">Components</span> We Service</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">We provide expert repair and replacement services for all major computer components</p>
        </div>
        
        <div class="row g-4">
            <!-- Component 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1591370874773-6702e8f12fd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Motherboards">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Motherboards</h3>
                        <p class="text-muted mb-0">Repair and replacement of motherboards for all computer types and brands.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1555680202-c86f0e12f086?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="CPU Processors">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">CPU Processors</h3>
                        <p class="text-muted mb-0">Installation and upgrading of Intel and AMD processors for better performance.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="component-card h-100">
                <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1562976540-1502c2145186?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1031&q=80" alt="RAM Memory">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">RAM Memory</h3>
                        <p class="text-muted mb-0">Memory upgrades and replacements to improve system performance and multitasking.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 4 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1517320069935-30fb4354e5f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Storage Drives">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Storage Drives</h3>
                        <p class="text-muted mb-0">HDD and SSD installation, upgrades, and data migration services.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 5 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1591489378430-ef2f4c626b35?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Graphics Cards">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Graphics Cards</h3>
                        <p class="text-muted mb-0">GPU installation and upgrades for gaming, design, and professional workstations.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 6 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Power Supplies">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Power Supplies</h3>
                        <p class="text-muted mb-0">PSU diagnostics, replacement, and upgrades for stable system performance.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 7 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1587302912306-cf1ed9c33146?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" alt="Cooling Systems">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Cooling Systems</h3>
                        <p class="text-muted mb-0">Installation and maintenance of air and liquid cooling solutions for optimal temperatures.</p>
                    </div>
                </div>
            </div>
            
            <!-- Component 8 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="700">
                <div class="component-card h-100">
                    <div class="component-img">
                        <img src="https://images.unsplash.com/photo-1544099858-75feeb57f01b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Display Screens">
                    </div>
                    <div class="p-3">
                        <h3 class="h5 mb-2">Display Screens</h3>
                        <p class="text-muted mb-0">Laptop and monitor screen replacement and repair services.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Process Section -->
<section class="process-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Our <span class="text-gradient">Repair Process</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">We follow a systematic approach to ensure efficient and effective hardware repairs</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h3 class="h4 mb-3">Diagnosis & Assessment</h3>
                    <p class="text-muted">Our certified technicians perform a comprehensive diagnostic assessment to identify the root cause of hardware issues using professional-grade tools and testing equipment.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h3 class="h4 mb-3">Detailed Quote</h3>
                    <p class="text-muted">We provide a transparent, no-obligation quote detailing the required repairs, replacement parts, estimated labor costs, and expected completion time.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h3 class="h4 mb-3">Expert Repair</h3>
                    <p class="text-muted">Upon approval, our skilled technicians perform the necessary repairs using genuine parts and following manufacturer-recommended procedures and best practices.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h3 class="h4 mb-3">Quality Testing</h3>
                    <p class="text-muted">Every repair undergoes rigorous testing to ensure optimal performance, stability, and reliability before being returned to the customer.</p>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="p-4 p-lg-5 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="h5 mb-0">90-Day Repair Warranty</h3>
                        </div>
                        <p class="text-muted mb-0">All our hardware repairs come with a 90-day warranty covering both parts and labor for your peace of mind.</p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h3 class="h5 mb-0">Genuine Parts Only</h3>
                        </div>
                        <p class="text-muted mb-0">We use only genuine or manufacturer-approved replacement parts to ensure quality and compatibility.</p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3 class="h5 mb-0">Certified Technicians</h3>
                        </div>
                        <p class="text-muted mb-0">Our repair team consists of certified professionals with extensive experience in hardware troubleshooting and repair.</p>
                    </div>
                    
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="h5 mb-0">Quick Turnaround</h3>
                        </div>
                        <p class="text-muted mb-0">Most repairs are completed within 24-48 hours, with expedited service available for urgent needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Frequently Asked <span class="text-gradient">Questions</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Common questions about our hardware support services</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-list" data-aos="fade-up">
                    <!-- FAQ Item 1 -->
                    <div class="faq-item" id="faq1">
                        <div class="faq-question" onclick="toggleFaq('faq1')">
                            <span>How long does a typical hardware repair take?</span>
                            <div class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p>Most standard hardware repairs are completed within 24-48 hours after diagnosis. Simple issues like RAM replacement or fan repairs can often be done on the same day. More complex repairs involving motherboards or data recovery may take 3-5 business days. We always provide an estimated completion time during the initial assessment.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="faq-item" id="faq2">
                        <div class="faq-question" onclick="toggleFaq('faq2')">
                            <span>Do you offer on-site hardware support?</span>
                            <div class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we provide on-site hardware support for businesses and residential clients. Our mobile technicians can perform many repairs at your location, minimizing downtime. On-site services are available for desktop computers, workstations, printers, network equipment, and some laptop repairs. For complex issues requiring specialized equipment, we may recommend bringing the device to our repair center.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="faq-item" id="faq3">
                        <div class="faq-question" onclick="toggleFaq('faq3')">
                            <span>What happens to my data during hardware repair?</span>
                            <div class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p>We prioritize data protection during all hardware repairs. Whenever possible, we perform repairs without affecting your data. For repairs involving storage devices, we recommend backing up your data before service. If you don't have a backup, we can create one for an additional fee. Our technicians follow strict data privacy protocols, and we never access your personal files unless specifically requested to recover or transfer data.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="faq-item" id="faq4">
                        <div class="faq-question" onclick="toggleFaq('faq4')">
                            <span>Are replacement parts new or refurbished?</span>
                            <div class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p>We primarily use new, genuine parts for all our hardware repairs. In some cases, especially for older or discontinued models, we may recommend manufacturer-certified refurbished parts. These refurbished components undergo rigorous testing and come with the same warranty as new parts. We always inform you about the type of parts being used before proceeding with repairs, and you have the final say in the decision.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 5 -->
                    <div class="faq-item" id="faq5">
                        <div class="faq-question" onclick="toggleFaq('faq5')">
                            <span>What if the repair doesn't fix my problem?</span>
                            <div class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p>We stand behind our work with a 90-day repair warranty. If the same issue recurs within this period, we'll diagnose and fix it at no additional cost. If we determine that a repair isn't possible or cost-effective, we'll only charge for the diagnostic fee and provide recommendations for replacement options. Our goal is your satisfaction, and we're committed to transparent, honest service.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">What Our <span class="text-gradient">Clients Say</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Real feedback from customers who've used our hardware support services</p>
        </div>
        
        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="testimonial-card h-100">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="mb-4">The technician diagnosed and fixed my laptop's overheating issue in just one day. They replaced the cooling fan and cleaned the entire system. It's running better than ever now!</p>
                    <div class="client-info">
                        <div class="client-img">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Rajesh Kumar">
                        </div>
                        <div>
                            <h4 class="h6 mb-1">Rajesh Kumar</h4>
                            <p class="text-muted small mb-0">Business Owner</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="mb-4">After my hard drive crashed, I thought I'd lost years of family photos. The data recovery team at IT Sahayata recovered 98% of my files! Their service was professional and worth every rupee.</p>
                    <div class="client-info">
                        <div class="client-img">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priya Sharma">
                        </div>
                        <div>
                            <h4 class="h6 mb-1">Priya Sharma</h4>
                            <p class="text-muted small mb-0">Photographer</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="mb-4">Our company's server went down during a critical project. The IT Sahayata team arrived within an hour, identified a faulty power supply, and had us back online by the end of the day. Exceptional service!</p>
                    <div class="client-info">
                        <div class="client-img">
                            <img src="https://randomuser.me/api/portraits/men/62.jpg" alt="Vikram Mehta">
                        </div>
                        <div>
                            <h4 class="h6 mb-1">Vikram Mehta</h4>
                            <p class="text-muted small mb-0">IT Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center text-white" data-aos="zoom-in">
            <h2 class="display-5 fw-bold mb-4">Ready to Fix Your Hardware Issues?</h2>
            <p class="lead mb-5" style="max-width: 700px; margin: 0 auto;">Our expert technicians are standing by to diagnose and repair your computer hardware problems. Book a service today!</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="/views/book_slot.php" class="cta-btn text-primary">
                    <i class="fas fa-calendar-check me-2"></i> Schedule Repair
                </a>
                <a href="tel:+917703823008" class="cta-btn text-primary">
                    <i class="fas fa-phone-alt me-2"></i> Call for Emergency Support
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Toggle Script -->
<script>
    function toggleFaq(id) {
        const faqItem = document.getElementById(id);
        if (faqItem.classList.contains('active')) {
            faqItem.classList.remove('active');
        } else {
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
            // Open this FAQ
            faqItem.classList.add('active');
        }
    }
    
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        once: true
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>