<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - WeCare</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
        .privacy-page {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: #f8f9fa;
        }

        .privacy-page {
            --primary-color: #c80d7d;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #1a1a1a;
        }

        .privacy-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            padding: 80px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .privacy-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/images/pattern.png') repeat;
            opacity: 0.1;
            pointer-events: none;
        }

        .privacy-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .privacy-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .privacy-content {
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }

        .privacy-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .privacy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .table-of-contents {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            position: sticky;
            top: 20px;
        }

        .table-of-contents h3 {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-bg);
        }

        .table-of-contents ul {
            list-style: none;
            padding-left: 0;
        }

        .table-of-contents ul li {
            margin-bottom: 15px;
        }

        .table-of-contents ul li a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 10px;
            background: var(--light-bg);
        }

        .table-of-contents ul li a:hover {
            color: var(--primary-color);
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateX(10px);
        }

        .table-of-contents ul li a i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .section-title {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            margin: 40px 0 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-bg);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary-color);
        }

        .privacy-content p {
            color: var(--secondary-color);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .privacy-content ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .privacy-content ul li {
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
            color: var(--secondary-color);
        }

        .privacy-content ul li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: bold;
        }

        .last-updated {
            background: var(--light-bg);
            padding: 20px;
            border-radius: 10px;
            margin-top: 40px;
            text-align: center;
            color: var(--secondary-color);
        }

        .last-updated i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        .floating-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .floating-button:hover {
            transform: translateY(-5px);
            background: var(--accent-color);
            color: white;
        }

        @media (max-width: 768px) {
            .privacy-hero {
                padding: 60px 0;
            }

            .privacy-hero h1 {
                font-size: 2.5rem;
            }

            .privacy-content {
                margin-top: -30px;
            }

            .table-of-contents {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body class="privacy-page">
    <?php include 'includes/navbar.php'; ?>

    <!-- Privacy Hero Section -->
    <section class="privacy-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" data-aos="fade-up">
                    <h1>Privacy Policy</h1>
                    <p>Your privacy is our priority. Learn how we protect and manage your data.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Content Section -->
    <section class="privacy-content">
        <div class="container">
            <div class="row">
                <!-- Table of Contents -->
                <div class="col-lg-3" data-aos="fade-right">
                    <div class="table-of-contents">
                        <h3>Quick Navigation</h3>
                        <ul>
                            <li><a href="#information-collection"><i class="fas fa-database"></i>Information Collection</a></li>
                            <li><a href="#information-use"><i class="fas fa-tasks"></i>Information Use</a></li>
                            <li><a href="#information-sharing"><i class="fas fa-share-alt"></i>Information Sharing</a></li>
                            <li><a href="#data-security"><i class="fas fa-shield-alt"></i>Data Security</a></li>
                            <li><a href="#user-rights"><i class="fas fa-user-shield"></i>Your Rights</a></li>
                            <li><a href="#cookies"><i class="fas fa-cookie-bite"></i>Cookies</a></li>
                            <li><a href="#updates"><i class="fas fa-sync-alt"></i>Updates</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9" data-aos="fade-left">
                    <div class="privacy-card">
                        <h2 id="information-collection" class="section-title">Information We Collect</h2>
                        <p>We collect information that you provide directly to us, including:</p>
                        <ul>
                            <li>Personal information (name, email address, phone number)</li>
                            <li>Medical information and health records</li>
                            <li>Account credentials</li>
                            <li>Payment information</li>
                            <li>Communication preferences</li>
                        </ul>

                        <h2 id="information-use" class="section-title">How We Use Your Information</h2>
                        <p>We use the collected information for various purposes:</p>
                        <ul>
                            <li>To provide and maintain our healthcare services</li>
                            <li>To process your appointments and medical records</li>
                            <li>To communicate with you about our services</li>
                            <li>To improve our website and services</li>
                            <li>To comply with legal obligations</li>
                        </ul>

                        <h2 id="information-sharing" class="section-title">Information Sharing and Disclosure</h2>
                        <p>We may share your information with:</p>
                        <ul>
                            <li>Healthcare providers involved in your care</li>
                            <li>Service providers who assist in our operations</li>
                            <li>Legal authorities when required by law</li>
                            <li>Third parties with your explicit consent</li>
                        </ul>

                        <h2 id="data-security" class="section-title">Data Security</h2>
                        <p>We implement appropriate security measures to protect your information:</p>
                        <ul>
                            <li>Encryption of sensitive data</li>
                            <li>Regular security assessments</li>
                            <li>Access controls and authentication</li>
                            <li>Secure data storage and transmission</li>
                        </ul>

                        <h2 id="user-rights" class="section-title">Your Rights</h2>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Access your personal information</li>
                            <li>Correct inaccurate data</li>
                            <li>Request deletion of your data</li>
                            <li>Opt-out of marketing communications</li>
                            <li>File a complaint about our data practices</li>
                        </ul>

                        <h2 id="cookies" class="section-title">Cookies and Tracking</h2>
                        <p>We use cookies and similar tracking technologies to:</p>
                        <ul>
                            <li>Remember your preferences</li>
                            <li>Analyze website usage</li>
                            <li>Improve user experience</li>
                            <li>Provide personalized content</li>
                        </ul>

                        <h2 id="updates" class="section-title">Policy Updates</h2>
                        <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>

                        <div class="last-updated">
                            <i class="fas fa-clock"></i> Last Updated: March 2024
                        </div>
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

        // Smooth scrolling for table of contents links
        document.querySelectorAll('.table-of-contents a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <!-- Optional: Floating back-to-top button -->
    <a href="#" class="floating-button" title="Back to Top"><i class="fas fa-arrow-up"></i></a>
    <script>
        // Show/hide floating button
        const floatBtn = document.querySelector('.floating-button');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                floatBtn.style.display = 'flex';
            } else {
                floatBtn.style.display = 'none';
            }
        });
        floatBtn.style.display = 'none';
    </script>
</body>
</html> 