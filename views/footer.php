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
    <script src="/ITSupportApp/assets/js/script.js"></script>
</body>
</html>