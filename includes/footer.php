<!-- Wave SVG for top separation -->
<div style="position:relative;top:-1px;">
    <svg viewBox="0 0 1440 90" style="display:block;width:100%;height:90px;" xmlns="http://www.w3.org/2000/svg">
        <path fill="#1a1a1a" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,42.7C384,43,480,53,576,69.3C672,85,768,107,864,112C960,117,1056,107,1152,90.7C1248,75,1344,53,1392,42.7L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
    </svg>
</div>
<footer class="footer-section new-footer">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- About Section -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h4 class="footer-title">WeCare</h4>
                    <p class="footer-desc">
                        Empowering individuals to take control of their health and well-being through innovative digital solutions.
                    </p>
                    <div class="footer-social">
                        <a href="#" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h4 class="footer-title">Our Services</h4>
                    <ul class="footer-links">
                        <li><a href="body.php">Body Care</a></li>
                        <li><a href="mind.php">Mind Care</a></li>
                        <li><a href="meditate.php">Meditation</a></li>
                        <li><a href="blog/index.php">Health Blog</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h4 class="footer-title">Contact Info</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-envelope"></i> support@wecare.com</li>
                        <li><i class="fas fa-phone"></i> +91 1234567890</li>
                        <li><i class="fas fa-map-marker-alt"></i> Greater Noida, Uttar Pradesh</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom mt-4 pt-3">
            <div class="row">
                <div class="col-12 text-center d-flex justify-content-center align-items-center flex-wrap" style="gap:0;">
                    <span>&copy; 2025 WeCare. All rights reserved.</span>
                        <span style="margin-left: 6px;">Made With <i class="fas fa-heart"></i> by Team ENIGMA</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.new-footer {
    background: linear-gradient(135deg, #181d23 0%, #23272f 100%);
    color: #e0e0e0;
    padding: 3.5rem 0 1.5rem 0;
    font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
    border-top: 4px solid #c80d7d;
}
.new-footer .footer-title {
    color: #ff4fa3;
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    margin-bottom: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.new-footer .footer-desc {
    color: #bdbdbd;
    font-size: 1rem;
    margin-bottom: 1.2rem;
    line-height: 1.6;
}
.new-footer .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.new-footer .footer-links li {
    margin-bottom: 0.7rem;
}
.new-footer .footer-links a {
    color: #e0e0e0;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.2s, padding-left 0.2s;
    padding-left: 0;
    display: inline-block;
}
.new-footer .footer-links a:hover {
    color: #ff4fa3;
    padding-left: 8px;
}
.new-footer .footer-social {
    display: flex;
    gap: 0.7rem;
    margin-top: 0.5rem;
}
.new-footer .footer-social a {
    color: #fff;
    background: #c80d7d;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: background 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(200,13,125,0.10);
}
.new-footer .footer-social a:hover {
    background: #ff4fa3;
    color: #fff;
    transform: scale(1.12);
}
.new-footer .footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}
.new-footer .footer-contact li {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    color: #e0e0e0;
    font-size: 1rem;
    gap: 0.7rem;
}
.new-footer .footer-contact i {
    color: #ff4fa3;
    font-size: 1.1rem;
}
.new-footer .footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.08);
    font-size: 1rem;
}
.new-footer .footer-bottom i.fa-heart {
    color: #ff4fa3;
    animation: pulse 1.2s infinite alternate;
}
@keyframes pulse {
    to { transform: scale(1.2); }
}
@media (max-width: 991.98px) {
    .new-footer .footer-widget {
        margin-bottom: 2rem;
    }
}
@media (max-width: 767.98px) {
    .new-footer {
        padding: 2rem 0 1rem 0;
    }
    .new-footer .footer-title {
        font-size: 1.1rem !important;
    }
}
</style>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
</body>
</html>