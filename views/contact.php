<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - Contact Us | Connect for IT Support and Services</title>
    <meta name="description" content="Get in touch with IT Sahayta for all your IT support needs. Contact us for inquiries, support, or collaboration opportunities.">
    <?php include "assets.php"?>
  
</head>
<body>

<?php include 'header.php'; ?>

<!-- Modern Contact Section -->
<section class="modern-contact-section">
    <div class="contact-container">
        <!-- Floating Background Elements -->
        <div class="contact-shape shape-1"></div>
        <div class="contact-shape shape-2"></div>
        
        <!-- Section Header -->
        <div class="contact-header" data-aos="fade-up">
            <h2 class="contact-title">Let's Connect & Collaborate</h2>
            <p class="contact-subtitle">We're excited to hear from you! Reach out for inquiries, support, or just to say hello.</p>
            <div class="contact-divider">
                <span></span>
                <i class="fas fa-envelope-open-text"></i>
                <span></span>
            </div>
        </div>

        <div class="contact-content">
            <!-- Contact Form -->
            <div class="contact-form-wrapper" data-aos="fade-right">
                <div class="contact-form-card">
                    <div class="form-header">
                        <h3>Send Us a Message</h3>
                        <div class="form-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                    </div>
                    
                    <form class="modern-contact-form" action="/controllers/contact_submit.php" method="POST">
                        <div class="form-group floating">
                            <input type="text" id="name" name="name" required>
                            <label for="name">Full Name</label>
                            <span class="highlight"></span>
                        </div>
                        
                        <div class="form-group floating">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Email Address</label>
                            <span class="highlight"></span>
                        </div>
                        
                        <div class="form-group floating">
                            <input type="text" id="subject" name="subject" required>
                            <label for="subject">Subject</label>
                            <span class="highlight"></span>
                        </div>
                        
                        <div class="form-group floating">
                            <textarea id="message" name="message" rows="3" required></textarea>
                            <label for="message">Your Message</label>
                            <span class="highlight"></span>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <span>Send Message</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-wrapper" data-aos="fade-left">
                <div class="contact-info-card">
                    <div class="info-header">
                        <h3>Our Contact Details</h3>
                        <div class="info-icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                    </div>
                    
                    <div class="contact-details">
                        <!-- Delhi Office -->
                        <div class="office-card">
                            <div class="office-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Delhi</span>
                            </div>
                            <div class="office-info">
                                <p>Badarpur</p>
                                <p>New Delhi - 110044</p>
                                <div class="contact-method">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:+917703823008">+91 77038 23008</a>
                                </div>
                                <div class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:support@itsahayata.com">support@itsahayata.com</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lucknow Office -->
                        <div class="office-card">
                            <div class="office-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Lucknow</span>
                            </div>
                            <div class="office-info">
                                <p>Jankipuram Sector H</p>
                                <p>Lucknow - 226021</p>
                                <div class="contact-method">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:+917379217619">+91 73792 17619</a>
                                </div>
                                <div class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:lucknow@itsahayata.com">lucknow@itsahayata.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-connect">
                        <h4>Connect With Us</h4>
                        <div class="social-links">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-btn instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-btn whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <!-- <div class="contact-map" data-aos="fade-up">
            <iframe src="https://www.google.com/maps/embed?pb=..." allowfullscreen="" loading="lazy"></iframe>
            <div class="map-overlay"></div>
        </div> -->
    </div>
</section>

<style>
/* Modern Contact Section Styles */
.modern-contact-section {
    position: relative;
    padding: 80px 0;
    background-color: #f8faff;
    overflow: hidden;
}

.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

.contact-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(74, 108, 247, 0.1) 0%, rgba(74, 108, 247, 0.05) 100%);
}

.shape-1 {
    width: 400px;
    height: 400px;
    top: -100px;
    right: -100px;
}

.shape-2 {
    width: 600px;
    height: 600px;
    bottom: -300px;
    left: -300px;
}

.contact-header {
    text-align: center;
    margin-bottom: 60px;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 15px;
    background: linear-gradient(90deg, #4a6cf7 0%, #254eda 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.contact-subtitle {
    font-size: 1.1rem;
    color: #718096;
    max-width: 700px;
    margin: 0 auto 25px;
    line-height: 1.6;
}

.contact-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    width: 200px;
}

.contact-divider span {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, rgba(74, 108, 247, 0) 0%, #4a6cf7 50%, rgba(74, 108, 247, 0) 100%);
}

.contact-divider i {
    margin: 0 15px;
    color: #4a6cf7;
    font-size: 1.5rem;
}

.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 60px;
}

.contact-form-wrapper, 
.contact-info-wrapper {
    position: relative;
    height: 100%;
}

.contact-form-card, 
.contact-info-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    padding: 40px;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-form-card:hover, 
.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}

.form-header, 
.info-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.form-header h3, 
.info-header h3 {
    font-size: 1.5rem;
    color: #2d3748;
    font-weight: 600;
}

.form-icon, 
.info-icon {
    width: 50px;
    height: 50px;
    background: rgba(74, 108, 247, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a6cf7;
}

.modern-contact-form {
    display: grid;
    gap: 25px;
}

.form-group {
    position: relative;
}

.form-group.floating input, 
.form-group.floating textarea {
    width: 100%;
    padding: 15px 20px 10px 0;
    border: none;
    border-bottom: 2px solid #e2e8f0;
    background: transparent;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group.floating textarea {
    min-height: 100px;
    resize: vertical;
}

.form-group.floating label {
    position: absolute;
    top: 15px;
    left: 0;
    color: #718096;
    pointer-events: none;
    transition: all 0.3s ease;
}

.form-group.floating .highlight {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: #4a6cf7;
    transition: all 0.3s ease;
}

.form-group.floating input:focus, 
.form-group.floating textarea:focus {
    outline: none;
    border-bottom-color: transparent;
}

.form-group.floating input:focus + label, 
.form-group.floating textarea:focus + label,
.form-group.floating input:not(:placeholder-shown) + label, 
.form-group.floating textarea:not(:placeholder-shown) + label {
    top: -10px;
    font-size: 0.8rem;
    color: #4a6cf7;
}

.form-group.floating input:focus ~ .highlight, 
.form-group.floating textarea:focus ~ .highlight {
    width: 100%;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 25px;
    background: linear-gradient(135deg, #4a6cf7 0%, #254eda 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(74, 108, 247, 0.3);
}

.submit-btn i {
    transition: transform 0.3s ease;
}

.submit-btn:hover i {
    transform: translateX(5px);
}

.contact-details {
    display: grid;
    gap: 20px;
}

.office-card {
    display: flex;
    gap: 15px;
    padding: 20px;
    border-radius: 12px;
    background: #f8faff;
    transition: transform 0.3s ease;
}

.office-card:hover {
    transform: translateX(5px);
}

.office-badge {
    min-width: 60px;
    height: 60px;
    background: rgba(74, 108, 247, 0.1);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #4a6cf7;
}

.office-badge i {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.office-badge span {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.office-info {
    flex: 1;
}

.office-info p {
    color: #4a5568;
    margin-bottom: 8px;
    line-height: 1.5;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
    color: #4a5568;
}

.contact-method i {
    color: #4a6cf7;
}

.contact-method a {
    color: #4a5568;
    text-decoration: none;
    transition: color 0.2s;
}

.contact-method a:hover {
    color: #4a6cf7;
}

.social-connect {
    margin-top: 40px;
}

.social-connect h4 {
    font-size: 1.1rem;
    color: #2d3748;
    margin-bottom: 15px;
    text-align: center;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.social-btn.facebook { background: #3b5998; }
.social-btn.twitter { background: #1da1f2; }
.social-btn.linkedin { background: #0077b5; }
.social-btn.instagram { background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d); }
.social-btn.whatsapp { background: #25d366; }

.social-btn:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.contact-map {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
    height: 400px;
}

.contact-map iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.map-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .contact-content {
        grid-template-columns: 1fr;
    }
    
    .contact-form-card, 
    .contact-info-card {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .contact-title {
        font-size: 2rem;
    }
    
    .contact-subtitle {
        font-size: 1rem;
    }
    
    .form-header, 
    .info-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .form-icon, 
    .info-icon {
        display: none;
    }
}

@media (max-width: 576px) {
    .modern-contact-section {
        padding: 60px 0;
    }
    
    .contact-header {
        margin-bottom: 40px;
    }
    
    .contact-form-card, 
    .contact-info-card {
        padding: 25px;
    }
    
    .office-card {
        flex-direction: column;
    }
    
    .contact-map {
        height: 300px;
    }
}
</style>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-out-quart'
    });
</script>

<?php include 'footer.php'; ?>