<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayta - FAQs | Get Answers to Your IT Support Questions</title>
    <meta name="description" content="Find answers to frequently asked questions about IT Sahayta's support services. Learn about our offerings, service areas, response times, and more.">
    <?php include "assets.php"?>
  
</head>
<body>



    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-faq text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">Frequently Asked Questions</h1>
            <p class="lead fs-4 animate__animated animate__fadeInUp animate__delay-1s">Find answers to common questions about our IT support services</p>
            
            <div class="search-box mt-5 animate__animated animate__fadeInUp animate__delay-2s">
                <form action="" method="GET">
                    <input type="text" class="form-control" placeholder="Search our knowledge base..." name="search">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section py-5 bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="sticky-top" style="top: 100px;">
                        <div class="faq-category floating">
                            <i class="fas fa-question-circle fs-1 mb-3"></i>
                            <h3>Need Help?</h3>
                            <p>Browse our frequently asked questions or contact our support team for assistance.</p>
                            <a href="#contact" class="btn btn-light mt-3">Contact Support</a>
                        </div>
                        
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter by Category</h5>
                                <div class="list-group list-group-flush">
                                    <a href="#general" class="list-group-item list-group-item-action">General Questions</a>
                                    <a href="#technical" class="list-group-item list-group-item-action">Technical Support</a>
                                    <a href="#billing" class="list-group-item list-group-item-action">Billing & Payments</a>
                                    <a href="#services" class="list-group-item list-group-item-action">Our Services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <!-- General Questions -->
                    <div id="general" class="mb-5">
                        <h2 class="mb-4 fw-bold d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-3"></i> General Questions
                        </h2>
                        
                        <div class="accordion" id="generalAccordion">
                            <div class="faq-card">
                                <div class="faq-header" id="generalHeading1" data-bs-toggle="collapse" data-bs-target="#generalCollapse1">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What is IT Sahayata and what services do you provide?
                                    </h5>
                                </div>
                                <div id="generalCollapse1" class="collapse show" aria-labelledby="generalHeading1" data-bs-parent="#generalAccordion">
                                    <div class="faq-body">
                                        <p>IT Sahayata is a professional IT support company providing comprehensive technology solutions for businesses and individuals. Our services include:</p>
                                        <ul>
                                            <li>Hardware diagnostics and repair</li>
                                            <li>Software installation and troubleshooting</li>
                                            <li>Network setup and security</li>
                                            <li>Data recovery and backup solutions</li>
                                            <li>24/7 remote and on-site support</li>
                                            <li>Cybersecurity services</li>
                                        </ul>
                                        <p>We serve clients across various industries with customized IT solutions.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="generalHeading2" data-bs-toggle="collapse" data-bs-target="#generalCollapse2">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What areas do you serve?
                                    </h5>
                                </div>
                                <div id="generalCollapse2" class="collapse" aria-labelledby="generalHeading2" data-bs-parent="#generalAccordion">
                                    <div class="faq-body">
                                        <p>We primarily serve Delhi-NCR and Lucknow with on-site support, but provide remote support services nationwide. Our team has successfully supported clients across India, including during major events like the G20 Summit.</p>
                                        <p>For on-site services, we cover all areas within Delhi, Noida, Gurugram, Ghaziabad, and Lucknow. Remote support is available for clients anywhere in India.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="generalHeading3" data-bs-toggle="collapse" data-bs-target="#generalCollapse3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> How quickly can you respond to support requests?
                                    </h5>
                                </div>
                                <div id="generalCollapse3" class="collapse" aria-labelledby="generalHeading3" data-bs-parent="#generalAccordion">
                                    <div class="faq-body">
                                        <p>Our average response times are:</p>
                                        <ul>
                                            <li><strong>Critical issues</strong>: Under 30 minutes</li>
                                            <li><strong>High priority</strong>: Within 1 hour</li>
                                            <li><strong>Standard requests</strong>: Within 4 hours</li>
                                        </ul>
                                        <p>We offer 24/7 support for critical business systems. During the G20 Summit, we maintained an average response time of just 15 minutes for all requests.</p>
                                        <p>Response times may vary slightly based on your service plan and current workload.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="generalHeading4" data-bs-toggle="collapse" data-bs-target="#generalCollapse4">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Are your technicians certified?
                                    </h5>
                                </div>
                                <div id="generalCollapse4" class="collapse" aria-labelledby="generalHeading4" data-bs-parent="#generalAccordion">
                                    <div class="faq-body">
                                        <p>Yes, all our technicians hold industry-recognized certifications. Our team includes:</p>
                                        <ul>
                                            <li>Microsoft Certified Professionals (MCP, MCSE)</li>
                                            <li>Cisco Certified Network Associates (CCNA)</li>
                                            <li>CompTIA A+ and Network+ certified technicians</li>
                                            <li>Certified Ethical Hackers (CEH)</li>
                                            <li>Dell, HP, and Lenovo certified hardware specialists</li>
                                        </ul>
                                        <p>We invest heavily in continuous training to ensure our team stays current with the latest technologies and best practices.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Technical Support -->
                    <div id="technical" class="mb-5">
                        <h2 class="mb-4 fw-bold d-flex align-items-center">
                            <i class="fas fa-laptop-code text-primary me-3"></i> Technical Support
                        </h2>
                        
                        <div class="accordion" id="technicalAccordion">
                            <div class="faq-card">
                                <div class="faq-header" id="technicalHeading1" data-bs-toggle="collapse" data-bs-target="#technicalCollapse1">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What types of technical issues can you help with?
                                    </h5>
                                </div>
                                <div id="technicalCollapse1" class="collapse show" aria-labelledby="technicalHeading1" data-bs-parent="#technicalAccordion">
                                    <div class="faq-body">
                                        <p>We can assist with virtually any IT-related issue, including:</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul>
                                                    <li>Hardware malfunctions and repairs</li>
                                                    <li>Software installation and configuration</li>
                                                    <li>Virus and malware removal</li>
                                                    <li>Network setup and troubleshooting</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul>
                                                    <li>Data backup and recovery</li>
                                                    <li>Email and server issues</li>
                                                    <li>Cloud services setup</li>
                                                    <li>Cybersecurity protection</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p>If you're unsure whether we can help with your specific issue, please contact us - we likely can!</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="technicalHeading2" data-bs-toggle="collapse" data-bs-target="#technicalCollapse2">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Do you provide remote support?
                                    </h5>
                                </div>
                                <div id="technicalCollapse2" class="collapse" aria-labelledby="technicalHeading2" data-bs-parent="#technicalAccordion">
                                    <div class="faq-body">
                                        <p>Yes, we offer secure remote support for most software-related issues. Our remote support features:</p>
                                        <ul>
                                            <li>Secure, encrypted connections</li>
                                            <li>Screen sharing with your permission</li>
                                            <li>File transfer capabilities</li>
                                            <li>Multi-platform support (Windows, macOS, Linux)</li>
                                        </ul>
                                        <p>Remote support is typically faster and more cost-effective than on-site visits for software issues. We can usually resolve most remote-supportable issues within 30-60 minutes.</p>
                                        <p>For hardware issues or complex network problems, we recommend on-site support.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="technicalHeading3" data-bs-toggle="collapse" data-bs-target="#technicalCollapse3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> How do I prepare for a technician visit?
                                    </h5>
                                </div>
                                <div id="technicalCollapse3" class="collapse" aria-labelledby="technicalHeading3" data-bs-parent="#technicalAccordion">
                                    <div class="faq-body">
                                        <p>To ensure the most efficient service, please:</p>
                                        <ol>
                                            <li>Have all relevant error messages or symptoms written down</li>
                                            <li>Gather any warranty information for your equipment</li>
                                            <li>Back up important data if possible</li>
                                            <li>Have administrator passwords available</li>
                                            <li>Ensure the work area is accessible and well-lit</li>
                                            <li>Have all peripherals (power cords, etc.) available</li>
                                        </ol>
                                        <p>For business clients, it's helpful to have a primary contact person available during the service visit.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="technicalHeading4" data-bs-toggle="collapse" data-bs-target="#technicalCollapse4">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Can you help with data recovery?
                                    </h5>
                                </div>
                                <div id="technicalCollapse4" class="collapse" aria-labelledby="technicalHeading4" data-bs-parent="#technicalAccordion">
                                    <div class="faq-body">
                                        <p>Yes, we offer professional data recovery services with a high success rate. Our capabilities include:</p>
                                        <ul>
                                            <li>Hard drive failures (mechanical and logical)</li>
                                            <li>Accidentally deleted files</li>
                                            <li>Formatted drives</li>
                                            <li>Corrupted storage devices</li>
                                            <li>RAID array failures</li>
                                        </ul>
                                        <p><strong>Important:</strong> If you suspect data loss, stop using the device immediately to prevent overwriting data. Our success rate is highest when we can work on the original media as soon as possible.</p>
                                        <p>We operate a Class 100 clean room for physical recoveries and use industry-leading tools like R-Studio and PC-3000.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Billing & Payments -->
                    <div id="billing" class="mb-5">
                        <h2 class="mb-4 fw-bold d-flex align-items-center">
                            <i class="fas fa-rupee-sign text-primary me-3"></i> Billing & Payments
                        </h2>
                        
                        <div class="accordion" id="billingAccordion">
                            <div class="faq-card">
                                <div class="faq-header" id="billingHeading1" data-bs-toggle="collapse" data-bs-target="#billingCollapse1">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What are your payment options?
                                    </h5>
                                </div>
                                <div id="billingCollapse1" class="collapse show" aria-labelledby="billingHeading1" data-bs-parent="#billingAccordion">
                                    <div class="faq-body">
                                        <p>We accept various payment methods for your convenience:</p>
                                        <ul>
                                            <li>Credit/Debit Cards (Visa, MasterCard, American Express, Rupay)</li>
                                            <li>Net Banking</li>
                                            <li>UPI Payments (PhonePe, Google Pay, Paytm, etc.)</li>
                                            <li>Bank Transfers (NEFT/IMPS/RTGS)</li>
                                            <li>Cash (for on-site services only)</li>
                                            <li>Cheque (subject to clearance)</li>
                                        </ul>
                                        <p>Corporate clients can also set up monthly invoicing with 15-day payment terms.</p>
                                        <p>All payments are secure and encrypted. We provide detailed receipts for all transactions.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="billingHeading2" data-bs-toggle="collapse" data-bs-target="#billingCollapse2">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Do you offer any service packages or subscriptions?
                                    </h5>
                                </div>
                                <div id="billingCollapse2" class="collapse" aria-labelledby="billingHeading2" data-bs-parent="#billingAccordion">
                                    <div class="faq-body">
                                        <p>Yes, we offer several cost-effective service plans:</p>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Plan</th>
                                                        <th>Features</th>
                                                        <th>Best For</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Basic Care</strong><br>₹1,999/month</td>
                                                        <td>5 support hours, remote only, business hours</td>
                                                        <td>Individuals & small offices</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Professional</strong><br>₹4,999/month</td>
                                                        <td>Unlimited remote, 2 on-site visits, 24/7 support</td>
                                                        <td>Small businesses</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Enterprise</strong><br>₹9,999/month</td>
                                                        <td>Unlimited remote & on-site, priority response, dedicated technician</td>
                                                        <td>Medium businesses</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Custom</strong></td>
                                                        <td>Tailored solutions for your specific needs</td>
                                                        <td>Large organizations</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <p>All plans include antivirus protection and quarterly system reviews. Discounts are available for annual prepayment.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="billingHeading3" data-bs-toggle="collapse" data-bs-target="#billingCollapse3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What is your refund policy?
                                    </h5>
                                </div>
                                <div id="billingCollapse3" class="collapse" aria-labelledby="billingHeading3" data-bs-parent="#billingAccordion">
                                    <div class="faq-body">
                                        <p>Our refund policy is designed to be fair to both parties:</p>
                                        <ul>
                                            <li><strong>Service Fees</strong>: Refundable if we're unable to resolve your issue after reasonable effort (determined case by case)</li>
                                            <li><strong>Parts/Equipment</strong>: Refundable if unopened/unused within 30 days (restocking fee may apply)</li>
                                            <li><strong>Subscription Plans</strong>: Prorated refund for unused months if canceled within 30 days</li>
                                            <li><strong>Diagnostic Fees</strong>: Non-refundable as they cover technician time</li>
                                        </ul>
                                        <p>To request a refund, please contact our billing department with your service details. Refunds are typically processed within 7-10 business days.</p>
                                        <p>Note: No refunds are provided for services already rendered or issues caused by client negligence.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Our Services -->
                    <div id="services" class="mb-5">
                        <h2 class="mb-4 fw-bold d-flex align-items-center">
                            <i class="fas fa-concierge-bell text-primary me-3"></i> Our Services
                        </h2>
                        
                        <div class="accordion" id="servicesAccordion">
                            <div class="faq-card">
                                <div class="faq-header" id="servicesHeading1" data-bs-toggle="collapse" data-bs-target="#servicesCollapse1">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> What makes IT Sahayata different from other IT support providers?
                                    </h5>
                                </div>
                                <div id="servicesCollapse1" class="collapse show" aria-labelledby="servicesHeading1" data-bs-parent="#servicesAccordion">
                                    <div class="faq-body">
                                        <p>Several key factors set us apart:</p>
                                        <ol>
                                            <li><strong>G20 Proven Expertise</strong>: Our selection as official IT support for the G20 Summit demonstrates our capability to handle mission-critical systems</li>
                                            <li><strong>Certified Technicians</strong>: Unlike many providers who use junior staff, all our technicians are certified professionals</li>
                                            <li><strong>Transparent Pricing</strong>: No hidden fees - you'll know costs upfront</li>
                                            <li><strong>Preventive Approach</strong>: We don't just fix problems - we help prevent them</li>
                                            <li><strong>Business Understanding</strong>: We take time to understand your specific business needs</li>
                                            <li><strong>Local Presence</strong>: With offices in Delhi and Lucknow, we're never far away</li>
                                        </ol>
                                        <p>Our 98% customer satisfaction rate speaks to our commitment to excellence.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="servicesHeading2" data-bs-toggle="collapse" data-bs-target="#servicesCollapse2">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Do you provide services for both businesses and individuals?
                                    </h5>
                                </div>
                                <div id="servicesCollapse2" class="collapse" aria-labelledby="servicesHeading2" data-bs-parent="#servicesAccordion">
                                    <div class="faq-body">
                                        <p>Yes, we serve both business and residential clients with tailored solutions:</p>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-3 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-primary"><i class="fas fa-building me-2"></i> Business Services</h5>
                                                        <ul>
                                                            <li>Managed IT services</li>
                                                            <li>Network infrastructure</li>
                                                            <li>Business continuity planning</li>
                                                            <li>Enterprise security</li>
                                                            <li>Dedicated account managers</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-primary"><i class="fas fa-home me-2"></i> Residential Services</h5>
                                                        <ul>
                                                            <li>Home computer repair</li>
                                                            <li>Wi-Fi setup & optimization</li>
                                                            <li>Smart home integration</li>
                                                            <li>Virus removal</li>
                                                            <li>Data backup solutions</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="mt-3">While our service approach differs based on client type, all customers receive the same high standard of technical expertise and customer service.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-card">
                                <div class="faq-header collapsed" id="servicesHeading3" data-bs-toggle="collapse" data-bs-target="#servicesCollapse3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle"></i> Do you offer emergency support outside business hours?
                                    </h5>
                                </div>
                                <div id="servicesCollapse3" class="collapse" aria-labelledby="servicesHeading3" data-bs-parent="#servicesAccordion">
                                    <div class="faq-body">
                                        <p>Yes, we provide 24/7 emergency support for critical issues. Our emergency services include:</p>
                                        <ul>
                                            <li>24/7 phone support for urgent issues</li>
                                            <li>After-hours technician dispatch (additional fees apply)</li>
                                            <li>Priority response for business-critical systems</li>
                                            <li>Holiday and weekend coverage</li>
                                        </ul>
                                        <p><strong>Emergency Support Fees:</strong></p>
                                        <ul>
                                            <li>Weekdays (8PM-8AM): 1.5x standard rate</li>
                                            <li>Weekends: 2x standard rate</li>
                                            <li>National Holidays: 2.5x standard rate</li>
                                        </ul>
                                        <p>Note: Subscription plan clients may have emergency support included in their package.</p>
                                        <p>During the G20 Summit, our team provided round-the-clock support with 15-minute response times for all critical requests.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-3">Still Have Questions?</span>
                <h2 class="fw-bold mb-3">Contact Our Support Team</h2>
                <p class="lead text-muted">We're here to help you with any IT challenges</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4 class="mb-3">Call Us</h4>
                        <p>Speak directly with our support team</p>
                        <a href="tel:+917703823008" class="btn btn-primary mt-3">
                            <i class="fas fa-phone me-2"></i> +91 77038 23008
                        </a>
                        <p class="mt-2 text-muted small">24/7 emergency support available</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="mb-3">Email Us</h4>
                        <p>Get support via email with detailed responses</p>
                        <a href="mailto:support@itsahayata.com" class="btn btn-primary mt-3">
                            <i class="fas fa-envelope me-2"></i> support@itsahayata.com
                        </a>
                        <p class="mt-2 text-muted small">Typically responds within 2 hours</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <h4 class="mb-3">Live Chat</h4>
                        <p>Instant messaging with our support agents</p>
                        <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#chatModal">
                            <i class="fas fa-comment me-2"></i> Start Live Chat
                        </a>
                        <p class="mt-2 text-muted small">Available 8AM-10PM daily</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
            background-color: #f8f9fa;
        }
        h1, h2, h3, h4 {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Hero Section */
        .hero-faq {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.9) 0%, rgba(69 81 118 / 85%) 100%), 
                        url('https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80');
            background-size: cover;
            background-position: center;
            padding: 120px 0 80px;
            color: white;
            position: relative;
        }
        .hero-faq::before {
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
        .search-box {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        .search-box input {
            padding: 15px 20px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            border-radius: 50px;
            padding: 10px 20px;
        }
        
        /* FAQ Section */
        .faq-section {
            position: relative;
        }
        .faq-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .faq-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .faq-header {
            background-color: white;
            padding: 20px;
            cursor: pointer;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .faq-header.collapsed {
            border-bottom: none;
        }
        .faq-header h5 {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .faq-header h5 i {
            margin-right: 15px;
            color: var(--primary);
            font-size: 20px;
        }
        .faq-body {
            padding: 20px;
            background-color: #f8f9fc;
        }
        .faq-category {
            background: var(--gradient);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.2);
        }
        .faq-category h3 {
            margin-bottom: 15px;
        }
        .faq-category p {
            opacity: 0.9;
        }
        
        /* Contact Card */
        .contact-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            transition: all 0.3s;
            height: 100%;
        }
        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .contact-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient);
            color: white;
            font-size: 30px;
            border-radius: 50%;
        }
        
        /* Floating Animation */
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="chatModalLabel">Live Chat Support</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="chat-container" style="height: 300px; overflow-y: auto; margin-bottom: 20px; border: 1px solid #eee; padding: 15px; border-radius: 5px;">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comment-dots fa-3x mb-3"></i>
                            <p>Connecting you to a support agent...</p>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type your message...">
                        <button class="btn btn-primary" type="button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
        
        // Smooth scroll for FAQ links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Search functionality
        $(document).ready(function(){
            $('form').submit(function(e){
                e.preventDefault();
                var searchTerm = $('input[name="search"]').val().toLowerCase();
                if(searchTerm.length < 3) {
                    alert('Please enter at least 3 characters to search');
                    return;
                }
                
                $('.faq-card').hide();
                $('.faq-header h5').each(function(){
                    if($(this).text().toLowerCase().indexOf(searchTerm) > -1) {
                        $(this).closest('.faq-card').show();
                    }
                });
                
                if($('.faq-card:visible').length === 0) {
                    alert('No questions found matching your search. Please try different keywords.');
                    $('.faq-card').show();
                } else {
                    $('html, body').animate({
                        scrollTop: $('.faq-card:visible').first().offset().top - 100
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>