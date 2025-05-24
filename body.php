<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">


    <title>WeCare -Body Care</title>
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
        /* Enhanced, Responsive, and Animated Header */
        .info3 {
            position: relative;
            padding: 3rem 0 1.5rem 0;
            background: #fff;
            overflow: hidden;
        }

        .info3 .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .info3 .card {
            background: rgba(255,255,255,0.15);
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(200,13,125,0.10);
            padding: 1.5rem 1rem 1.2rem 1rem;
            backdrop-filter: blur(2px);
            animation: fadeInDown 1s cubic-bezier(.39,.575,.565,1) both;
        }

        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-40px);}
            100% { opacity: 1; transform: translateY(0);}
        }

        .info3 .card-title {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
            text-align: center;
            letter-spacing: -1px;
            text-shadow: 0 2px 8px rgba(200,13,125,0.10);
            line-height: 1.1;
            background: linear-gradient(90deg, #fff 60%, #f06292 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info3 .card-box {
            padding: 0.5rem 0 0.2rem 0;
        }

        /* Premium Features Section */
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

        /* Premium Button Styling */
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

        /* Premium Health Tips Section */
        .health-tips-section {
            background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
            padding: 5rem 0;
            position: relative;
        }

        .health-tips-section h3 {
            color: #c80d7d;
            font-family: 'Gloock', serif;
            font-size: 2.8rem;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
        }

        .health-tips-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #c80d7d, #f06292);
        }

        .health-tips-section ul {
            max-width: 900px;
            margin: 0 auto;
            padding: 0;
            list-style: none;
        }

        .health-tips-section li {
            font-family: 'Source Serif Pro', serif;
            font-size: 1.2rem;
            color: #444;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            padding-left: 2.5rem;
            position: relative;
        }

        .health-tips-section li::before {
            content: '•';
            color: #c80d7d;
            font-size: 1.8rem;
            position: absolute;
            left: 0;
            top: -0.2rem;
        }

        /* Premium Testimonials Section */
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

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(200,13,125,0.1);
        }

        /* Premium Responsive Design */
        @media (max-width: 1199.98px) {
            .info3 .card-title {
                font-size: 4rem;
            }
            
            .features4 .item-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 991.98px) {
            .info3 .card-title {
                font-size: 3.5rem;
            }
            
            .features4 { padding: 3rem 0; }
            .features4 .item-wrapper { padding: 1.5rem; }
            
            .health-tips-section h3,
            .testimonials-section h3 {
                font-size: 3rem;
            }
        }

        @media (max-width: 767.98px) {
            .info3 {
                padding: 1.2rem 0 1rem 0;
            }
            
            .info3 .container {
                max-width: 98vw;
                padding: 0 0.5rem;
            }
            
            .info3 .card {
                padding: 1rem 0.5rem 0.8rem 0.5rem;
            }
            
            .info3 .card-title {
                font-size: 1.3rem;
            }
            
            .features4 .item-wrapper { padding: 1.5rem; }
            
            .health-tips-section h3,
            .testimonials-section h3 {
                font-size: 2.5rem;
            }
            
            .health-tips-section li {
                font-size: 1.1rem;
                padding: 1.2rem 1.5rem;
            }
            
            .features4 .item-img i { font-size: 1.5rem; }
        }

        @media (max-width: 575.98px) {
            .info3 .card-title {
                font-size: 1.8rem;
            }
            
            .features4 .item-title {
                font-size: 1.4rem;
            }
            
            .health-tips-section h3,
            .testimonials-section h3 {
                font-size: 2rem;
            }
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
                            <strong>Body Care</strong>
                        </h4>
                        <div class="header-subtitle" style="color: #fff5f9; font-size: 1.3rem; font-family: 'Source Serif Pro', serif; margin-bottom: 1.2rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                            Empower your body with smart tools & daily tips..
                        </div>
                        <div class="header-icons" style="margin-top: 1.2rem;">
                            <i class="fas fa-dumbbell" style="background: #f06292; color: #fff; border-radius: 50%; padding: 0.7rem 1rem; margin: 0 0.3rem; font-size: 2rem;"></i>
                            <i class="fas fa-stethoscope" style="background: #c80d7d; color: #fff; border-radius: 50%; padding: 0.7rem 1rem; margin: 0 0.3rem; font-size: 2rem;"></i>
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
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Physical Health Diagnosis</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Our physical health diagnosis tools will help you in assessing your symptoms with the feature of disease prediction.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="./healthChecker/index.php" class="btn item-btn btn-primary display-7">Start Now &gt;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Menstrual Cycle Tracker</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Menstrual cycle is a crucial part of a woman's health and well-being. Track your period using this tool.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="Tracker.php" class="btn item-btn btn-primary display-7">Track Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Body Space</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            A curated section of helpful tools and information to assist you in your journey of physical well-being.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="bodyspace/index.html" class="btn item-btn btn-primary display-7">Explore Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Know Your Medicine</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Read more about Drugs and Medicines and the top health news in India to stay up to date and take better care of your health with the right information.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="know-your-medicine/medicine.html" class="btn item-btn btn-primary display-7">Explore Now &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Fitness & Exercise Plans</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Discover personalized workout routines and tips to help you stay active and fit, no matter your level.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="fitness/index.php" class="btn item-btn btn-primary display-7">Get Started &gt;</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="item-wrapper">
                    <div class="item-img">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="item-content">
                        <h5 class="item-title mbr-fonts-style display-5"><strong>Healthy Recipes</strong></h5>
                        <p class="mbr-text mbr-fonts-style mt-3 display-7">
                            Explore a collection of nutritious and delicious recipes to support your health and wellness goals.
                        </p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="recipes/index.php" class="btn item-btn btn-primary display-7">Explore Recipes &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="health-tips-section">
    <div class="container">
        <h3 class="text-center mb-4" style="color: #c80d7d; font-family: 'Gloock', serif;"><strong>Daily Health Tips</strong></h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul style="font-family: 'Source Serif Pro', serif; font-size: 1.1rem; color: #444; line-height: 1.7;">
                    <li>Drink at least 8 glasses of water a day to stay hydrated.</li>
                    <li>Incorporate at least 30 minutes of physical activity into your daily routine.</li>
                    <li>Eat a balanced diet rich in fruits, vegetables, and whole grains.</li>
                    <li>Get 7-8 hours of quality sleep every night.</li>
                    <li>Take short breaks from screens to rest your eyes and stretch your body.</li>
                    <li>Practice mindfulness or meditation to reduce stress.</li>
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
                <div class="testimonial-card fade-in-up">
                    <p class="testimonial-text">"The health diagnosis tool helped me understand my symptoms better. Very user-friendly and informative! It's like having a doctor in your pocket."</p>
                    <p class="testimonial-author">Sarah M.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card fade-in-up" style="transition-delay: 0.2s;">
                    <p class="testimonial-text">"The menstrual tracker is a game-changer. It's so easy to use and keeps me informed about my cycle. The predictions are incredibly accurate!"</p>
                    <p class="testimonial-author">Priya K.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card fade-in-up" style="transition-delay: 0.4s;">
                    <p class="testimonial-text">"The healthy recipes section has transformed my eating habits. Great variety and easy to follow! I've never felt better."</p>
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