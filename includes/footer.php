<footer class="footer">

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        ↑
    </button>

    <div class="container">

        <!-- =========================================
             TOP ROW: SEARCH & NEWSLETTER
        ========================================= -->
        <div class="footer-top-row">
            
            <!-- FOOTER SEARCH -->
            <div class="footer-search">
                <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Search site content..." aria-label="Search site content" required>
                    <button type="submit" aria-label="Search">🔍</button>
                </form>
            </div>

            <!-- NEWSLETTER SIGNUP -->
            <div class="footer-newsletter">
                <form action="subscribe.php" method="POST" class="newsletter-form">
                    <input type="email" name="email" placeholder="Your email address..." aria-label="Email address for newsletter" required>
                    <button type="submit" class="btn-subscribe">Subscribe</button>
                </form>
            </div>

        </div>

        <div class="footer-line"></div>

        <!-- =========================================
             MAIN CONTENT GRID
        ========================================= -->
        <div class="footer-grid">

            <!-- BRAND & DESCRIPTION -->
            <div class="footer-brand-col">
                <a href="index.php" class="footer-logo">
                    <img src="images/logo.jpg" alt="" class="footer-logo-img">
                    <span>NAYISHIMANTE<small>.DEV</small></span>
                </a>
                <p class="brand-desc">
                    Full Stack Developer & Digital Strategist crafting modern, scalable, and powerful web applications.
                </p>

                <!-- TRUST / SECURITY BADGES -->
                <div class="trust-badges">
                    <span class="badge-item">🔒 SSL Secured</span>
                    <span class="badge-item">🛡️ Verified Developer</span>
                </div>
            </div>

            <!-- NAVIGATION CATEGORIES -->
            <div class="footer-nav-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="index.php#experience">Experience</a></li>
                    <li><a href="index.php#resume">Resume</a></li>
                </ul>
            </div>

            <div class="footer-nav-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="services.php#web-design">Web Design</a></li>
                    <li><a href="services.php#development">Development</a></li>
                    <li><a href="services.php#consulting">Consulting</a></li>
                    <li><a href="projects.php">Products</a></li>
                </ul>
            </div>

            <div class="footer-nav-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="index.php#testimonials">Testimonials</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="index.php#skills">Skills</a></li>
                    <li><a href="index.php#contact">Accessibility</a></li>
                </ul>
            </div>

            <!-- CONTACT INFO & HOURS -->
            <div class="footer-contact-col">
                <h4>Contact Us</h4>
                <p>📧 Email: <a href="mailto:nayishimantesodique@gmail.com">nayishimantesodique@gmail.com</a></p>
                <p>📞 Phone: <a href="tel:+250781092387">+250 781 092 387</a> / <a href="tel:+250733749729">+250 733 749 729</a></p>
                <p>📍 Location: Kigali, Rwanda</p>
                <p>🕒 Hours: Mon - Fri: 8:00 AM - 6:00 PM (CAT)</p>

                <!-- MAP / LOCATION LINK -->
                <a href="https://maps.google.com" target="_blank" rel="noopener" class="map-link">📍 View on Google Maps</a>
            </div>

        </div>

        <div class="footer-line"></div>

        <!-- =========================================
             SECONDARY ROW: SOCIALS, APPS & PAYMENTS
        ========================================= -->
        <div class="footer-middle-row">

            <!-- SOCIAL MEDIA LINKS -->
            <div class="footer-socials">
                <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook">Facebook</a>
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram">Instagram</a>
                <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="LinkedIn">LinkedIn</a>
                <a href="https://x.com" target="_blank" rel="noopener" aria-label="X">X</a>
                <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube">YouTube</a>
            </div>

            <!-- APP DOWNLOAD BADGES -->
            <div class="app-badges">
                <a href="#" class="app-badge">📱 App Store</a>
                <a href="#" class="app-badge">🤖 Google Play</a>
            </div>

            <!-- PAYMENT METHODS -->
            <div class="payment-methods">
                <span title="Visa">💳 Visa</span>
                <span title="Mastercard">💳 Mastercard</span>
                <span title="PayPal">🅿️ PayPal</span>
                <span title="Mobile Money">📱 Mobile Money</span>
            </div>

        </div>

        <div class="footer-line"></div>

        <!-- =========================================
             BOTTOM ROW: LEGAL & COPYRIGHT
        ========================================= -->
        <div class="footer-bottom">

            <div class="footer-bottom-left">
                <span>© <?= date("Y") ?> Nayishimante Samuel. Built with passion & code.</span>
            </div>

            <!-- LEGAL LINKS -->
            <div class="footer-legal">
                <a href="privacy.php">Privacy Policy</a>
                <a href="terms.php">Terms & Conditions</a>
                <a href="cookies.php">Cookie Policy</a>
            </div>

            <!-- LANGUAGE SELECTOR -->
            <div class="language-selector">
                🌐
                <select name="language" id="langSelect" aria-label="Select Language">
                    <option value="en" selected>English</option>
                    <option value="fr">Français</option>
                    <option value="kin">Kinyarwanda</option>
                </select>
            </div>

        </div>

    </div>

</footer>

<!-- MAIN JAVASCRIPT -->
<script src="js/script.js" defer></script>

</body>
</html>