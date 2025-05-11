<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>WeCare - Login</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .login-container {
            margin-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
        }
        .card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        .card-body {
            padding: 2.5rem;
            text-align: center;
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .card:hover .icon-wrapper {
            transform: scale(1.1);
            background: rgba(255,255,255,0.3);
        }
        .card-title {
            color: white;
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .card-text {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .login-btn {
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            background: white;
            color: #333;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: #333;
            text-decoration: none;
        }
        .patient-card {
            background: linear-gradient(135deg, #0080ff 0%, #00bfff 100%);
        }
        .doctor-card {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        }
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem;
            }
            .card-title {
                font-size: 2rem;
            }
            .card-text {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body style="background: url('assets/images/thrive_logo.png') no-repeat center center fixed; background-size: cover; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">

<?php include 'includes/navbar.php'; ?>

<div class="login-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card patient-card">
                <div class="card-body">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-injured" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h3 class="card-title">Patient Care</h3>
                    <p class="card-text">
                        Access personalized healthcare services, schedule appointments, and manage your medical records all in one place.
                    </p>
                    <a href="patient_login.php" class="login-btn">Login as Patient</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card doctor-card">
                <div class="card-body">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-md" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h3 class="card-title">Doctor Portal</h3>
                    <p class="card-text">
                        Manage your practice, view patient records, and provide quality healthcare services through our integrated platform.
                    </p>
                    <a href="doctor_login.php" class="login-btn">Login as Doctor</a>
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