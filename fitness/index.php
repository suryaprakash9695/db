<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
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
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/tether/tether.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/smoothscroll/smooth-scroll.js"></script>
    <script src="../assets/dropdown/js/script.min.js"></script>
    <script src="../assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="../assets/theme/js/script.js"></script>
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
        /* Fitness Navigation Styles */
        .fitness-nav {
            background: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 80px;
        }
        .fitness-nav .nav-link {
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .fitness-nav .nav-link:hover,
        .fitness-nav .nav-link.active {
            background: #c80d7d;
            color: #fff;
        }
        .fitness-nav .nav-link i {
            margin-right: 0.5rem;
        }
        @media (max-width: 600px) {
            .fitness-container { padding: 1rem; }
            .fitness-nav .nav-link {
                margin: 0.25rem 0;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<!-- Fitness Navigation -->
<nav class="fitness-nav">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="workouts.php">
                            <i class="fas fa-dumbbell"></i>Workouts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nutrition.php">
                            <i class="fas fa-apple-alt"></i>Nutrition
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="progress.php">
                            <i class="fas fa-chart-line"></i>Progress
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="community.php">
                            <i class="fas fa-users"></i>Community
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="resources.php">
                            <i class="fas fa-book"></i>Resources
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

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

<?php include_once '../includes/footer.php'; ?> 