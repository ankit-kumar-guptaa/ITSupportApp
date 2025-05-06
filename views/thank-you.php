<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - Thank You | We Appreciate Your Feedback</title>
    <meta name="description" content="Thank you for reaching out to IT Sahayata. We value your feedback and will respond promptly to your inquiry.">
    <?php include "assets.php"?>
  
</head>
<body>



<?php include 'header.php'; ?>

<!-- Thank You Section -->
<section class="thank-you-section">
    <div class="thank-you-container">
        <div class="thank-you-card" data-aos="fade-up">
            <div class="thank-you-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="thank-you-title">Thank You!</h1>
            <p class="thank-you-message">
                We’ve received your message and will get back to you as soon as possible. We appreciate your time and effort in reaching out to us.
            </p>
            <a href="/" class="back-home-btn">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</section>

<style>
/* Thank You Page Styles */
.thank-you-section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #f9f9f9; /* Soft background color */
    font-family: 'Arial', sans-serif;
    color: #2d3748;
}

.thank-you-container {
    text-align: center;
    max-width: 600px;
    padding: 20px;
    background: #ffffff; /* White card background */
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Softer shadow */
}

.thank-you-card {
    padding: 40px;
}

.thank-you-icon {
    font-size: 3.5rem;
    color: #6bcf63; /* Soft green for success */
    margin-bottom: 20px;
}

.thank-you-title {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #2d3748;
}

.thank-you-message {
    font-size: 1.1rem;
    color: #4a5568;
    margin-bottom: 30px;
    line-height: 1.6;
}

.back-home-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: #6bcf63; /* Soft green button */
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-home-btn:hover {
    background: #5ab957; /* Slightly darker green on hover */
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(107, 207, 99, 0.3);
}

.back-home-btn i {
    transition: transform 0.3s ease;
}

.back-home-btn:hover i {
    transform: translateX(-3px);
}
</style>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<?php include 'footer.php'; ?>