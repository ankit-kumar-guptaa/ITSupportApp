<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Our Services | Professional IT Support Solutions</title>
    <meta name="description" content="Explore IT Sahayata's comprehensive range of IT support services including hardware repair, software troubleshooting, network solutions, and cybersecurity.">
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
        .services-hero {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            position: relative;
            padding: 100px 0;
            overflow: hidden;
        }
        
        .services-hero::before {
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
        
        /* Services Illustration */
        .services-illustration {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transform: perspective(1000px) rotateY(-5deg);
            transition: all 0.5s ease;
        }
        
        .services-illustration:hover {
            transform: perspective(1000px) rotateY(0deg);
        }
        
        .services-illustration img {
            transition: all 0.5s ease;
        }
        
        .services-illustration:hover img {
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
        
        /* Pricing Cards */
        .pricing-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .pricing-card.popular {
            transform: scale(1.05);
            border: 2px solid var(--primary);
            z-index: 2;
        }
        
        .pricing-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
        
        .popular-badge {
            position: absolute;
            top: 15px;
            right: -35px;
            background: var(--primary);
            color: white;
            padding: 5px 40px;
            font-size: 14px;
            font-weight: 600;
            transform: rotate(45deg);
        }
        
        .pricing {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .currency {
            font-size: 24px;
            font-weight: 600;
            vertical-align: top;
            position: relative;
            top: 5px;
        }
        
        .amount {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            color: var(--primary);
        }
        
        .period {
            font-size: 16px;
            color: var(--gray);
        }
        
        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pricing-features li {
            padding: 10px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
        }
        
        /* Testimonial Cards */
        .testimonial-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
        
        .testimonial-text {
            font-style: italic;
            position: relative;
            padding-left: 20px;
        }
        
        .testimonial-text::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -10px;
            font-size: 40px;
            color: rgba(67, 97, 238, 0.2);
            font-family: Georgia, serif;
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
            /* color: var(--primary); */
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
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .pricing-card.popular {
                transform: scale(1);
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        /* Floating Elements */
        .floating-element {
            position: absolute;
            z-index: 0;
            opacity: 0.5;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--primary-light), transparent);
            border-radius: 50%;
            animation-delay: 0s;
        }
        
        .floating-2 {
            bottom: 20%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, var(--primary-light), transparent);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 1s;
        }
        
        .floating-3 {
            top: 40%;
            right: 30%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--primary-light), transparent);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 2s;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<!-- Services Hero Section -->
<section class="services-hero position-relative overflow-hidden">
    <div class="floating-element floating-1"></div>
    <div class="floating-element floating-2"></div>
    <div class="floating-element floating-3"></div>
    
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Professional <span class="text-gradient">IT Support</span> Services</h1>
                <p class="lead mb-4">From hardware repairs to network security, our certified IT specialists provide comprehensive solutions for businesses and individuals.</p>
                
                <div class="benefits-list mb-5">
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>24/7 Technical Support</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Certified IT Professionals</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Affordable Service Plans</span>
                    </div>
                </div>
                
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="/views/free-consultation.php" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-calendar-check me-2"></i> Free Consultation
                    </a>
                    <a href="tel:+917703823008" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fas fa-phone-alt me-2"></i> Call Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="services-illustration p-4 p-lg-5">
                    <img src="../assets/service.png" alt="IT Support Services" class="img-fluid rounded-4 shadow">
                    <div class="floating-badge bg-success text-white">
                        <i class="fas fa-shield-alt me-2"></i> Trusted Service
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Services Section -->
<section class="main-services py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Our <span class="text-gradient">Core Services</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Comprehensive IT solutions tailored to meet your specific needs</p>
        </div>

        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-laptop-medical"></i>
                    </div>
                    <h3 class="h4 mb-3">Hardware Repair & Support</h3>
                    <p class="text-muted mb-4">Expert diagnosis and repair services for computers, laptops, servers, printers, and other IT hardware.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Component replacement</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Performance upgrades</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Data recovery</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="h4 mb-3">Software Troubleshooting</h3>
                    <p class="text-muted mb-4">Resolution of software issues, installation, configuration, and optimization for improved performance.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> OS installation & updates</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Software configuration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Error resolution</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3 class="h4 mb-3">Network Solutions</h3>
                    <p class="text-muted mb-4">Design, implementation, and maintenance of reliable and secure network infrastructure for businesses.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Network setup & configuration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Wi-Fi optimization</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Connectivity troubleshooting</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="h4 mb-3">Cybersecurity Services</h3>
                    <p class="text-muted mb-4">Protection against cyber threats with comprehensive security solutions and best practices implementation.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Security assessments</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Malware removal</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Data encryption</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 5 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3 class="h4 mb-3">Cloud Computing</h3>
                    <p class="text-muted mb-4">Migration, setup, and management of cloud services to enhance flexibility, scalability, and accessibility.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Cloud migration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Data backup solutions</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Cloud infrastructure management</li>
                    </ul>
                </div>
            </div>
            
            <!-- Service 6 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-icon mb-4 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="h4 mb-3">IT Consulting</h3>
                    <p class="text-muted mb-4">Strategic IT planning and consultation services to align technology with business objectives.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i> IT infrastructure assessment</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Technology roadmapping</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Budget planning</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Pricing Section -->
<section class="pricing-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Affordable <span class="text-gradient">Service Plans</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Choose the perfect support package that fits your needs and budget</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Basic Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="pricing-card h-100 p-4 bg-white rounded-4 shadow-sm text-center">
                    <h3 class="h4 mb-4">Basic Support</h3>
                    <div class="pricing mb-4">
                        <span class="currency">₹</span>
                        <span class="amount">1,999</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="text-muted mb-4">Perfect for small businesses and individuals with basic IT needs</p>
                    <ul class="pricing-features text-start mb-4">
                        <li><i class="fas fa-check-circle text-success me-2"></i> 8/5 Technical support</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Remote troubleshooting</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Software assistance</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Email & chat support</li>
                        <li class="text-muted"><i class="fas fa-times-circle text-danger me-2"></i> On-site support</li>
                        <li class="text-muted"><i class="fas fa-times-circle text-danger me-2"></i> Hardware repair</li>
                    </ul>
                    <a href="/views/contact.php" class="btn btn-outline-primary w-100">Choose Plan</a>
                </div>
            </div>
            
            <!-- Professional Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="pricing-card popular h-100 p-4 bg-white rounded-4 shadow-sm text-center">
                    <div class="popular-badge">Most Popular</div>
                    <h3 class="h4 mb-4">Professional Support</h3>
                    <div class="pricing mb-4">
                        <span class="currency">₹</span>
                        <span class="amount">4,999</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="text-muted mb-4">Ideal for growing businesses with moderate IT requirements</p>
                    <ul class="pricing-features text-start mb-4">
                        <li><i class="fas fa-check-circle text-success me-2"></i> 24/6 Technical support</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Remote troubleshooting</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Software assistance</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Priority email & phone support</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Monthly on-site visit</li>
                        <li class="text-muted"><i class="fas fa-times-circle text-danger me-2"></i> Hardware repair included</li>
                    </ul>
                    <a href="/views/contact.php" class="btn btn-primary w-100">Choose Plan</a>
                </div>
            </div>
            
            <!-- Enterprise Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-card h-100 p-4 bg-white rounded-4 shadow-sm text-center">
                    <h3 class="h4 mb-4">Enterprise Support</h3>
                    <div class="pricing mb-4">
                        <span class="currency">₹</span>
                        <span class="amount">9,999</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="text-muted mb-4">Comprehensive solution for businesses with complex IT infrastructure</p>
                    <ul class="pricing-features text-start mb-4">
                        <li><i class="fas fa-check-circle text-success me-2"></i> 24/7 Technical support</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Remote troubleshooting</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Software assistance</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Dedicated support manager</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Unlimited on-site support</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Hardware repair included</li>
                    </ul>
                    <a href="/views/contact.php" class="btn btn-outline-primary w-100">Choose Plan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">What Our <span class="text-gradient">Clients Say</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Hear from businesses and individuals who have experienced our IT support services</p>
        </div>
        
        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="testimonial-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="d-flex align-items-center mb-4">
                        <!-- <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="rounded-circle" width="60" height="60"> -->
                        <div class="ms-3">
                            <h4 class="h5 mb-1">Rajesh Sharma</h4>
                            <p class="small text-muted mb-0">Small Business Owner</p>
                        </div>
                    </div>
                    <div class="testimonial-text mb-3">
                        <p class="mb-0">IT Sahayata has been a game-changer for my business. Their prompt support and technical expertise have saved us countless hours of downtime. Highly recommended!</p>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="d-flex align-items-center mb-4">
                        <!-- <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="rounded-circle" width="60" height="60"> -->
                        <div class="ms-3">
                            <h4 class="h5 mb-1">Priya Patel</h4>
                            <p class="small text-muted mb-0">Marketing Agency Director</p>
                        </div>
                    </div>
                    <div class="testimonial-text mb-3">
                        <p class="mb-0">The team at IT Sahayata understands our unique needs and provides tailored solutions. Their network setup has significantly improved our productivity and security.</p>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100 p-4 bg-white rounded-4 shadow-sm">
                    <div class="d-flex align-items-center mb-4">
                        <!-- <img src="https://randomuser.me/api/portraits/men/62.jpg" alt="Client" class="rounded-circle"        width="60" height="60"> -->
                        <div class="ms-3">
                            <h4 class="h5 mb-1">Vikram Singh</h4>
                            <p class="small text-muted mb-0">Healthcare Professional</p>
                        </div>
                    </div>
                    <div class="testimonial-text mb-3">
                        <p class="mb-0">When our critical systems went down, IT Sahayata responded within minutes. Their 24/7 support gives us peace of mind knowing our IT infrastructure is in capable hands.</p>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Frequently <span class="text-gradient">Asked Questions</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Find answers to common questions about our IT support services</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="faq-list">
                    <!-- FAQ Item 1 -->
                    <div class="faq-item active">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>What types of IT issues can you help with?</span>
                            <div class="faq-toggle">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>We provide comprehensive IT support for a wide range of issues including hardware repairs, software troubleshooting, network setup and maintenance, cybersecurity, data recovery, system upgrades, and more. Our certified technicians can assist with both simple and complex IT problems for businesses and individuals.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>How quickly can you respond to IT emergencies?</span>
                            <div class="faq-toggle">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>For critical IT emergencies, our average response time is under 30 minutes. We offer 24/7 support for our Enterprise clients and extended hours for other service plans. Remote support is often initiated immediately, while on-site support timing depends on your location and service level agreement.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Do you offer remote IT support?</span>
                            <div class="faq-toggle">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we provide secure remote IT support for many issues that don't require physical intervention. Our remote support is fast, efficient, and uses encrypted connections to ensure your data remains secure. This allows us to resolve many problems without the need for an on-site visit.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>What are your service hours?</span>
                            <div class="faq-toggle">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>Our standard service hours are Monday to Friday, 9:00 AM to 6:00 PM. However, we offer extended support hours and 24/7 emergency support for clients on our Professional and Enterprise plans. Weekend support is available by appointment or included in higher-tier service packages.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 5 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Do you provide support for both Windows and Mac systems?</span>
                            <div class="faq-toggle">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, our technicians are certified to support both Windows and Mac operating systems, as well as Linux environments. We can assist with hardware and software issues across all major platforms, ensuring comprehensive support regardless of your technology ecosystem.</p>
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
        <div class="cta-content text-center text-white" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-4">Ready to solve your IT challenges?</h2>
            <p class="lead mb-5">Get professional IT support from our certified technicians today</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="/views/free-consultation.php" class="cta-btn">
                    <i class="fas fa-calendar-check me-2"></i> Schedule Free Consultation
                </a>
                <a href="tel:+917703823008" class="cta-btn">
                    <i class="fas fa-phone-alt me-2"></i> Call Us Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    // FAQ Toggle Function
    function toggleFaq(element) {
        const faqItem = element.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // If the clicked item wasn't active, open it
        if (!isActive) {
            faqItem.classList.add('active');
        }
    }
    
    // Initialize AOS Animation Library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
</script>

</body>
</html>