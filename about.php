<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - WeCare</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom Cursor CSS -->
    <link rel="stylesheet" href="assets/css/custom-cursor.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Custom Cursor JS -->
    <script src="assets/js/custom-cursor.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
 
    <style>
        /* Navbar Hover Styles */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 10px 0;
        }

        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #fff5f8;
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-item i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        /* Reset and Base Styles */
        .about-page {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Custom Properties */
        .about-page {
            --primary-color: #c80d7d;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #1a1a1a;
        }

        /* About Section Specific Styles */
        .about-page .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #fff 0%, var(--light-bg) 100%);
            position: relative;
        }

        .about-page .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/images/pattern.png') repeat;
            opacity: 0.05;
            pointer-events: none;
        }

        /* Title Styles */
        .about-page .about-title {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .about-page .about-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Mission Vision Cards */
        .about-page .mission-vision {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .about-page .mission-vision:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .about-page .mission-vision::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .about-page .mission-vision h3 {
            color: var(--secondary-color);
            font-family: 'Playfair Display', serif;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .about-page .mission-vision h3 i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        /* Content Styles */
        .about-page .about-content {
            font-family: 'Poppins', sans-serif;
            line-height: 1.8;
            color: var(--secondary-color);
        }

        .about-page .about-content h2 {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            margin: 40px 0 20px;
            position: relative;
            padding-left: 20px;
        }

        .about-page .about-content h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .about-page .about-content ul {
            list-style: none;
            padding-left: 0;
        }

        .about-page .about-content ul li {
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
        }

        .about-page .about-content ul li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: bold;
        }

        /* Team Member Styles */
        .about-page .team-member {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .about-page .team-member:hover {
            transform: translateY(-10px);
        }

        .about-page .team-member img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .about-page .team-member:hover img {
            transform: scale(1.05);
        }

        .about-page .team-member h4 {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .about-page .team-member p {
            color: var(--secondary-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Social Links */
        .about-page .social-links {
            margin-top: 15px;
        }

        .about-page .social-links a {
            color: var(--secondary-color);
            margin: 0 10px;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .about-page .social-links a:hover {
            color: var(--primary-color);
        }

        /* Stats Section */
        .about-page .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            padding: 60px 0;
            color: white;
            margin: 60px 0;
            border-radius: 20px;
        }

        .about-page .stat-item {
            text-align: center;
            padding: 20px;
        }

        .about-page .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            font-family: 'Playfair Display', serif;
        }

        .about-page .stat-label {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .about-page .about-section {
                padding: 60px 0;
            }
            
            .about-page .mission-vision {
                margin-bottom: 20px;
            }
            
            .about-page .team-member img {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body class="about-page">
    <?php include 'includes/navbar.php'; ?>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h1 class="about-title">About WeCare</h1>
                    <p class="lead">Your Comprehensive Healthcare Solution</p>
                </div>
            </div>
            
            <!-- Mission and Vision -->
            <div class="row mb-5">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="mission-vision">
                        <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
                        <p>To provide accessible, innovative, and comprehensive healthcare solutions that empower individuals to take control of their physical and mental well-being.</p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="mission-vision">
                        <h3><i class="fas fa-eye"></i> Our Vision</h3>
                        <p>To become the leading platform in digital healthcare, making quality healthcare services accessible to everyone, everywhere.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Patients Served</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Doctors</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- About Content -->
            <div class="row mb-5">
                <div class="col-lg-12" data-aos="fade-up">
                    <div class="about-content">
                        
                        <h2>What We Offer</h2>
                        <p>Our platform offers a comprehensive suite of healthcare services including:</p>
                        <ul>
                            <li>Physical Health Diagnosis with advanced disease prediction tools</li>
                            <li>Menstrual Cycle Tracking for better reproductive health management</li>
                            <li>Mental Health Support with AI-powered chatbot assistance</li>
                            <li>Guided Meditation and Mindfulness Programs</li>
                            <li>Video Consultation Services for remote healthcare access</li>
                            <li>Fitness and Wellness Resources</li>
                            <li>Health Education and Preventive Care Information</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
