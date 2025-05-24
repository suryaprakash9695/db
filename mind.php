<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>Mind Care | WeCare</title>
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
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Updated header section with pink gradient */
        .info3 {
            background: #fff;
            padding: 3rem 0 1.5rem 0;
        }
        
        .info3 .card-title {
            color: #fff;
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            letter-spacing: 1px;
        }
        
        /* Updated features section */
        .features4 {
            background: #f8f9fa;
            padding: 1.5rem 0 4rem 0;
        }
        
        .features4 .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .features4 .row {
            margin: 0 -1.5rem;
        }
        .features4 .item-wrapper {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(200,13,125,0.07);
            padding: 1.1rem 1rem 1.2rem 1rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            border: 1px solid rgba(200,13,125,0.08);
            position: relative;
            overflow: hidden;
            margin-bottom: 1.2rem;
            min-height: 270px;
            max-width: 340px;
            margin-left: auto;
            margin-right: auto;
        }
        .features4 .item-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #c80d7d, #f06292);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .features4 .item-wrapper:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(200,13,125,0.1);
            }
        
        .features4 .item-wrapper:hover::before {
            transform: scaleX(1);
            }
        
        .features4 .item-img {
            background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .features4 .item-img i {
            font-size: 2.1rem;
            color: #c80d7d;
            transition: all 0.3s ease;
        }
        
        .features4 .item-wrapper:hover .item-img {
            background: linear-gradient(135deg, #c80d7d 0%, #f06292 100%);
        }
        
        .features4 .item-wrapper:hover .item-img i {
            color: #fff;
            transform: scale(1.1) rotate(5deg);
        }
        
        .features4 .item-title {
            color: #c80d7d;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .features4 .item-wrapper:hover .item-title {
            color: #f06292;
        }
        
        .features4 .mbr-text {
            color: #555;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }
        
        .features4 .btn-primary {
            background: linear-gradient(90deg, #c80d7d 0%, #f06292 100%);
            border: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .features4 .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .features4 .btn-primary:hover::before {
            left: 100%;
        }
        
        .features4 .btn-primary:hover {
            background: linear-gradient(90deg, #f06292 0%, #c80d7d 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200,13,125,0.3);
            }
        
        /* Updated tips section */
        .mind-tips-section {
            background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
            padding: 5rem 0;
            position: relative;
        }

        .mind-tips-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="%23c80d7d" opacity="0.1"/></svg>') repeat;
            opacity: 0.5;
        }

        .mind-tips-section h3 {
            color: #c80d7d;
            font-family: 'Gloock', serif;
            font-size: 2.8rem;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
        }

        .mind-tips-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #c80d7d, #f06292);
        }

        .mind-tips-section li {
            font-family: 'Source Serif Pro', serif;
            font-size: 1.2rem;
            color: #444;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            padding-left: 2.5rem;
            position: relative;
        }

        .mind-tips-section li::before {
            content: '•';
            color: #c80d7d;
            font-size: 1.8rem;
            position: absolute;
            left: 0;
            top: -0.2rem;
        }

        /* Updated testimonials section */
        .testimonials-section {
            background: #fff;
            padding: 5rem 0;
        }

        .testimonials-section h3 {
            color: #c80d7d;
            font-family: 'Gloock', serif;
            font-size: 2.8rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .testimonial-card {
            background: #fff5f9;
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(200,13,125,0.05);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 120px;
            font-family: 'Gloock', serif;
            color: #c80d7d;
            opacity: 0.1;
            line-height: 1;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(200,13,125,0.1);
        }

        .testimonial-text {
            font-family: 'Source Serif Pro', serif;
            font-style: italic;
            color: #444;
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            font-family: 'Gloock', serif;
            color: #c80d7d;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .testimonial-author::before {
            content: '';
            display: inline-block;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #c80d7d, #f06292);
        }

        @media (max-width: 991.98px) {
            .features4 { padding: 3rem 0; }
            .mind-tips-section { padding: 3rem 0; }
            .testimonials-section { padding: 3rem 0; }
            .info3 .card-title { font-size: 2.8rem; }
        }
        
        @media (max-width: 767.98px) {
            .features4 .item-wrapper { padding: 1.5rem; }
            .mind-tips-section li { font-size: 1.1rem; }
            .testimonial-text { font-size: 1.1rem; }
        }

        .header-content {
            padding: 2rem 0 1rem 0;
            text-align: center;
        }
        .header-subtitle {
            color: #f06292;
            font-family: 'Source Serif Pro', serif;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .header-icons {
            margin-top: 1.5rem;
        }
        .header-icons i {
            font-size: 2.5rem;
            color: #fff;
            background: linear-gradient(135deg, #c80d7d 0%, #f06292 100%);
            border-radius: 50%;
            padding: 0.7rem 1rem;
            margin: 0 0.5rem;
            box-shadow: 0 4px 16px rgba(200,13,125,0.13);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .header-icons i:hover {
            transform: scale(1.15) rotate(-8deg);
            box-shadow: 0 8px 32px rgba(200,13,125,0.18);
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<section class="info3 cid-smHa3xqxC6 mbr-parallax-background" id="info3-r">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(255 255 255);"></div>
    <div class="container" style="max-width: 1400px;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card-wrapper" style="background: linear-gradient(120deg, #c80d7d 0%, #f06292 100%); border-radius: 2.5rem; box-shadow: 0 8px 32px rgba(200,13,125,0.13); padding: 3rem 3rem 2.5rem 3rem; position: relative; overflow: hidden; max-width: 1200px; margin: 0 auto; min-height: 320px;">
                    <!-- Decorative pink circles -->
                    <div style="position:absolute; top:-40px; left:-40px; width:120px; height:120px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
                    <div style="position:absolute; bottom:-30px; right:-30px; width:80px; height:80px; background:rgba(255,255,255,0.12); border-radius:50%;"></div>
                    <div class="card-box align-center">
                        <h4 class="card-title mbr-fonts-style align-center mb-3 display-1" style="color: #fff; font-weight: 800; letter-spacing: 2px; text-shadow: 0 2px 12px rgba(200,13,125,0.13); font-size: 3.5rem;">
                            <i class="fas fa-heartbeat" style="color: #fff5f9; margin-right: 0.5rem; font-size: 2.1rem;"></i>
                            <strong>Mind Care</strong>
                        </h4>
                        <div class="header-subtitle" style="color: #fff5f9; font-size: 1.3rem; font-family: 'Source Serif Pro', serif; margin-bottom: 1.2rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                            Nurture your mind with smart tools & daily tips..
                        </div>
                        <div class="header-icons" style="margin-top: 1.2rem;">
                            <i class="fas fa-brain" style="background: #f06292; color: #fff; border-radius: 50%; padding: 0.7rem 1rem; margin: 0 0.3rem; font-size: 2rem;"></i>
                            <i class="fas fa-spa" style="background: #c80d7d; color: #fff; border-radius: 50%; padding: 0.7rem 1rem; margin: 0 0.3rem; font-size: 2rem;"></i>
                            <i class="fas fa-heart" style="background: #f06292; color: #fff; border-radius: 50%; padding: 0.7rem 1rem; margin: 0 0.3rem; font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
   
<section class="features4 cid-smH9YlleGZ" id="features4-q">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-om"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Meditation Tool</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Follow guided meditations with soothing sounds to relax your mind and body.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="meditate.php" class="btn item-btn btn-primary display-7">Start Now &gt;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mental Health Bot</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Chat with our AI-powered mental health assistant for support and guidance.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="chatbot/index.php" class="btn item-btn btn-primary display-7">Start Chat &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mind Space</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Explore resources and tools for mental well-being and personal growth.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="mindspace/index.php" class="btn item-btn btn-primary display-7">Explore Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mental Health Check</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Take our comprehensive mental health assessment to understand your well-being.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="questionnaire/index.php" class="btn item-btn btn-primary display-7">Start Check &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mental Health Blog</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Read expert articles and personal stories about mental health and wellness.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="blog/index.php" class="btn item-btn btn-primary display-7">Read More &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Support Groups</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Connect with others in a safe space. Share experiences and find support.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="support/index.php" class="btn item-btn btn-primary display-7">Join Now &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mind-tips-section">
    <div class="container">
        <h3 class="text-center mb-4"><strong>Daily Mind Care Tips</strong></h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul>
                    <li>Practice mindfulness or meditation for at least 10 minutes daily.</li>
                    <li>Take regular breaks from screens and social media.</li>
                    <li>Connect with friends or loved ones to share your feelings.</li>
                    <li>Maintain a regular sleep schedule for better mental health.</li>
                    <li>Engage in activities or hobbies that bring you joy.</li>
                    <li>Seek professional help if you feel overwhelmed or persistently sad.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="testimonials-section">
    <div class="container">
        <h3 class="text-center mb-5"><strong>What Our Users Say</strong></h3>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"The meditation guides helped me manage my stress and anxiety. I feel calmer and more focused every day!"</p>
                    <p class="testimonial-author">Amit S.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Online counseling was a lifesaver during tough times. The support group is so welcoming and helpful."</p>
                    <p class="testimonial-author">Priya R.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"The sleep and relaxation section gave me practical tips that really improved my sleep quality."</p>
                    <p class="testimonial-author">John D.</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <a href="https://mobirise.site/e"></a>
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/tether/tether.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>
    <script src="assets/parallax/jarallax.min.js"></script>
    <script src="assets/mbr-tabs/mbr-tabs.js"></script>
    <script src="assets/dropdown/js/nav-dropdown.js"></script>
    <script src="assets/dropdown/js/navbar-dropdown.js"></script>
    <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="assets/theme/js/script.js"></script>

<script>
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add animation on scroll
    function checkFade() {
        const elements = document.querySelectorAll('.fade-in-up');
        elements.forEach(element => {
            const position = element.getBoundingClientRect();
            if(position.top < window.innerHeight - 100) {
                element.classList.add('active');
            }
        });
    }

    // Check on load
    window.addEventListener('load', checkFade);
    // Check on scroll
    window.addEventListener('scroll', checkFade);
</script>

<?php include 'includes/footer.php'; ?>

</body>

</html>