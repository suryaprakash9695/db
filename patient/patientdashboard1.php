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

    <section class="features4 cid-smH9YlleGZ" id="features4-q" style="background: #eeeeee; padding: 10px;">
        <div class="container" style="margin: 5px 5%; min-width:90%;">
            <div class="row mt-4">
                <div class="item features-image сol-12 col-md-6 col-lg-6">
                    <div class="item-wrapper">
                        <div class="item-img">
                            <img src="assets/images/expert.jpg" alt="" title="">
                        </div>
                        <div class="item-content">
                            <h5 class="item-title mbr-fonts-style display-5" style="color: #ea0faa;">
                                <strong>Book Appointment</strong>
                            </h5>
                            <p class="mbr-text mbr-fonts-style mt-3 display-7">
                                We put together an array of dedicated and skilled experts to assist you out of every hurdle you may come across, in a diligent and efficient manner.
                            </p>
                        </div>
                        <div class="mbr-section-btn item-footer mt-2"><a href="doctorlist.php" class="btn item-btn btn-primary display-7">Book Now &gt;</a></div>
                    </div>
                </div>
                <div class="item features-image col-12 col-md-6 col-lg-6">
                    <div class="item-wrapper">
                        <div class="item-img">
                            <img src="assets/images/patient_dashboard.jpg" alt="" title="">
                        </div>
                        <div class="item-content">
                            <h5 class="item-title mbr-fonts-style display-5" style="color:#ea0faa;">
                                <strong>Track History</strong>
                            </h5>
                            <p class="mbr-text mbr-fonts-style mt-3 display-7">
                                A clear & uninterrupted chain of medical records are important to understand the complete condition & provide the necessary treatment. While you heal with us, we maintain the history for you.
                            </p>
                        </div>
                        <div class="mbr-section-btn item-footer mt-2"><a href="patientDashboard.php" class="btn item-btn btn-primary display-7">Track Now &gt;</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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