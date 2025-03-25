<style>
    footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 40px 20px;
    text-align: center;
}

.footer-content {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer-content p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.footer-content a {
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-content a:hover {
    color: #2ecc71;
    text-decoration: underline;
}

.footer-links {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.footer-links a {
    color: #bdc3c7;
    font-weight: 500;
    position: relative;
    transition: all 0.3s ease;
}

.footer-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -5px;
    left: 0;
    background-color: #3498db;
    transition: width 0.3s ease;
}

.footer-links a:hover {
    color: #3498db;
}

.footer-links a:hover::after {
    width: 100%;
}

/* Responsive Design */
@media (max-width: 600px) {
    .footer-content {
        padding: 20px 10px;
    }

    .footer-links {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
}

/* Additional Styling for Small Screens */
@media (max-width: 400px) {
    .footer-content p {
        font-size: 0.9rem;
    }
}
</style>

<footer>
        <div class="footer-content">
            <p>© 2025 IT Support Hub. All rights reserved.</p>
            <p>Contact: <a href="mailto:support@itsupporthub.com">support@itsupporthub.com</a> | +91-123-456-7890 | Mon-Fri, 9 AM - 5 PM</p>
            <div class="footer-links">
                <a href="/privacy">Privacy Policy</a> | <a href="/terms">Terms of Use</a>
            </div>
        </div>
    </footer>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration in milliseconds
            once: true, // Animation happens only once on scroll
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
    <script src="/assets/js/script.js"></script>
</body>
</html>