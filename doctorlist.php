<?php
session_start();
require_once('config.php'); // Assumes config.php sets up the $con variable for DB connection

// Fetch the profile information if logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['id'];

    // Fetch the user details from the database
    $stmt = $con->prepare("SELECT * FROM wecare_signup WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();

    // Check if profile image exists, otherwise use first letter of the username
    $profileIcon = !empty($userDetails['profile_image']) ? $userDetails['profile_image'] : strtoupper(substr($username, 0, 1));
} else {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="styles/consult.css">
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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
</head>

<body>
    <section class="menu cid-s48OLK6784" once="menu" id="menu1-h">
        <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <span class="navbar-logo">
                        <a href="index.php">
                            <img src="assets/images/thrive_logo.png" alt="Mobirise" style="height: 5rem;">
                        </a>
                    </span>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="index.php#features1-n" target="_blank">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="body.html" target="_blank">Body Care</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="mind.html" target="_blank">Mind Care</a>
                        </li>
                        <li class="nav-item" style="display: flex; align-items: center; margin-right: 15px;">
                            <div class="navbar-profile-icon" style="display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                <?php if (empty($userDetails['profile_image'])): ?>
                                    <div class="profile-icon" style="display: flex; align-items: center; justify-content: center; background-color: #eb4380; width: 30px; height: 30px; border-radius: 50%; color: white; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px;">
                                        <?php echo $profileIcon; ?>
                                    </div>
                                <?php else: ?>
                                    <img src="<?php echo $userDetails['profile_image']; ?>" alt="Profile Icon" class="profile-icon-img" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <span class="navbar-profile-name" style="font-weight: 600; color: #333; font-size: 20px; margin-left: 5px;">
                                <?php echo $username; ?>
                            </span>
                        </li>
                        <li class="nav-item" style="display: flex; align-items: center; margin-left: 20px;">
                            <a href="?logout=true" style="display: flex; align-items: center; font-size: 14px; color: #eeeeee; font-weight: 600; text-decoration: none; padding: 8px 20px; background-color: #e91e63; border-radius: 30px; transition: background-color 0.3s ease;">
                                <span style="font-size: 18px; margin-right: 8px; color: #eeeeee;"></span>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <section class="info3 cid-smHa3xqxC6 mbr-parallax-background" id="info3-r" style="margin-top:30px;">
        <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(200 13 125);">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="card col-12 col-lg-10">
                    <div class="card-wrapper">
                        <div class="card-box align-center">
                            <h4 class="card-title mbr-fonts-style align-center mb-4 display-1">
                                <strong style="font-family: 'Dancing Script', cursive;">Patient Dashboard</strong>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start of Doctor Cards Section -->
    <section class="doctor-cards-section" style="margin-top:30px;">
        <div class="container">
            <div class="row">
                <!-- Doctor Card 1 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/image/doctorsImages/doctor-01.jpg" class="card-img-top" alt="Doctor 1">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Rajesh Kumar</h5>
                            <p class="card-text">Specialization: Cardiologist</p>
                            <p><strong>Appointment Time:</strong> 10:00 AM - 12:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4.5/5)</p>
                            <a href="book_appointment.php?doctor_id=1" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 2 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/image/doctorsImages/doctor-01.jpg" class="card-img-top" alt="Doctor 2">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Priya Sharma</h5>
                            <p class="card-text">Specialization: Neurologist</p>
                            <p><strong>Appointment Time:</strong> 1:00 PM - 3:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
                            <a href="book_appointment.php?doctor_id=2" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 3 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/image/doctorsImages/doctor-01.jpg"" class="card-img-top" alt="Doctor 3">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Sunita Reddy</h5>
                            <p class="card-text">Specialization: Dermatologist</p>
                            <p><strong>Appointment Time:</strong> 9:00 AM - 11:00 AM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4/5)</p>
                            <a href="book_appointment.php?doctor_id=3" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 4 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor4.jpg" class="card-img-top" alt="Doctor 4">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Aakash Patel</h5>
                            <p class="card-text">Specialization: Orthopedic</p>
                            <p><strong>Appointment Time:</strong> 2:00 PM - 4:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
                            <a href="book_appointment.php?doctor_id=4" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 5 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor5.jpg" class="card-img-top" alt="Doctor 5">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Neha Gupta</h5>
                            <p class="card-text">Specialization: Pediatrician</p>
                            <p><strong>Appointment Time:</strong> 11:00 AM - 1:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4/5)</p>
                            <a href="book_appointment.php?doctor_id=5" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 6 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor6.jpg" class="card-img-top" alt="Doctor 6">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Manoj Verma</h5>
                            <p class="card-text">Specialization: Gastroenterologist</p>
                            <p><strong>Appointment Time:</strong> 3:00 PM - 5:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
                            <a href="book_appointment.php?doctor_id=6" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 7 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor7.jpg" class="card-img-top" alt="Doctor 7">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Ramesh Yadav</h5>
                            <p class="card-text">Specialization: Endocrinologist</p>
                            <p><strong>Appointment Time:</strong> 8:00 AM - 10:00 AM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4/5)</p>
                            <a href="book_appointment.php?doctor_id=7" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 8 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor8.jpg" class="card-img-top" alt="Doctor 8">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Priyanka Singh</h5>
                            <p class="card-text">Specialization: Rheumatologist</p>
                            <p><strong>Appointment Time:</strong> 12:00 PM - 2:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4.5/5)</p>
                            <a href="book_appointment.php?doctor_id=8" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 9 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor9.jpg" class="card-img-top" alt="Doctor 9">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Suresh Kumar</h5>
                            <p class="card-text">Specialization: Pulmonologist</p>
                            <p><strong>Appointment Time:</strong> 4:00 PM - 6:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
                            <a href="book_appointment.php?doctor_id=9" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Doctor Card 10 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="doctor10.jpg" class="card-img-top" alt="Doctor 10">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Anjali Desai</h5>
                            <p class="card-text">Specialization: Psychologist</p>
                            <p><strong>Appointment Time:</strong> 6:00 PM - 8:00 PM</p>
                            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4.5/5)</p>
                            <a href="book_appointment.php?doctor_id=10" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Doctor Cards Section -->


    <section class="footer3 cid-s48P1Icc8J" once="footers" id="footer3-i">
        <div class="container">
            <div class="media-container-row align-center mbr-white">
                <div class="row social-row">
                    <div class="social-list align-right pb-2">
                        <div class="soc-item">
                            <a href="https://github.com/Saavanx/wecare_iitm" target="_blank" rel="noopener">
                                <span class="mbr-iconfont mbr-iconfont-social socicon-github socicon"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row row-copirayt">
                    <p class="mbr-text mb-0 mbr-fonts-style mbr-white align-center display-7">Made With ❤️ by Team ENIGMA&nbsp;</p>
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
</body>

</html>