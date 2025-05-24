<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>WeCare</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Updated card styles for better alignment */
        .features4 .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            row-gap: 2.5rem !important;
        }
        
        .features4 .item-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 1.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .features4 .item {
            display: flex;
            flex-direction: column;
            height: 100%;
            margin-bottom: 2rem;
            padding: 1rem;
            width: 100%;
        }
        @media (min-width: 768px) {
            .features4 .item {
                width: 50%;
            }
        }
        @media (min-width: 992px) {
            .features4 .item {
                width: 25%;
            }
        }
        .features4 .item-img {
            position: relative;
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .features4 .item-img i {
            font-size: 3.5rem;
            color: #c80d7d;
            transition: all 0.3s ease;
        }
        .features4 .item-wrapper:hover .item-img {
            background: linear-gradient(135deg, #c80d7d 0%, #f06292 100%);
        }
        .features4 .item-wrapper:hover .item-img i {
            color: #fff;
            transform: scale(1.1);
        }
        .features4 .item-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .features4 .item-title {
            font-family: 'Gloock', serif;
            font-size: 1.5rem;
            color: #c80d7d;
            margin-bottom: 1rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 0.5rem;
            line-height: 1.3;
        }
        .features4 .mbr-text {
            font-family: 'Source Serif Pro', serif;
            color: #555;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }
        .features4 .mbr-section-btn {
            margin-top: auto;
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
        .features4 .item-wrapper:hover::before {
            transform: scaleX(1);
        }
        .features4 .item-wrapper:hover {
            box-shadow: 0 8px 32px rgba(200,13,125,0.18);
            transform: translateY(-6px);
        }
        
        /* Enhanced button styling */
        .features4 .btn-primary {
            background: linear-gradient(90deg, #c80d7d 60%, #f06292 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.8rem 1.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(200,13,125,0.08);
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
            box-shadow: 0 4px 16px rgba(200,13,125,0.18);
            transform: translateY(-2px);
        }

        /* Responsive improvements */
        @media (max-width: 991.98px) {
            .features4 .item-title {
                font-size: 1.3rem;
            }
            .features4 .mbr-text {
                font-size: 1rem;
            }
            .features4 .item-wrapper {
                padding: 1.5rem;
            }
        }
        @media (max-width: 767.98px) {
            .features4 .row {
                margin: -0.5rem;
            }
            .features4 .item {
                padding: 0.5rem;
                margin-bottom: 1rem;
            }
            .features4 .item-title {
                font-size: 1.2rem;
            }
            .features4 .mbr-text {
                font-size: 0.95rem;
                margin-bottom: 1rem;
            }
            .features4 .item-wrapper {
                padding: 1.2rem;
            }
        }
        @media (max-width: 575.98px) {
            .features4 .item {
                width: 100%;
            }
            .features4 .item-title {
                font-size: 1.1rem;
            }
            .features4 .mbr-text {
                font-size: 0.9rem;
            }
        }

        /* New styles for additional sections */
        .mind-tips-section {
            background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
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
            font-size: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
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

        .mind-tips-section ul {
            list-style: none;
            padding: 0;
        }

        .mind-tips-section li {
            font-family: 'Source Serif Pro', serif;
            font-size: 1.2rem;
            color: #444;
            line-height: 1.8;
            margin-bottom: 1rem;
            padding-left: 2rem;
            position: relative;
        }

        .mind-tips-section li::before {
            content: '•';
            color: #c80d7d;
            font-size: 1.5rem;
            position: absolute;
            left: 0;
            top: -0.2rem;
        }

        .success-stories-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #fff 0%, #fff5f9 100%);
            position: relative;
        }

        .success-stories-section h3 {
            color: #c80d7d;
            font-family: 'Gloock', serif;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .story-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .story-card::before {
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

        .story-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 30px rgba(200,13,125,0.15);
        }

        .story-text {
            font-family: 'Source Serif Pro', serif;
            font-style: italic;
            color: #555;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .story-author {
            font-family: 'Gloock', serif;
            color: #c80d7d;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .story-author::before {
            content: '';
            display: inline-block;
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, #c80d7d, #f06292);
        }

        /* Animation classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .fade-in-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<section class="info3 cid-smHa3xqxC6 mbr-parallax-background" id="info3-r">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(200 13 125);">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-12 col-lg-10">
                <div class="card-wrapper">
                    <div class="card-box align-center">
                        <h4 class="card-title mbr-fonts-style align-center mb-4 display-1"><strong>Mind Care</strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
   
<section class="features4 cid-smH9YlleGZ" id="features4-q">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-om"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Meditation Tool</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Use our tool to follow your meditation retreat with the sound of the rain or the beach!
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="meditate.php" class="btn item-btn btn-primary display-7">Start Now &gt;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Chat Bot</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Too much on your mind? Use our mental health bot to share and destress.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="#" class="btn item-btn btn-primary display-7">Learn More &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mind Space</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            A curated section of helpful tools and information to assist you in your journey of mental well-being.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="mindspace/index.php" class="btn item-btn btn-primary display-7">Explore Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Questionnaire</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            A Patient Health Questionnaire (PHQ) to determine the levels of depression based on mental health symptoms.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="questionnaire/index.php" class="btn item-btn btn-primary display-7">Explore Now &gt;</a>
                    </div>
                </div>
            </div>

            <!-- New cards -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mental Health Blog</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Explore articles and resources about mental health, wellness tips, and expert advice.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="blog/index.php" class="btn item-btn btn-primary display-7">Read More &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Support Groups</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Connect with others in a safe space. Share experiences and find support in our community.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="support/index.php" class="btn item-btn btn-primary display-7">Join Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-moon"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Sleep Well</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Improve your sleep quality with guided sleep meditation and relaxation techniques.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="sleep/index.php" class="btn item-btn btn-primary display-7">Start Sleeping &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Mood Tracker</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Track your daily mood and emotions to better understand your mental health patterns.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="mood/index.php" class="btn item-btn btn-primary display-7">Track Now &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mind-tips-section">
    <div class="container">
        <h3 class="text-center mb-4"><strong>Daily Mental Wellness Tips</strong></h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul>
                    <li>Practice mindfulness for at least 10 minutes daily to reduce stress and anxiety.</li>
                    <li>Maintain a regular sleep schedule to support your mental health.</li>
                    <li>Stay connected with friends and family for emotional support.</li>
                    <li>Engage in physical activity to boost your mood and reduce stress.</li>
                    <li>Keep a gratitude journal to focus on positive aspects of life.</li>
                    <li>Take regular breaks from digital devices to reduce mental fatigue.</li>
                    <li>Learn to recognize and manage stress triggers effectively.</li>
                    <li>Practice deep breathing exercises during moments of anxiety.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="success-stories-section">
    <div class="container">
        <h3 class="text-center mb-5"><strong>Success Stories</strong></h3>
        <div class="row">
            <div class="col-md-4">
                <div class="story-card fade-in-up">
                    <p class="story-text">"The meditation tool has transformed my daily routine. I've found peace and clarity I never thought possible. The guided sessions are incredibly helpful."</p>
                    <p class="story-author">Emma R.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="story-card fade-in-up" style="transition-delay: 0.2s;">
                    <p class="story-text">"The support groups provided me with a safe space to share my experiences. I've made genuine connections and learned valuable coping strategies."</p>
                    <p class="story-author">Michael T.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="story-card fade-in-up" style="transition-delay: 0.4s;">
                    <p class="story-text">"The mood tracker helped me understand my emotional patterns better. It's been a game-changer in managing my mental health journey."</p>
                    <p class="story-author">Priya S.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
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

<?php include 'includes/footer.php'; ?>

</body>

</html>