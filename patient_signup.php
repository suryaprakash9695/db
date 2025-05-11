<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>WeCare Patient Signup</title>
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
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            border-color: #e71f68;
            box-shadow: 0 0 0 0.2rem rgba(231, 31, 104, 0.25);
            background-color: #fff;
        }
        .form-group label {
            color: #333;
            font-weight: 500;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .form-group:hover label {
            color: #e71f68;
        }
        .btn {
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .btn:hover {
            background-color: #d41a5d !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(231, 31, 104, 0.2);
        }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-control::placeholder {
            color: #aaa;
            font-size: 1rem;
            font-weight: 300;
        }
        .card-header {
            border-bottom: 2px solid #f0f0f0;
            background: linear-gradient(to right, #fff, #fff);
        }
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-control:focus::placeholder {
            color: #e71f68;
            opacity: 0.7;
        }
        .form-control:hover {
            border-color: #e71f68;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .container {
                padding: 0 15px;
            }
            .card {
                min-width: 100% !important;
                margin: 0 10px;
            }
            .card-header h3 {
                font-size: 1.8rem !important;
            }
            .form-group label {
                font-size: 1.1rem !important;
            }
            .form-control {
                font-size: 1rem !important;
                padding: 0.8rem 0.75rem !important;
            }
            .btn {
                font-size: 1.2rem !important;
                padding: 0.75rem 0 !important;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                margin-top: 30px !important;
            }
            .card {
                padding: 1.5rem 1rem !important;
            }
            .card-header {
                padding: 1rem 0 !important;
            }
            .card-header h3 {
                font-size: 1.6rem !important;
            }
            .form-group {
                margin-bottom: 1rem !important;
            }
            .form-group label {
                font-size: 1rem !important;
            }
            .form-control {
                font-size: 0.95rem !important;
                padding: 0.7rem 0.75rem !important;
            }
            .btn {
                font-size: 1.1rem !important;
                padding: 0.7rem 0 !important;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                margin-top: 20px !important;
            }
            .card {
                padding: 1rem 0.75rem !important;
            }
            .card-header h3 {
                font-size: 1.4rem !important;
            }
            .form-group {
                margin-bottom: 0.75rem !important;
            }
            .form-group label {
                font-size: 0.95rem !important;
            }
            .form-control {
                font-size: 0.9rem !important;
                padding: 0.6rem 0.75rem !important;
            }
            .btn {
                font-size: 1rem !important;
                padding: 0.6rem 0 !important;
            }
        }

        /* Ensure the image is responsive */
        .img-fluid {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Adjust container padding for better mobile view */
        @media (max-width: 767.98px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container" style="margin-top: 60px;">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-7 d-none d-lg-block text-center">
            <img src="assets/images/login.jpg" alt="Admin Login" class="img-fluid rounded shadow" style="max-width: 95%; min-height: 400px; object-fit: cover;">
        </div>
        <div class="col-lg-5 col-md-10">
            <div class="card shadow" style="padding: 2.5rem 1.5rem; min-width: 380px;">
                <div class="card-header text-center" style="padding: 1.2rem 0; background-color: white;">
                    <h3 style="font-size: 2.2rem; margin-bottom: 0; font-family: 'Dancing Script', cursive; color: #e71f68;">Patient Signup Form</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-4">
                            <label for="username" style="font-size: 1.2rem;">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter your username" required style="font-size: 1.15rem; padding: 0.9rem 0.75rem;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" style="font-size: 1.2rem;">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required style="font-size: 1.15rem; padding: 0.9rem 0.75rem;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="phone" style="font-size: 1.2rem;">Phone No</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required style="font-size: 1.15rem; padding: 0.9rem 0.75rem;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" style="font-size: 1.2rem;">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required style="font-size: 1.15rem; padding: 0.9rem 0.75rem;">
                        </div>
                        <button type="submit" class="btn w-100" style="font-size: 1.3rem; padding: 0.85rem 0; background-color: #e71f68; color: white;">Sign Up</button>
                    </form>
                    <div class="mt-4 text-center">
                        <a href="patient_login.php" class="signup-link" style="font-size: 1.1rem;">Already have an account? Login</a>
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