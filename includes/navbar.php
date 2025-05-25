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
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
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
                   
                        <div class="dropdown">
                            <button class="btn btn-primary display-4 dropdown-toggle" type="button" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Login
                            </button>
                            <div class="dropdown-menu" aria-labelledby="loginDropdown">
                                <div class="dropdown-header">
                                    <h6>Choose your role</h6>
                                </div>
                                <a class="dropdown-item" href="patient_login.php">
                                    <i class="fas fa-user"></i>
                                    <span>Patient Login</span>
                                </a>
                                <a class="dropdown-item" href="doctor_login.php">
                                    <i class="fas fa-user-md"></i>
                                    <span>Doctor Login</span>
                                </a>
                                <a class="dropdown-item" href="admin_login.php">
                                    <i class="fas fa-user-md"></i>
                                    <span>Hospital Administrator</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item signup-link" href="patient_signup.php">
                                    <i class="fas fa-user-plus"></i>
                                    <span>New User? Sign Up</span>
                                </a>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </nav>
</section>

<!-- Include notification scripts and styles -->
<link rel="stylesheet" href="assets/css/notifications.css">
<script src="assets/js/notifications.js"></script>

<style>
.dropdown-menu {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 1rem 0;
    min-width: 250px;
    border: none;
    margin-top: 10px;
}

.dropdown-header {
    padding: 0.5rem 1.5rem;
    color: #666;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dropdown-item {
    padding: 0.8rem 1.5rem;
    color: #333;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.dropdown-item i {
    width: 20px;
    color: #e71f68;
    font-size: 1.1rem;
}

.dropdown-item:hover {
    background-color: #fff5f8;
    color: #e71f68;
    transform: translateX(5px);
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-top: 1px solid #eee;
}

.signup-link {
    color: #e71f68;
    font-weight: 500;
}

.signup-link:hover {
    background-color: #fff5f8;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.5rem 1.2rem;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.dropdown-toggle::after {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.dropdown.show .dropdown-toggle::after {
    transform: rotate(180deg);
}

.btn-primary {
    background-color: #e71f68;
    border-color: #e71f68;
    color: white;
}

.btn-primary:hover {
    background-color: #d41a5f;
    border-color: #d41a5f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(231, 31, 104, 0.2);
}

/* Animation for dropdown */
.dropdown-menu {
    animation: dropdownFade 0.3s ease;
}

@keyframes dropdownFade {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 