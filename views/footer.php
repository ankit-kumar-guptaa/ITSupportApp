<style>
    /* IT Sahayata Footer Styles */
    .its-footer {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: #ffffff;
        padding: 60px 0 30px;
        position: relative;
        overflow: hidden;
    }

    .its-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.03)" d="M0,0 L100,0 L100,100 Q50,80 0,100 Z"></path></svg>');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: bottom;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
        z-index: 1;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-logo {
        margin-bottom: 20px;
    }

    .footer-logo img {
        height: 80px;
        filter: brightness(0) invert(1);
    }

    .footer-about p {
        color: rgba(255,255,255,0.8);
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .footer-heading {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #ffffff;
        position: relative;
        display: inline-block;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 40px;
        height: 3px;
        background-color: #3b82f6;
        border-radius: 3px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .footer-links a:hover {
        color: #ffffff;
        transform: translateX(5px);
    }

    .footer-links a i {
        margin-right: 10px;
        font-size: 0.8rem;
        color: #3b82f6;
    }

    .footer-contact p {
        display: flex;
        align-items: flex-start;
        color: rgba(255,255,255,0.8);
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .footer-contact i {
        margin-right: 12px;
        color: #3b82f6;
        font-size: 1.1rem;
        margin-top: 3px;
    }

    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background: #3b82f6;
        transform: translateY(-3px);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 30px;
        text-align: center;
    }

    .footer-bottom p {
        color: rgba(255,255,255,0.6);
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .footer-bottom-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .footer-bottom-links a {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .footer-bottom-links a:hover {
        color: #ffffff;
    }

    .footer-bottom-links a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        left: 0;
        background-color: #3b82f6;
        transition: width 0.3s ease;
    }

    .footer-bottom-links a:hover::after {
        width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-heading {
            margin-bottom: 15px;
        }

        .social-links {
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px) {
        .footer-bottom-links {
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
    }
</style>

<footer class="its-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-about">
                <div class="footer-logo">
                    <img src="/assets/light-footer.svg"  width="250px" alt="IT Sahayata">
                </div>
                <p>Your trusted partner for comprehensive IT solutions. We provide 24/7 support to keep your business running smoothly.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-links-col">
                <h3 class="footer-heading">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="/"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="/views/service.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="/views/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="/views/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="/blog/index.php"><i class="fas fa-chevron-right"></i> Blog</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h3 class="footer-heading">Services</h3>
                <ul class="footer-links">
                    <li><a href="/hardware-support"><i class="fas fa-chevron-right"></i> Hardware Support</a></li>
                    <li><a href="/software-support"><i class="fas fa-chevron-right"></i> Software Support</a></li>
                    <li><a href="/network-support"><i class="fas fa-chevron-right"></i> Network Solutions</a></li>
                    <li><a href="/cloud-services"><i class="fas fa-chevron-right"></i> Cloud Services</a></li>
                    <li><a href="/cybersecurity"><i class="fas fa-chevron-right"></i> Cybersecurity</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h3 class="footer-heading">Contact Us</h3>
                <p><i class="fas fa-map-marker-alt"></i>Badarpur , New Delhi - 110044</p>
                <p><i class="fas fa-map-marker-alt"></i>jankipuram Sector H lucknow 226021</p>
                <p><i class="fas fa-envelope"></i> support@itsahayata.com</p>
                <p><i class="fas fa-clock"></i> Mon-Sun: 24/7 Support</p>
                <p><i class="fas fa-phone-alt"></i> +91 77038 23008</p>
                <p><i class="fas fa-phone-alt"></i> +91 73792 17619</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 IT Sahayata. All Rights Reserved.</p>
            <div class="footer-bottom-links">
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="/terms-conditions">Terms & Conditions</a>
                <a href="/refund-policy">Refund Policy</a>
                <a href="/sitemap">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
 <!-- FOOTER WITH CHATBOT ICON -->
 <div style="position:fixed;bottom:0;right:0;display:flex;justify-content:end;align-items:end;padding:24px;background:transparent;z-index:9999;">
    <div id="itsahayata-chat-icon">
      <img src="../assets/ai-chat.gif" alt="Chatbot" />
      <!-- <span style="color:#ffffff;">IT Sahayata AI</span> -->
    </div>
</div>

 <!-- CHATBOT WIDGET -->
 <div id="itsahayata-chatbot-root"></div>
  <script src="../chatbot.js"></script>



  <!-- Modern AI Chat Widget -->
<div class="ai-helper-widget">
    <!-- Collapsed State (Always Visible) -->
    <div class="ai-collapsed">
        <div class="ai-icon">
            <i class="fas fa-robot"></i>
            <span class="ai-pulse"></span>
        </div>
        <div class="ai-badge">IT Sahayta AI</div>
    </div>
    
    <!-- Expanded State -->
    <div class="ai-expanded">
        <div class="ai-header">
            <h3><i class="fas fa-bolt"></i> IT Sahayta AI</h3>
            <div class="ai-status">
                <span class="status-dot"></span>
                <span>Ready to help</span>
            </div>
        </div>
        
        <div class="ai-content">
            <p>Need instant IT support? I can help with:</p>
            <ul class="ai-features">
                <li><i class="fas fa-check-circle"></i> Troubleshooting</li>
                <li><i class="fas fa-check-circle"></i> Technical issues</li>
                <li><i class="fas fa-check-circle"></i> System errors</li>
                <li><i class="fas fa-check-circle"></i> Network problems</li>
            </ul>
        </div>
        
        <a href="/views/ai_chat.php" class="ai-chat-btn">
            <i class="fas fa-comment-dots"></i> Chat Now
        </a>
    </div>
</div>

<style>
/* Modern AI Widget Styles */
.ai-helper-widget {
    position: fixed;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    z-index: 9999;
    font-family: 'Inter', sans-serif;
    display: flex;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

/* Collapsed State (Always Visible) */
.ai-collapsed {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #6b48ff 0%, #00ddeb 100%);
    border-radius: 0 15px 15px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 2px 0 15px rgba(0,0,0,0.15);
    position: relative;
    z-index: 2;
}

.ai-icon {
    color: white;
    font-size: 24px;
    position: relative;
}

.ai-pulse {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 12px;
    height: 12px;
    background: #ff4d4d;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

.ai-badge {
    position: absolute;
    right: -85px;
    top: 50%;
    transform: translateY(-50%) rotate(90deg);
    transform-origin: left top;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
    opacity: 0;
    transition: all 0.3s ease;
}

.ai-collapsed:hover .ai-badge {
    opacity: 1;
    right: -75px;
}

/* Expanded State */
.ai-expanded {
    width: 280px;
    background: white;
    border-radius: 0 15px 15px 0;
    box-shadow: 2px 0 25px rgba(0,0,0,0.1);
    padding: 20px;
    margin-left: -280px;
    opacity: 0;
    transition: all 0.3s ease;
    border-left: 5px solid #6b48ff;
}

.ai-helper-widget:hover .ai-expanded {
    margin-left: 0;
    opacity: 1;
}

.ai-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.ai-header h3 {
    margin: 0;
    color: #2d3748;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ai-header h3 i {
    color: #6b48ff;
}

.ai-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #64748b;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.ai-content {
    margin-bottom: 20px;
}

.ai-content p {
    margin: 0 0 12px 0;
    color: #4b5563;
    font-size: 14px;
    line-height: 1.5;
}

.ai-features {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ai-features li {
    padding: 6px 0;
    color: #3f3f46;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.ai-features li:hover {
    color: #6b48ff;
    transform: translateX(5px);
}

.ai-features li i {
    color: #6b48ff;
    font-size: 12px;
}

.ai-chat-btn {
    display: block;
    text-align: center;
    padding: 12px;
    background: linear-gradient(to right, #6b48ff, #00ddeb);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(107, 72, 255, 0.2);
}

.ai-chat-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 72, 255, 0.3);
}

.ai-chat-btn i {
    margin-right: 8px;
}

/* Animations */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .ai-expanded {
        width: 240px;
        margin-left: -240px;
    }
    
    .ai-content p {
        font-size: 13px;
    }
    
    .ai-features li {
        font-size: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiWidget = document.querySelector('.ai-helper-widget');
    
    // Show expanded panel briefly on page load
    setTimeout(() => {
        aiWidget.classList.add('peek');
        setTimeout(() => {
            aiWidget.classList.remove('peek');
        }, 3000);
    }, 1500);
});
</script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration in milliseconds
            once: true, // Animation happens only once on scroll
        });
    </script>

     

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const mobileCloseBtn = document.querySelector('.mobile-close-btn');
            
            // Toggle menu
            navbarToggler.addEventListener('click', function() {
                navbarCollapse.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
            
            // Close menu with close button
            mobileCloseBtn.addEventListener('click', function() {
                navbarCollapse.classList.remove('show');
                document.body.style.overflow = '';
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!navbarCollapse.contains(event.target) && 
                    !navbarToggler.contains(event.target) &&
                    navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // Close menu when clicking on nav links (for single page navigation)
            document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarCollapse.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });
            
            // Initialize dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>



    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8SCPHP7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->  
</body>
</html>