<?php include 'header.php'; ?>

<?php
// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config/email.php'; // Include your email configuration
    
    // Collect form data
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $business = $_POST['business'] ?? '';
    $issues = $_POST['issues'] ?? '';
    $preferred_date = $_POST['preferred-date'] ?? '';
    $preferred_time = $_POST['preferred-time'] ?? '';
    
    // Admin email details
    $admin_email = 'theankitkumarg@gmail.com';
    $admin_subject = 'New Consultation Booking - IT Sahayata';
    
    // User email details
    $user_subject = 'Your IT Consultation Booking Confirmation';
    
    // Prepare email content for admin
    $admin_body = "
    <h2>New Consultation Booking Received</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Business:</strong> $business</p>
    <p><strong>IT Issues:</strong> $issues</p>
    <p><strong>Preferred Date:</strong> $preferred_date</p>
    <p><strong>Preferred Time:</strong> $preferred_time</p>
    <p>This booking was received on " . date('Y-m-d H:i:s') . "</p>
    ";
    
    // Prepare email content for user
    $user_body = "
    <h2>Thank you for booking your free IT consultation!</h2>
    <p>Dear $name,</p>
    <p>We've received your request for a free IT consultation with the following details:</p>
    
    <h3>Booking Details</h3>
    <p><strong>Date:</strong> $preferred_date</p>
    <p><strong>Time Slot:</strong> $preferred_time</p>
    
    <h3>Your Concerns</h3>
    <p>$issues</p>
    
    <p>Our IT expert will contact you shortly at $phone to confirm your appointment.</p>
    
    <p>If you need immediate assistance, please call us at <a href='tel:+917703823008'>+91 77038 23008</a></p>
    
    <p>Best regards,<br>IT Sahayata Team</p>
    ";
    
    // Send emails
    $admin_sent = sendEmail($admin_email, $admin_subject, $admin_body);
    $user_sent = false;
    
    if (!empty($email)) {
        $user_sent = sendEmail($email, $user_subject, $user_body);
    }
    
    // Show success message if at least admin email was sent
    if ($admin_sent) {
        echo '
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-4">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                        <h3 class="modal-title mb-3" id="successModalLabel">Booking Confirmed!</h3>
                        <p class="mb-4">Your free IT consultation has been successfully scheduled.</p>';
        
        if ($user_sent) {
            echo '<p class="text-success"><i class="fas fa-envelope me-2"></i> A confirmation has been sent to your email address.</p>';
        } else {
            echo '<p class="text-muted"><i class="fas fa-info-circle me-2"></i> Please note your appointment details.</p>';
        }
        
        echo '
                        <div class="booking-details bg-light p-3 rounded-3 mt-4 text-start">
                            <p class="mb-2"><strong>Name:</strong> '.htmlspecialchars($name).'</p>
                            <p class="mb-2"><strong>Date:</strong> '.htmlspecialchars($preferred_date).'</p>
                            <p class="mb-0"><strong>Time:</strong> '.htmlspecialchars($preferred_time).'</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById("successModal"));
                successModal.show();
            });
        </script>';
    } else {
        // Show error message if email failed
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> There was an error processing your request. Please try again or call us directly.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>

<!-- Consultation Hero Section -->
<section class="consultation-hero py-5 position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Get <span class="text-gradient">Free IT Consultation</span> From Our Experts</h1>
                <p class="lead mb-4">Struggling with tech issues? Our certified IT specialists will analyze your setup and recommend the best solutions - completely free!</p>
                
                <div class="benefits-list mb-5">
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>No obligation - 100% free advice</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>30-minute detailed analysis</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Personalized recommendations</span>
                    </div>
                </div>
                
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="#consultation-form" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-calendar-check me-2"></i> Book Free Session
                    </a>
                    <a href="tel:+917703823008" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fas fa-phone-alt me-2"></i> Call Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="consultation-illustration p-4 p-lg-5">
                    <img src="/assets/free-consult.png" alt="IT Consultation" class="img-fluid">
                    <div class="floating-badge bg-success text-white">
                        <i class="fas fa-headset me-2"></i> Expert Advice
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="process-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">How Our <span class="text-gradient">Free Consultation</span> Works</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">Simple steps to get professional IT advice for your business or home setup</p>
        </div>

        <div class="process-steps row g-4 justify-content-center">
            <!-- Step 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="step-card h-100 text-center p-4">
                    <div class="step-number">1</div>
                    <div class="step-icon mx-auto mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="h5 mb-3">Book Your Slot</h3>
                    <p>Fill our simple form to schedule a convenient time for your consultation</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card h-100 text-center p-4">
                    <div class="step-number">2</div>
                    <div class="step-icon mx-auto mb-4">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="h5 mb-3">Initial Discussion</h3>
                    <p>Our expert will call you to understand your IT challenges and requirements</p>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card h-100 text-center p-4">
                    <div class="step-number">3</div>
                    <div class="step-icon mx-auto mb-4">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="h5 mb-3">Technical Analysis</h3>
                    <p>We'll analyze your current setup (remotely or on-site as needed)</p>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card h-100 text-center p-4">
                    <div class="step-number">4</div>
                    <div class="step-icon mx-auto mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="h5 mb-3">Get Solutions</h3>
                    <p>Receive customized recommendations to solve your IT problems</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Consultation Form Section -->
<section id="consultation-form" class="consultation-form py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card bg-white p-4 p-lg-5 rounded-4 shadow-sm" data-aos="fade-up">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold mb-3">Schedule Your <span class="text-gradient">Free Consultation</span></h2>
                        <p class="text-muted">Fill this form and our IT expert will contact you within 2 hours</p>
                    </div>
                    
                    <form id="freeConsultationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>#consultation-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Your Name*</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Mobile Number*</label>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="business" class="form-label">Business Name</label>
                                <input type="text" class="form-control form-control-lg" id="business" name="business">
                            </div>
                            <div class="col-12">
                                <label for="issues" class="form-label">Describe Your IT Issues*</label>
                                <textarea class="form-control form-control-lg" id="issues" name="issues" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="preferred-date" class="form-label">Preferred Date*</label>
                                <input type="date" class="form-control form-control-lg" id="preferred-date" name="preferred-date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="preferred-time" class="form-label">Preferred Time*</label>
                                <select class="form-select form-select-lg" id="preferred-time" name="preferred-time" required>
                                    <option value="">Select Time Slot</option>
                                    <option value="9am-12pm">Morning (9AM - 12PM)</option>
                                    <option value="12pm-3pm">Afternoon (12PM - 3PM)</option>
                                    <option value="3pm-6pm">Evening (3PM - 6PM)</option>
                                    <option value="6pm-9pm">Night (6PM - 9PM)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree-terms" name="agree-terms" required>
                                    <label class="form-check-label small" for="agree-terms">
                                        I agree to IT Sahayata's <a href="/privacy">Privacy Policy</a> and <a href="/terms">Terms of Service</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                    <i class="fas fa-paper-plane me-2"></i> Book Free Consultation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Why Choose Us Section -->
<section class="why-choose-us py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Why Choose <span class="text-gradient">IT Sahayata</span> For IT Consultation</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px">What makes our free consultation service different from others</p>
        </div>

        <div class="row g-4">
            <!-- Reason 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="reason-card h-100 bg-white p-4 rounded-3 shadow-sm">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="h5 mb-3">Certified Experts</h3>
                    <p class="small">Our consultants hold Microsoft, Cisco, and CompTIA certifications with 5+ years experience</p>
                </div>
            </div>
            
            <!-- Reason 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="reason-card h-100 bg-white p-4 rounded-3 shadow-sm">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h3 class="h5 mb-3">No Hidden Costs</h3>
                    <p class="small">Genuinely free consultation with transparent pricing for any follow-up services</p>
                </div>
            </div>
            
            <!-- Reason 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="reason-card h-100 bg-white p-4 rounded-3 shadow-sm">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="h5 mb-3">Quick Response</h3>
                    <p class="small">Average response time of 30 minutes for urgent IT issues</p>
                </div>
            </div>
            
            <!-- Reason 4 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="reason-card h-100 bg-white p-4 rounded-3 shadow-sm">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="h5 mb-3">Data Security</h3>
                    <p class="small">100% confidential consultation with enterprise-grade data protection</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-3">Consultation <span class="text-gradient">FAQs</span></h2>
                    <p class="lead text-muted mx-auto" style="max-width: 700px">Common questions about our free IT consultation service</p>
                </div>

                <div class="accordion" id="consultationFAQ" data-aos="fade-up">
                    <!-- FAQ 1 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button collapsed px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                                Is the consultation really free with no hidden charges?
                            </button>
                        </h3>
                        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1">
                            <div class="accordion-body px-4 pb-3 pt-0">
                                Yes, absolutely! Our initial 30-minute consultation is completely free with no obligation. We'll provide honest advice about your IT issues and only recommend paid services if they're truly needed to solve your problems.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                                What information do I need to prepare for the consultation?
                            </button>
                        </h3>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2">
                            <div class="accordion-body px-4 pb-3 pt-0">
                                Please have details about your current IT setup ready, including: devices you use, software versions, specific error messages you're seeing, and when the problems started. This helps us provide more accurate advice during our limited consultation time.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                                Can you help with both business and personal IT issues?
                            </button>
                        </h3>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3">
                            <div class="accordion-body px-4 pb-3 pt-0">
                                Yes! Our IT experts can assist with both business technology challenges (like network setup, software deployment) and personal tech issues (like home computer repair, data recovery). The free consultation applies to both.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                                What if I need immediate help outside business hours?
                            </button>
                        </h3>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4">
                            <div class="accordion-body px-4 pb-3 pt-0">
                                We offer 24/7 emergency IT support for critical issues (additional charges may apply). For urgent matters outside our free consultation hours, please call our emergency line at <a href="tel:+917703823008">+91 77038 23008</a>.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5" data-aos="fade-up">
                    <p class="mb-4">Still have questions? Contact us directly:</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="tel:+917703823008" class="btn btn-outline-primary px-4">
                            <i class="fas fa-phone-alt me-2"></i> Call Now
                        </a>
                        <a href="mailto:info@itsahayata.com" class="btn btn-outline-primary px-4">
                            <i class="fas fa-envelope me-2"></i> Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Consultation Page Styles */
    .consultation-hero {
        background: linear-gradient(135deg, #f0f7ff 0%, #e1effe 100%);
        padding: 100px 0;
    }
    
    .text-gradient {
        background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .benefits-list {
        margin: 2rem 0;
    }
    
    .benefit-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .benefit-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .consultation-illustration {
        position: relative;
        /* background: white; */
        border-radius: 20px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .floating-badge {
        position: absolute;
        top: -15px;
        right: -15px;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        animation: float 3s ease-in-out infinite;
    }
    
    /* Process Steps */
    .step-card {
        background: white;
        border-radius: 12px;
        transition: all 0.3s ease;
        border-top: 4px solid #2563eb;
    }
    
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        background: #2563eb;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 0 auto 15px;
    }
    
    .step-icon {
        width: 60px;
        height: 60px;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    /* Consultation Form */
    .form-card {
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .form-control, .form-select {
        padding: 12px 15px;
        border-radius: 8px;
    }
    
    /* Why Choose Us */
    .reason-card {
        transition: all 0.3s ease;
    }
    
    .reason-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .reason-icon {
        width: 50px;
        height: 50px;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    /* FAQ */
    .accordion-button {
        font-weight: 600;
        background: white;
    }
    
    .accordion-button:not(.collapsed) {
        color: #2563eb;
        background: rgba(37, 99, 235, 0.05);
    }
    
    /* Animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    @media (max-width: 768px) {
        .consultation-hero {
            padding: 60px 0;
        }
        
        .display-4 {
            font-size: 2.2rem;
        }
    }
</style>

<!-- Add this CSS to your existing styles -->
<style>
    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }
    
    .icon-box {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .booking-details {
        background: rgba(37, 99, 235, 0.05);
        border-left: 3px solid #2563eb;
    }
    
    /* Form Validation */
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>

<!-- Add this JavaScript before closing body tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('freeConsultationForm');
    
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Clear previous validation
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'This field is required';
                field.parentNode.appendChild(errorDiv);
            }
        });
        
        // Validate email format if provided
        const emailField = document.getElementById('email');
        if (emailField.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('is-invalid');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = 'Please enter a valid email address';
            emailField.parentNode.appendChild(errorDiv);
        }
        
        // Validate phone number
        const phoneField = document.getElementById('phone');
        if (phoneField.value && !/^[0-9]{10,15}$/.test(phoneField.value)) {
            isValid = false;
            phoneField.classList.add('is-invalid');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = 'Please enter a valid phone number';
            phoneField.parentNode.appendChild(errorDiv);
        }
        
        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });
    
    // Set minimum date for date picker (today)
    const dateField = document.getElementById('preferred-date');
    if (dateField) {
        const today = new Date().toISOString().split('T')[0];
        dateField.min = today;
    }
});
</script>


<?php include 'footer.php'; ?>