<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);

// Determine if we're in the tracker directory
$is_tracker = strpos($_SERVER['PHP_SELF'], '/tracker/') !== false;

// Set the base path for links
$base_path = $is_tracker ? '../db/' : '';

require_once($is_tracker ? '../db/includes/notifications.php' : 'notifications.php');
?>

<section class="menu cid-s48OLK6784" once="menu" id="menu1-h">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="<?php echo $base_path; ?>index.php">
                        <img src="<?php echo $base_path; ?>assets/images/thrive_logo.png" alt="WeCare" style="height: 5rem;">
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
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link link text-black display-4 dropdown-toggle <?php echo ($current_page == 'body.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>body.php" id="bodyCareDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Body Care
                        </a>
                        <div class="dropdown-menu" aria-labelledby="bodyCareDropdown">
                            <a class="dropdown-item" href="<?php echo $base_path; ?>healthChecker/index.php">
                                <i class="fas fa-stethoscope"></i> Health Diagnosis
                                <span class="new-ai-badge">New AI Tool</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>know-your-medicine/medicine.html">
                                <i class="fas fa-pills"></i> Medicine Info
                                <span class="new-purple-badge">New</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>tracker/index.php">
                                <i class="fas fa-calendar-alt"></i> Period Tracker
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>bodyspace/index.html">
                                <i class="fas fa-heartbeat"></i> Body Space
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>fitness/index.php">
                                <i class="fas fa-dumbbell"></i> Fitness Plans
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>recipes/index.php">
                                <i class="fas fa-utensils"></i> Healthy Recipes
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link link text-black display-4 dropdown-toggle <?php echo ($current_page == 'mind.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>mind.php" id="mindCareDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mind Care
                        </a>
                        <div class="dropdown-menu" aria-labelledby="mindCareDropdown">
                            <a class="dropdown-item" href="<?php echo $base_path; ?>meditate.php">
                                <i class="fas fa-om"></i> Meditation
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>chatbot/index.php">
                                <i class="fas fa-robot"></i> Health Bot
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>mindspace/index.php">
                                <i class="fas fa-brain"></i> Mind Space
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>questionnaire/index.php">
                                <i class="fas fa-clipboard-list"></i> Health Check
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>blog/index.php">
                                <i class="fas fa-book-open"></i> Health Blog
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>support/index.php">
                                <i class="fas fa-users"></i> Support Groups
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link link text-black display-4 dropdown-toggle" href="#" id="featuresDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Features
                        </a>
                        <div class="dropdown-menu" aria-labelledby="featuresDropdown">
                            <a class="dropdown-item" href="<?php echo $base_path; ?>body.php">
                                <i class="fas fa-heartbeat"></i> Body Care
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>mind.php">
                                <i class="fas fa-brain"></i> Mind Care
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4 <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>about.php">About</a>
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
                            <a class="dropdown-item" href="<?php echo $base_path; ?>patient_login.php">
                                <i class="fas fa-user"></i>
                                <span>Patient Login</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>doctor_login.php">
                                <i class="fas fa-user-md"></i>
                                <span>Doctor Login</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo $base_path; ?>admin_login.php">
                                <i class="fas fa-user-md"></i>
                                <span>Hospital Administrator</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item signup-link" href="<?php echo $base_path; ?>patient_signup.php">
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
<link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/notifications.css">
<script src="<?php echo $base_path; ?>assets/js/notifications.js"></script>

<style>
.dropdown-menu {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 1rem 0;
    min-width: 250px;
    border: none;
    margin-top: 10px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.dropdown:hover .dropdown-menu,
.dropdown.show .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
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

.dropdown:hover .dropdown-toggle::after,
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

/* Add mobile-friendly styles */
@media (max-width: 991.98px) {
    .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        border: 1px solid rgba(0,0,0,0.1);
        margin-top: 0;
    }
    
    .dropdown-item {
        padding: 0.6rem 1rem;
    }
}

.new-ai-badge {
    background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    margin-left: 8px;
    animation: glow 2s infinite;
    box-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
}

@keyframes glow {
    0% {
        box-shadow: 0 0 5px rgba(255, 107, 107, 0.5);
    }
    50% {
        box-shadow: 0 0 15px rgba(255, 107, 107, 0.8);
    }
    100% {
        box-shadow: 0 0 5px rgba(255, 107, 107, 0.5);
    }
}

.new-purple-badge {
    background: linear-gradient(45deg, #9b59b6, #8e44ad);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    margin-left: 8px;
    animation: glow-purple 2s infinite;
    box-shadow: 0 0 10px rgba(155, 89, 182, 0.5);
}

@keyframes glow-purple {
    0% {
        box-shadow: 0 0 5px rgba(155, 89, 182, 0.5);
    }
    50% {
        box-shadow: 0 0 15px rgba(155, 89, 182, 0.8);
    }
    100% {
        box-shadow: 0 0 5px rgba(155, 89, 182, 0.5);
    }
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Add click functionality for mobile devices
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                e.preventDefault();
                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('show');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown.show').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
});
</script> 