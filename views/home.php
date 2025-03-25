<?php include 'header.php'; ?>

<style>
    :root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --dark-color: #2c3e50;
    --light-color: #ecf0f1;
    --text-color: #333;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    scroll-behavior: smooth;
}

/* Hero Section */
.hero {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.slides {
    position: relative;
    height: 100%;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slide.active {
    opacity: 1;
}

.hero-text {
    text-align: center;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    padding: 40px;
    border-radius: 15px;
    max-width: 600px;
}

.hero-text h1 {
    font-size: 3rem;
    margin-bottom: 20px;
    font-weight: bold;
}

.cta-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 12px 30px;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    margin-top: 20px;
}

.cta-btn:hover {
    background-color: var(--secondary-color);
    transform: translateY(-5px);
}

/* How It Works Section */
.how-it-works, 
.categories, 
.why-choose-us, 
.testimonials {
    padding: 80px 20px;
    text-align: center;
}

.steps, .category-grid, .features, .testimonial-grid {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 50px;
}

.step, .category-card, .feature {
    flex: 1;
    background-color: var(--light-color);
    padding: 30px;
    border-radius: 15px;
    transition: transform 0.3s ease;
}

.step:hover, .category-card:hover, .feature:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.step .icon, .category-card .category-icon, .feature .feature-icon {
    font-size: 3rem;
    margin-bottom: 20px;
}

/* Testimonials Section */
.testimonials {
    background-color: #f4f4f4;
}

.testimonial {
    background-color: white;
    padding: 30px;
    border-radius: 15px;
    max-width: 350px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Call to Action Section */
.cta-section {
    background-color: var(--primary-color);
    color: white;
    text-align: center;
    padding: 80px 20px;
}

.cta-content {
    max-width: 700px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

/* Contact Section */
.contact {
    background-size: cover;
    background-position: center;
    padding: 80px 20px;
    color: white;
}

.contact-box {
    background: rgba(0, 0, 0, 0.7);
    padding: 40px;
    border-radius: 15px;
    max-width: 500px;
}

.contact-icon {
    margin-right: 10px;
}

.contact-box a {
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .steps, .category-grid, .features, .testimonial-grid {
        flex-direction: column;
    }
    
    .hero-text h1 {
        font-size: 2rem;
    }
}
</style>
<main>
    <!-- Hero Section with Auto-Slide -->
    <section class="hero">
        <div class="slides">
            <div class="slide active" style="background-image: url('https://www.gosky.co.th/th/wp-content/uploads/2019/07/it-solutions-banner.jpg');">
                <div class="hero-text" data-aos="fade-down">
                    <h1>Fast IT Solutions</h1>
                    <p>Resolve your tech issues with a single click!</p>
                    <a href="/report" class="cta-btn">Report Now</a>
                </div>
            </div>
            <div class="slide" style="background-image: url('/ITSupportApp/assets/images/hero2.jpg');">
                <div class="hero-text" data-aos="fade-down">
                    <h1>Expert Support 24/7</h1>
                    <p>Our team is here to fix your gadgets anytime.</p>
                    <a href="/report" class="cta-btn">Get Help</a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <h2 data-aos="fade-up">How It Works</h2>
        <div class="steps">
            <div class="step" data-aos="fade-up" data-aos-delay="100">
                <span class="icon">📋</span>
                <h3>1. Report Issue</h3>
                <p>Fill out a simple form with your problem details.</p>
            </div>
            <div class="step" data-aos="fade-up" data-aos-delay="200">
                <span class="icon">👨‍💻</span>
                <h3>2. Agent Assigned</h3>
                <p>An expert will be assigned to solve your issue.</p>
            </div>
            <div class="step" data-aos="fade-up" data-aos-delay="300">
                <span class="icon">✅</span>
                <h3>3. Problem Resolved</h3>
                <p>Get your device back to normal in no time!</p>
            </div>
        </div>
    </section>

    <!-- Support Categories -->
    <section class="categories" id="categories">
        <h2 data-aos="fade-up">Support Categories</h2>
        <div class="category-grid">
            <div class="category-card" data-aos="zoom-in" data-aos-delay="100">
                <span class="category-icon">🖥️</span>
                <h3>Hardware</h3>
                <p>Laptops, printers, or any device issues.</p>
            </div>
            <div class="category-card" data-aos="zoom-in" data-aos-delay="200">
                <span class="category-icon">💻</span>
                <h3>Software</h3>
                <p>App crashes, updates, or installations.</p>
            </div>
            <div class="category-card" data-aos="zoom-in" data-aos-delay="300">
                <span class="category-icon">🌐</span>
                <h3>Network</h3>
                <p>Wi-Fi, VPN, or connectivity problems.</p>
            </div>
        </div>
    </section> 
    <!-- Why Choose Us -->
    <section class="why-choose-us" id="why-choose-us">
        <h2 data-aos="fade-up">Why Choose Us</h2>
        <div class="features">
            <div class="feature" data-aos="fade-right" data-aos-delay="100">
                <span class="feature-icon">⚡</span>
                <h3>Quick Response</h3>
                <p>We respond to your issues within minutes.</p>
            </div>
            <div class="feature" data-aos="fade-right" data-aos-delay="200">
                <span class="feature-icon">🛠️</span>
                <h3>Expert Technicians</h3>
                <p>Certified professionals to handle all your tech problems.</p>
            </div>
            <div class="feature" data-aos="fade-right" data-aos-delay="300">
                <span class="feature-icon">🔒</span>
                <h3>Secure Service</h3>
                <p>Your data and privacy are our top priority.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <h2 data-aos="fade-up">What Our Users Say</h2>
        <div class="testimonial-grid">
            <div class="testimonial" data-aos="flip-left" data-aos-delay="100">
                <p>"IT Support Hub fixed my laptop issue in just an hour! Amazing service."</p>
                <h4>Rahul Sharma</h4>
                <span>Software Engineer</span>
            </div>
            <div class="testimonial" data-aos="flip-left" data-aos-delay="200">
                <p>"Their team is so professional. My network issue was resolved quickly."</p>
                <h4>Priya Singh</h4>
                <span>Freelancer</span>
            </div>
            <div class="testimonial" data-aos="flip-left" data-aos-delay="300">
                <p>"Best IT support service I've ever used. Highly recommend!"</p>
                <h4>Amit Patel</h4>
                <span>Business Owner</span>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section" id="cta">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Need Help with Your Tech?</h2>
            <p>Don't wait—report your issue now and let our experts assist you!</p>
            <a href="/report" class="cta-btn">Get Started</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact" style="background-image: url('/ITSupportApp/assets/images/contact-bg.jpg');">
        <div class="contact-box" data-aos="fade-right">
            <h2>Contact Us</h2>
            <p><span class="contact-icon">📧</span> Email: <a href="mailto:support@itsupporthub.com">support@itsupporthub.com</a></p>
            <p><span class="contact-icon">📞</span> Phone: +91-123-456-7890</p>
            <p><span class="contact-icon">⏰</span> Hours: Mon-Fri, 9 AM - 5 PM</p>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>