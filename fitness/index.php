<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness & Exercise Plans | WeCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="../assets/tether/tether.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../assets/dropdown/css/style.css">
    <link rel="stylesheet" href="../assets/socicon/css/styles.css">
    <link rel="stylesheet" href="../assets/theme/css/style.css">
    <link rel="preload" as="style" href="../assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .fitness-container {
            max-width: 900px;
            margin: 3rem auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2.5rem;
        }
        h1 {
            color: #c80d7d;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .lead {
            color: #555;
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .workout-card {
            background: #f8f9fa;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(200,13,125,0.07);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.3s;
        }
        .workout-card:hover {
            box-shadow: 0 8px 24px rgba(200,13,125,0.13);
        }
        .workout-title {
            color: #c80d7d;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.7rem;
        }
        .workout-desc {
            color: #444;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .workout-icon {
            font-size: 2.2rem;
            color: #c80d7d;
            margin-right: 0.7rem;
            vertical-align: middle;
        }
        @media (max-width: 600px) {
            .fitness-container { padding: 1rem; }
        }
    </style>
</head>
<body>
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
                        <img src="../assets/images/thrive_logo.png" alt="Mobirise" style="height: 5rem;">
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="profile-section">
                            <div class="profile-icon">
                                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                            </div>
                            <span style="font-weight: 500;">
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </span>
                        </div>
                        <a href="?logout=true" class="btn display-4" style="background-color: #e71f68; border-color: #e71f68; color: #fff;">Logout</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-primary display-4 dropdown-toggle" type="button" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Login
                            </button>
                            <div class="dropdown-menu" aria-labelledby="loginDropdown">
                                <div class="dropdown-header">
                                    <h6>Choose your role</h6>
                                </div>
                                <a class="dropdown-item" href="patient/patient_login.php">
                                    <i class="fas fa-user"></i>
                                    <span>Patient Login</span>
                                </a>
                                <a class="dropdown-item" href="doctor/doctor_login.php">
                                    <i class="fas fa-user-md"></i>
                                    <span>Doctor Login</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item signup-link" href="patient_signup.php">
                                    <i class="fas fa-user-plus"></i>
                                    <span>New User? Sign Up</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</section>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
    <div class="fitness-container">
        <h1><i class="fas fa-dumbbell"></i> Fitness & Exercise Plans</h1>
        <p class="lead">Discover routines and tips to help you stay active, healthy, and motivated—no matter your fitness level!</p>
        
        <div class="workout-card">
            <div class="workout-title"><i class="fas fa-walking workout-icon"></i>Beginner Full Body Routine</div>
            <div class="workout-desc">A simple plan for those just starting out. Focuses on all major muscle groups with bodyweight exercises.</div>
            <ul>
                <li>10 squats</li>
                <li>10 push-ups (knee or wall if needed)</li>
                <li>10 lunges (each leg)</li>
                <li>15-second plank</li>
                <li>Repeat 2-3 times</li>
            </ul>
        </div>
        
        <div class="workout-card">
            <div class="workout-title"><i class="fas fa-running workout-icon"></i>Cardio Blast</div>
            <div class="workout-desc">Boost your heart health and burn calories with this quick cardio circuit.</div>
            <ul>
                <li>30 seconds jumping jacks</li>
                <li>30 seconds high knees</li>
                <li>30 seconds mountain climbers</li>
                <li>30 seconds rest</li>
                <li>Repeat 3-5 times</li>
            </ul>
        </div>
        
        <div class="workout-card">
            <div class="workout-title"><i class="fas fa-child workout-icon"></i>Stretch & Flexibility</div>
            <div class="workout-desc">Improve your flexibility and reduce injury risk with these stretches.</div>
            <ul>
                <li>Neck rolls</li>
                <li>Shoulder stretches</li>
                <li>Hamstring stretch</li>
                <li>Quad stretch</li>
                <li>Hold each for 20-30 seconds</li>
            </ul>
        </div>
        
        <div class="workout-card">
            <div class="workout-title"><i class="fas fa-heartbeat workout-icon"></i>Wellness Tips</div>
            <div class="workout-desc">Remember: Stay hydrated, listen to your body, and rest when needed. Consistency is key!</div>
        </div>
    </div>
    
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<?php include_once '../includes/footer.php'; ?> 