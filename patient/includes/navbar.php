<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);

require_once('notifications.php');
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="profile-section">
                            <div class="profile-icon">
                                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                            </div>
                            <span style="font-weight: 500;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </div>
                        <div style="position: relative;">
                            <button class="notification-bell" onclick="showNotifications()">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge"></span>
                            </button>
                            <div class="notifications-dropdown"></div>
                        </div>
                        <a href="?logout=true" class="btn display-4" style="background-color: #e71f68; border-color: #e71f68; color: #fff;">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-primary display-4" href="patient_login.php">Login</a>
                        <a class="btn btn-primary display-4" href="patient_signup.php">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</section>

<!-- Include notification scripts and styles -->
<link rel="stylesheet" href="assets/css/notifications.css">
<script src="assets/js/notifications.js"></script> 