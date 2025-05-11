<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>WeCare Doctor Login</title>
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
        body {
            background: linear-gradient(135deg, #f0fff0 0%, #ffffff 100%);
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.15);
            background-color: #fff;
            transform: translateY(-2px);
        }
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.7rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            display: block;
            padding-left: 0.5rem;
        }
        .form-group:hover label {
            color: #2ecc71;
            transform: translateX(5px);
        }
        .login-btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1.2rem;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
        }
        .btn:hover {
            background-color: #d41a5d !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(231, 31, 104, 0.3);
        }
        .btn:active {
            transform: translateY(-1px);
        }
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.15);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ffffff 0%, #f0fff0 100%);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #2ecc71, #27ae60);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(46, 204, 113, 0.2);
        }
        .card-header {
            border-bottom: 2px solid rgba(46, 204, 113, 0.1);
            background: transparent;
            padding: 2rem 0 1.5rem;
        }
        .form-control {
            border: 2px solid rgba(46, 204, 113, 0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.15);
            background-color: #fff;
            transform: translateY(-2px);
        }
        .form-group label {
            color: #2ecc71;
            font-weight: 600;
            margin-bottom: 0.7rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            display: block;
            padding-left: 0.5rem;
        }
        .form-group:hover label {
            color: #27ae60;
            transform: translateX(5px);
        }
        .form-control::placeholder {
            color: #aaa;
            font-size: 1rem;
            font-weight: 400;
            transition: all 0.3s ease;
        }
        .form-control:focus::placeholder {
            color: #2ecc71;
            opacity: 0.7;
            transform: translateX(5px);
        }
        .form-control:hover {
            border-color: #2ecc71;
            background-color: #fff;
        }

        /* Enhanced Responsive Styles */
        @media (max-width: 991.98px) {
            .container {
                padding: 0 20px;
            }
            .card {
                min-width: 100% !important;
                margin: 0 15px;
            }
            .card-header h3 {
                font-size: 2rem !important;
            }
            .form-group label {
                font-size: 1.2rem !important;
            }
            .form-control {
                font-size: 1.1rem !important;
                padding: 1rem 1.2rem !important;
            }
            .btn {
                font-size: 1.3rem !important;
                padding: 1rem 0 !important;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                margin-top: 40px !important;
            }
            .card {
                padding: 2rem 1.5rem !important;
            }
            .card-header {
                padding: 1.5rem 0 !important;
            }
            .card-header h3 {
                font-size: 1.8rem !important;
            }
            .form-group {
                margin-bottom: 1.5rem !important;
            }
            .form-group label {
                font-size: 1.1rem !important;
            }
            .form-control {
                font-size: 1rem !important;
                padding: 0.9rem 1.1rem !important;
            }
            .btn {
                font-size: 1.2rem !important;
                padding: 0.9rem 0 !important;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                margin-top: 30px !important;
            }
            .card {
                padding: 1.5rem 1.2rem !important;
            }
            .card-header h3 {
                font-size: 1.6rem !important;
            }
            .form-group {
                margin-bottom: 1.2rem !important;
            }
            .form-group label {
                font-size: 1rem !important;
            }
            .form-control {
                font-size: 0.95rem !important;
                padding: 0.8rem 1rem !important;
            }
            .btn {
                font-size: 1.1rem !important;
                padding: 0.8rem 0 !important;
            }
        }

        /* Enhanced Image Styling */
        .img-fluid {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .img-fluid:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Container Adjustments */
        @media (max-width: 767.98px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* Add subtle animation to the card */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Add hover effect to form inputs */
        .form-control {
            position: relative;
            z-index: 1;
        }
        .form-control:hover {
            z-index: 2;
        }

        /* Add subtle gradient to the button */
        .btn {
            background: linear-gradient(45deg, #e71f68, #ff4d8d);
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Doctor Login Page Specific Button */
        .doctor-page-login-btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1.2rem;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
            color: white;
            width: 100%;
        }

        .doctor-page-login-btn:hover {
            background-color: #27ae60 !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(46, 204, 113, 0.3);
            color: white;
            text-decoration: none;
        }

        .doctor-page-login-btn:active {
            transform: translateY(-1px);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container" style="margin-top: 60px;">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-7 d-none d-lg-block text-center">
            <img src="assets/images/login.jpg" alt="Doctor Login" class="img-fluid rounded shadow" style="max-width: 95%; min-height: 450px; object-fit: cover;">
        </div>
        <div class="col-lg-5 col-md-10">
            <div class="card shadow" style="padding: 2.5rem 2rem; min-width: 380px; background: linear-gradient(135deg, #ffffff 0%, #f0fff0 100%);">
                <div class="card-header text-center" style="padding: 1.2rem 0;">
                    <h3 style="font-size: 2.4rem; margin-bottom: 0; font-family: 'Dancing Script', cursive; color: #2ecc71; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Doctor Login</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="doctor-page-login-btn">Login to Dashboard</button>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="mb-2" style="font-size: 1.1rem;">NOTE : For Login Details Contact to Admin</p>
                        <a href="admin_login.php" class="text-decoration-none" style="color: #2ecc71; font-weight: 600; font-size: 1.1rem;">Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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