<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

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
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php#features1-n">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'body.php') ? 'active' : ''; ?>" href="body.php">Body Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'mind.php') ? 'active' : ''; ?>" href="mind.php">Mind Care</a>
                    </li>
                </ul>

                <div class="navbar-buttons mbr-section-btn">
                    <a class="btn display-4" href="main_login_signup.php" style="background-color: #e71f68; border-color: #e71f68; color: #fff;">Log In/Sign Up</a>
                </div>
            </div>
        </div>
    </nav>
</section> 