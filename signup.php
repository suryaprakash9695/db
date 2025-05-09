<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">


    <title>Signup</title>
    <link rel="stylesheet" href="styles/login.css">
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
<?php
session_start();
require_once('./config.php'); // Ensure your database connection is here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form input
    $email = trim($_POST['email']);
    $u_name = trim($_POST['u_name']);
    $pass = $_POST['password'];
    $occupation = $_POST['occupation'];
    $uid = uniqid($u_name); // Generate a unique user ID
    
    $checkEmail = $con->prepare("SELECT * FROM `wecare_signup` WHERE email=?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $emailResult = $checkEmail->get_result();

    if ($emailResult->num_rows > 0) {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>Email already exists. 
              <a href='login.php'>Go back to Login Page</a></h3>";
        exit();
    }
    $checkUsername = $con->prepare("SELECT * FROM `wecare_signup` WHERE username=?");
    $checkUsername->bind_param("s", $u_name);
    $checkUsername->execute();
    $usernameResult = $checkUsername->get_result();

    if ($usernameResult->num_rows > 0) {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>Username already exists. 
              <a href='login.php'>Go back to Login Page</a></h3>";
        exit();
    }

    $sql = $con->prepare("INSERT INTO `wecare_signup` (`userid`, `username`, `password`, `email`, `role`) 
                          VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $uid, $u_name, $securepass, $email, $occupation);

    if ($sql->execute()) {
        echo "<script type='text/javascript'>
                alert('Signup Successful! You can login now.');
                window.location.href = 'login.php'; // Redirect to login page
              </script>";
    } else {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>ERROR: " . $con->error . "</h3>";
    }

    $sql->close();
    $con->close();
}
?>
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
                            <a class="nav-link link text-black display-4" href="index.php#features1-n">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="body.html">Body Care</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="mind.html">Mind Care</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black display-4" href="signup.php">Dashboard</a>
                        </li>
                    </ul>

                    <div class="navbar-buttons mbr-section-btn">
                        <a class="btn btn-primary display-4" href="signup.php">
                            Log In/Sign Up
                        </a>
                    </div>
                </div>
            </div>
        </nav>

    </section>


    <section class="image1 login-section" id="image1-m" style="padding:0px 10%;">
        <div class="container login">
            <div class="col-12 col-lg-6">
                <img src="assets/images/login.jpg" alt="log-in">
            </div>
            <div class="col-12 col-lg-6">
                <div class="text-wrapper align-items-right">
                    <h3 class="mbr-section-title mbr-fonts-style  display-5">
                        <strong style="font-family: 'Dancing Script', cursive; ">Sign Up</strong>
                    </h3>
                    <div>
                        <form method="POST" action="signup.php" id="signupForm">
                            <div class="form-floating form-field-login">
                                <label for="u_name">Name</label>
                                <input type="text" class="form-control" id="u_name" name="u_name" required>
                            </div>
                            <div class="form-floating form-field-login">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-floating form-field-login">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <!-- Two separate buttons for Patient and Doctor Signup -->
                            <button type="submit" class="btn btn-primary" name="occupation" value="patient">Sign Up As Patient</button>
                            OR
                            <button type="submit" class="btn btn-primary" name="occupation" value="doctor">Sign Up As Doctor</button>

                            <div class="form-floating form-field-login" style="text-align:center; margin:15px;">
                                <a href="login.php">Already a member? Click here to Login.</a>
                            </div>
                        </form>


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
                            <a href="https://github.com/Saavanx/wecare_iitm" target="_blank">
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
<!-- <script>
    $("#signupForm").submit(function(e){
        e.preventDefault();
        console.log("aaya");
    })
</script> -->

</html>