<?php
// pricing.php


// Calculate annual prices with discount
$plans = [
    'basic' => [
        'monthly' => 1999,
        'annual' => round(1999 * 12 * 0.8), // 20% discount
        'name' => 'Basic Care',
        'best_for' => 'Startups & Small Offices',
        'features' => [
            '5 remote support hours/month',
            'Business hours support (9AM-6PM)',
            'Email ticketing system',
            'Basic antivirus protection',
            '4-hour response time',
            'Monthly system report'
        ],
        'limits' => [
            'No on-site support',
            'No after-hours coverage',
            'Standard security'
        ]
    ],
    'professional' => [
        'monthly' => 4999,
        'annual' => round(4999 * 12 * 0.8), // 20% discount
        'name' => 'Professional',
        'best_for' => 'Growing Businesses',
        'popular' => true,
        'features' => [
            'Unlimited remote support',
            '2 on-site visits/month',
            '24/7 emergency support',
            'Advanced security suite',
            '1-hour response time',
            'Weekly system monitoring',
            'Phone & email support'
        ],
        'limits' => [
            'Limited on-site visits',
            'Shared technician pool',
            'No dedicated account manager'
        ]
    ],
    'enterprise' => [
        'monthly' => 9999,
        'annual' => round(9999 * 12 * 0.8), // 20% discount
        'name' => 'Enterprise',
        'best_for' => 'Large Organizations',
        'features' => [
            'Unlimited remote & on-site',
            '24/7 priority response',
            'Dedicated senior technician',
            'Enterprise-grade security',
            '30-minute response time',
            'G20-grade protocols',
            'Daily system monitoring',
            'Custom SLA agreements'
        ],
        'limits' => [
            'Annual contract required',
            'Minimum 50 devices'
        ]
    ]
];

// Determine billing cycle (default to monthly)
$billing_cycle = isset($_GET['cycle']) && $_GET['cycle'] === 'annual' ? 'annual' : 'monthly';

// Set dynamic meta tags for SEO
$page_title = "Pricing Plans | IT Sahayata - Professional IT Support Services";
$meta_description = "Transparent pricing for enterprise-grade IT support services. Choose from Basic, Professional, or Enterprise plans to fit your business needs and budget.";
$meta_keywords = "IT support pricing, managed IT services cost, computer support plans, IT helpdesk pricing, business IT support packages";

?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $meta_description; ?>">
    <meta property="og:url" content="https://www.itsahayata.com/pricing.php">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoY9Fur2aPs8G1CkzSAxH24mu6ztk2GyNfZB9c5I4Ck2fXr" crossorigin="anonymous">

    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #2e59d9;
            --secondary: rgb(52, 109, 232);;
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
        .hero-pricing {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.9) 0%, rgba(60, 60, 129, 0.9) 100%), 
                        url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            padding: 120px 0 80px;
            color: white;
            position: relative;
        }
        .hero-pricing::before {
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
        .billing-toggle {
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 5px;
            display: inline-flex;
        }
        .billing-toggle .btn {
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .billing-toggle .btn-check:checked + .btn {
            background: white;
            color: var(--primary);
        }
        
        /* Pricing Cards */
        .pricing-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s;
            overflow: hidden;
            margin-bottom: 30px;
            background: white;
            height: 100%;
        }
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .pricing-card.highlighted {
            border: 2px solid var(--primary);
        }
        .pricing-header {
            padding: 30px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }
        .pricing-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .pricing-best-for {
            font-size: 14px;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
        }
        .pricing-price {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary);
        }
        .pricing-period {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 15px;
        }
        .pricing-savings {
            font-size: 14px;
            color: var(--secondary);
            font-weight: 600;
        }
        .pricing-popular {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gradient);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }
        .pricing-body {
            padding: 30px;
        }
        .features-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
        }
        .features-title i {
            margin-right: 10px;
            color: var(--primary);
        }
        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 25px;
        }
        .pricing-features li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        .pricing-features li i {
            margin-right: 10px;
            color: var(--secondary);
            font-size: 14px;
        }
        .pricing-limitations {
            list-style: none;
            padding: 0;
            margin: 0 0 30px;
            background: rgba(220, 53, 69, 0.05);
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid rgba(220, 53, 69, 0.3);
        }
        .pricing-limitations li {
            padding: 5px 0;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #6c757d;
        }
        .pricing-limitations li i {
            margin-right: 10px;
            color: #dc3545;
            font-size: 12px;
        }
        .pricing-btn {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        /* Plan Comparison */
        .comparison-section {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 5px;
            margin: 50px 0;
        }
        .comparison-nav {
            display: flex;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .comparison-nav button {
            flex: 1;
            padding: 15px;
            border: none;
            background: none;
            font-weight: 600;
            color: #6c757d;
            position: relative;
            cursor: pointer;
        }
        .comparison-nav button.active {
            color: var(--primary);
        }
        .comparison-nav button.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient);
        }
        .comparison-table {
            background: white;
            border-radius: 0 0 15px 15px;
            overflow: hidden;
        }
        .comparison-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .comparison-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            vertical-align: middle;
        }
        .comparison-table tr:last-child td {
            border-bottom: none;
        }
        .feature-name {
            font-weight: 600;
            width: 30%;
        }
        .feature-value {
            text-align: center;
        }
        .feature-value i {
            font-size: 18px;
        }
        .fa-check {
            color: var(--secondary);
        }
        .fa-times {
            color: #dc3545;
        }
        .fa-minus {
            color: #6c757d;
        }
        
        /* Enterprise Solution */
        .enterprise-section {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.03) 0%, rgba(28, 200, 138, 0.03) 100%);
            border: 1px dashed var(--primary);
            border-radius: 15px;
            padding: 50px;
            margin: 50px 0;
            text-align: center;
        }
        
        /* FAQ Section */
        .faq-accordion .card {
            border: none;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .faq-accordion .card-header {
            background: white;
            border-bottom: none;
            padding: 20px;
            cursor: pointer;
        }
        .faq-accordion .card-header h5 {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .faq-accordion .card-header h5 i {
            margin-right: 15px;
            color: var(--primary);
            transition: all 0.3s;
        }
        .faq-accordion .card-header.collapsed h5 i {
            transform: rotate(0deg);
        }
        .faq-accordion .card-header h5 i {
            transform: rotate(90deg);
        }
        .faq-accordion .card-body {
            padding: 20px;
            background: #f8f9fc;
        }
        
        /* Business Size Helper */
        .business-size-helper {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .size-option {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .size-option:hover {
            border-color: var(--primary);
        }
        .size-option.active {
            background: rgba(78, 115, 223, 0.05);
            border-color: var(--primary);
        }
        .size-option h5 {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        .size-option h5 i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 767.98px) {
            .pricing-price {
                font-size: 36px;
            }
            .enterprise-section {
                padding: 30px 15px;
            }
            .billing-toggle {
                flex-direction: column;
            }
            .billing-toggle .btn {
                width: 100%;
                margin: 5px 0;
            }
            .comparison-nav {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    

    <!-- Hero Section -->
    <section class="hero-pricing text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">Transparent Pricing Plans</h1>
            <p class="lead fs-4 animate__animated animate__fadeInUp animate__delay-1s">Enterprise-grade IT support at competitive prices</p>
            
            <div class="mt-5 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="billing-toggle">
                    <input type="radio" class="btn-check" name="billing" id="monthly" autocomplete="off" <?= $billing_cycle === 'monthly' ? 'checked' : '' ?>>
                    <label class="btn" for="monthly" onclick="window.location.href='pricing.php?cycle=monthly'">Monthly Billing</label>
                    
                    <input type="radio" class="btn-check" name="billing" id="annual" autocomplete="off" <?= $billing_cycle === 'annual' ? 'checked' : '' ?>>
                    <label class="btn" for="annual" onclick="window.location.href='pricing.php?cycle=annual'">Annual Billing (Save 20%)</label>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Size Helper -->
    <section class="py-5 bg-light" id="pricing-cards">
        <div class="container">
            <div class="business-size-helper">
                <h4 class="fw-bold mb-4"><i class="fas fa-question-circle text-primary me-2"></i> Not sure which plan is right for you?</h4>
                <p class="mb-4">Select your business size to see our recommendation:</p>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="size-option" onclick="highlightPlan('basic')">
                            <h5><i class="fas fa-user"></i> Individual/Freelancer</h5>
                            <p class="small mb-0">1-2 devices, basic IT needs</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="size-option active" onclick="highlightPlan('professional')">
                            <h5><i class="fas fa-store"></i> Small Business</h5>
                            <p class="small mb-0">3-20 employees, growing needs</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="size-option" onclick="highlightPlan('enterprise')">
                            <h5><i class="fas fa-building"></i> Medium/Large Business</h5>
                            <p class="small mb-0">20+ employees, complex IT</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php foreach ($plans as $key => $plan): ?>
                <div class="col-lg-4 mb-4">
                    <div class="pricing-card <?= isset($plan['popular']) ? 'popular-card' : '' ?> <?= $key === 'professional' ? 'highlighted' : '' ?>" id="<?= $key ?>-card">
                        <?php if (isset($plan['popular'])): ?>
                        <div class="pricing-popular">MOST POPULAR</div>
                        <?php endif; ?>
                        <div class="pricing-header">
                            <h3 class="pricing-title"><?= $plan['name'] ?></h3>
                            <div class="pricing-best-for">Best for: <?= $plan['best_for'] ?></div>
                            <div class="pricing-price">₹<?= number_format($plan[$billing_cycle]) ?></div>
                            <div class="pricing-period">per <?= $billing_cycle === 'annual' ? 'year' : 'month' ?></div>
                            <?php if ($billing_cycle === 'annual'): ?>
                            <div class="pricing-savings">Save ₹<?= number_format($plan['monthly'] * 12 - $plan['annual']) ?> annually</div>
                            <?php endif; ?>
                        </div>
                        <div class="pricing-body">
                            <div class="features-title"><i class="fas fa-check-circle"></i> Key Features</div>
                            <ul class="pricing-features">
                                <?php foreach ($plan['features'] as $feature): ?>
                                <li><i class="fas fa-check"></i> <?= $feature ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <?php if (!empty($plan['limits'])): ?>
                            <div class="features-title"><i class="fas fa-exclamation-circle"></i> Limitations</div>
                            <ul class="pricing-limitations">
                                <?php foreach ($plan['limits'] as $limit): ?>
                                <li><i class="fas fa-times"></i> <?= $limit ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            
                            <a href="contact.php?plan=<?= $key ?>&cycle=<?= $billing_cycle ?>" class="btn <?= isset($plan['popular']) ? 'btn-primary' : 'btn-outline-primary' ?> pricing-btn">
                                Choose <?= $plan['name'] ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Plan Comparison -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-3">Plan Comparison</span>
                <h2 class="fw-bold mb-3">Detailed Feature Breakdown</h2>
                <p class="lead text-muted">See exactly what's included in each plan</p>
            </div>
            
            <div class="comparison-section">
                <div class="comparison-nav">
                    <button class="active" onclick="showComparison('support')">Support Features</button>
                    <button onclick="showComparison('security')">Security</button>
                    <button onclick="showComparison('response')">Response Times</button>
                </div>
                
                <div class="comparison-table">
                    <table class="table" id="support-comparison">
                        <thead>
                            <tr>
                                <th class="feature-name">Support Features</th>
                                <th class="feature-value">Basic</th>
                                <th class="feature-value">Professional</th>
                                <th class="feature-value">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name">Remote Support</td>
                                <td class="feature-value">5 hours/month</td>
                                <td class="feature-value"><i class="fas fa-check"></i> Unlimited</td>
                                <td class="feature-value"><i class="fas fa-check"></i> Unlimited</td>
                            </tr>
                            <tr>
                                <td class="feature-name">On-site Visits</td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value">2/month</td>
                                <td class="feature-value"><i class="fas fa-check"></i> Unlimited</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Availability</td>
                                <td class="feature-value">Business Hours</td>
                                <td class="feature-value"><i class="fas fa-check"></i> 24/7</td>
                                <td class="feature-value"><i class="fas fa-check"></i> 24/7 Priority</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Support Channels</td>
                                <td class="feature-value">Email</td>
                                <td class="feature-value">Email, Phone</td>
                                <td class="feature-value">Email, Phone, Dedicated</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="table d-none" id="security-comparison">
                        <thead>
                            <tr>
                                <th class="feature-name">Security Features</th>
                                <th class="feature-value">Basic</th>
                                <th class="feature-value">Professional</th>
                                <th class="feature-value">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name">Antivirus</td>
                                <td class="feature-value">Basic</td>
                                <td class="feature-value">Advanced</td>
                                <td class="feature-value">Enterprise</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Firewall Management</td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value"><i class="fas fa-check"></i></td>
                                <td class="feature-value"><i class="fas fa-check"></i></td>
                            </tr>
                            <tr>
                                <td class="feature-name">Vulnerability Scans</td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value">Monthly</td>
                                <td class="feature-value">Weekly</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Security Monitoring</td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value"><i class="fas fa-check"></i></td>
                                <td class="feature-value"><i class="fas fa-check"></i> 24/7</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="table d-none" id="response-comparison">
                        <thead>
                            <tr>
                                <th class="feature-name">Response Times</th>
                                <th class="feature-value">Basic</th>
                                <th class="feature-value">Professional</th>
                                <th class="feature-value">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name">Critical Issues</td>
                                <td class="feature-value">4 hours</td>
                                <td class="feature-value">1 hour</td>
                                <td class="feature-value">30 minutes</td>
                            </tr>
                            <tr>
                                <td class="feature-name">High Priority</td>
                                <td class="feature-value">8 hours</td>
                                <td class="feature-value">4 hours</td>
                                <td class="feature-value">1 hour</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Standard Requests</td>
                                <td class="feature-value">24 hours</td>
                                <td class="feature-value">8 hours</td>
                                <td class="feature-value">4 hours</td>
                            </tr>
                            <tr>
                                <td class="feature-name">G20-grade Response</td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value"><i class="fas fa-times"></i></td>
                                <td class="feature-value"><i class="fas fa-check"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Enterprise Solution -->
    <section class="py-5">
        <div class="container">
            <div class="enterprise-section">
                <i class="fas fa-crown fa-3x text-primary mb-4"></i>
                <h2 class="fw-bold mb-3">Custom Enterprise Solutions</h2>
                <p class="lead mb-4">For organizations with complex IT infrastructure or specialized requirements</p>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <p>Our enterprise solutions leverage the same protocols and expertise that powered our successful G20 Summit support, customized to your organization's specific needs. Includes dedicated account management, custom SLAs, and strategic IT planning.</p>
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-headset text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Dedicated Team</h5>
                                        <p class="mb-0 text-muted">Assigned engineers who know your systems</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-shield-alt text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Enhanced Security</h5>
                                        <p class="mb-0 text-muted">Military-grade protection</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-bolt text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">15-Minute Response</h5>
                                        <p class="mb-0 text-muted">For mission-critical systems</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-chart-line text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Strategic Planning</h5>
                                        <p class="mb-0 text-muted">Quarterly IT roadmap sessions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="contact.php?plan=enterprise" class="btn btn-primary btn-lg mt-4 px-4">Request Enterprise Consultation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
   <!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary mb-3">FAQs</span>
            <h2 class="fw-bold mb-3">Pricing Questions Answered</h2>
            <p class="lead text-muted">Everything you need to know about our plans</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="accordion faq-accordion" id="pricingAccordion">
                    <div class="card mb-3">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-left d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-chevron-right mr-3"></i> What's the difference between monthly and annual billing?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#pricingAccordion">
                            <div class="card-body">
                                <p>With annual billing, you commit to a full year of service and pay upfront, which saves you 20% compared to monthly payments. For example:</p>
                                <ul>
                                    <li><strong>Basic Care</strong>: ₹1,999/month = ₹23,988 annually vs. ₹19,190 with annual billing (save ₹4,798)</li>
                                    <li><strong>Professional</strong>: ₹4,999/month = ₹59,988 annually vs. ₹47,990 with annual billing (save ₹11,998)</li>
                                    <li><strong>Enterprise</strong>: ₹9,999/month = ₹119,988 annually vs. ₹95,990 with annual billing (save ₹23,998)</li>
                                </ul>
                                <p>Annual plans are ideal if you're certain about your IT needs for the coming year and want to maximize savings.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-left d-flex align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-chevron-right mr-3"></i> Can I change plans later if my needs change?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#pricingAccordion">
                            <div class="card-body">
                                <p>Yes, you can upgrade or downgrade your plan at any time:</p>
                                <ul>
                                    <li><strong>Upgrades</strong>: Take effect immediately with a prorated charge for the remainder of your billing cycle</li>
                                    <li><strong>Downgrades</strong>: Take effect at the start of your next billing cycle</li>
                                </ul>
                                <p>If you're on an annual plan and need to downgrade, we'll issue a prorated credit for the unused portion of your plan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="accordion faq-accordion" id="pricingAccordion2">
                    <div class="card mb-3">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-left d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    <i class="fas fa-chevron-right mr-3"></i> Are hardware/software costs included?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-bs-parent="#pricingAccordion2">
                            <div class="card-body">
                                <p>Our plans cover labor and support services only. Hardware, software licenses, and other products are billed separately at cost. However:</p>
                                <ul>
                                    <li>We pass through our vendor discounts (typically 10-30% off retail)</li>
                                    <li>Enterprise plans include strategic procurement planning</li>
                                    <li>All purchases are optional - we'll never charge without approval</li>
                                </ul>
                                <p>For budgeting purposes, most clients spend an additional 20-50% of their support plan cost annually on hardware/software.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-left d-flex align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-chevron-right mr-3"></i> What happens if I exceed my plan limits?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#pricingAccordion2">
                            <div class="card-body">
                                <p>We'll never cut off support if you exceed limits. Here's how it works:</p>
                                <ul>
                                    <li><strong>Basic Care</strong>: Additional remote hours billed at ₹500/hour</li>
                                    <li><strong>Professional</strong>: Additional on-site visits billed at ₹1,500/visit</li>
                                    <li><strong>Enterprise</strong>: No limits to exceed</li>
                                </ul>
                                <p>We'll always notify you before you reach limits and discuss whether upgrading makes sense. 85% of clients stay within their plan limits.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-left d-flex align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fas fa-chevron-right mr-3"></i> How does the G20-grade response work?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#pricingAccordion2">
                            <div class="card-body">
                                <p>Our Enterprise plan's G20-grade response includes:</p>
                                <ol>
                                    <li><strong>Dedicated Senior Technician</strong>: Certified expert assigned to your account</li>
                                    <li><strong>15-Minute Response Guarantee</strong>: For critical issues, same as G20 service level</li>
                                    <li><strong>Proactive Monitoring</strong>: 24/7 system surveillance</li>
                                    <li><strong>Redundant Systems</strong>: Backup technicians on standby</li>
                                    <li><strong>Priority Escalation</strong>: Direct line to management</li>
                                </ol>
                                <p>This tier is designed for organizations where IT downtime could significantly impact operations or revenue.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- CTA Section -->
    <section class="py-5  text-white" style="background-color: rgb(30 95 191) !important;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
                    <p class="lead mb-0">Choose the plan that fits your needs or contact us for a custom solution.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#pricing-cards" class="btn btn-light btn-lg px-4 py-3 me-3">
                        <i class="fas fa-credit-card me-2"></i> Select Plan
                    </a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-headset me-2"></i> Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qI1dDl3iFgkpcr2hIh/m7FYH9qq3+fxrx8k5BvPoYyz2jc/k11B6ab2Jk7cC8iSk" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
        
        // Highlight recommended plan based on business size
        function highlightPlan(plan) {
            $('.size-option').removeClass('active');
            $(event.currentTarget).addClass('active');
            
            $('.pricing-card').removeClass('highlighted');
            $('#' + plan + '-card').addClass('highlighted');
            
            $('html, body').animate({
                scrollTop: $('#' + plan + '-card').offset().top - 100
            }, 500);
        }
        
        // Show different comparison tables
        function showComparison(type) {
            $('.comparison-nav button').removeClass('active');
            $(event.currentTarget).addClass('active');
            
            $('.comparison-table table').addClass('d-none');
            $('#' + type + '-comparison').removeClass('d-none');
        }
        
        // Initialize with professional plan highlighted
        $(document).ready(function() {
            highlightPlan('professional');
            
            // Handle billing cycle toggle
            $('input[name="billing"]').change(function() {
                if ($(this).attr('id') === 'monthly') {
                    window.location.href = 'pricing.php?cycle=monthly';
                } else {
                    window.location.href = 'pricing.php?cycle=annual';
                }
            });
            
            // Initialize accordions
            $('.collapse').collapse();
        });
    </script>
</body>
</html>