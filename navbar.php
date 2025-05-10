<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<section class="menu cid-s48OLK6784" once="menu" id="menu1-h">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/thrive_logo.png" alt="Thrive" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php#features1-n">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'body.php') ? 'active' : ''; ?>" href="body.php">Body Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'mind.php') ? 'active' : ''; ?>" href="mind.php">Mind Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'signup.php') ? 'active' : ''; ?>" href="signup.php">Dashboard</a>
                    </li>
                </ul>
                
                <div class="navbar-buttons ml-3">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Log In/Sign Up
                        </button>
                        <div class="dropdown-menu" aria-labelledby="loginDropdown">
                            <a class="dropdown-item" href="patient/patient_login.php">Login as Patient</a>
                            <a class="dropdown-item" href="doctor/doctor_login.php">Login as Doctor</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</section> 