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
 <div style="position:fixed;bottom:0;left:0;width:100vw;display:flex;justify-content:end;align-items:end;padding:24px;background:transparent;z-index:9999;">
    <div id="itsahayata-chat-icon">
      <img src="../assets/fav.png" alt="Chatbot" />
      <span>IT Sahayata AI</span>
    </div>
</div>

 <!-- CHATBOT WIDGET -->
 <div id="itsahayata-chatbot-root"></div>
  <script src="../chatbot.js"></script>
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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>