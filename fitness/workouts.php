<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workouts | WeCare Fitness</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="../assets/tether/tether.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../assets/dropdown/css/style.css">
    <link rel="stylesheet" href="../assets/socicon/css/styles.css">
    <link rel="stylesheet" href="../assets/theme/css/style.css">
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
        .workouts-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .workout-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            color: #c80d7d;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 1rem;
            font-size: 2rem;
        }
        .workout-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .workout-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        .workout-card:hover {
            transform: translateY(-5px);
        }
        .workout-card h3 {
            color: #c80d7d;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .workout-card p {
            color: #666;
            margin-bottom: 1rem;
        }
        .workout-details {
            margin-top: 1rem;
        }
        .workout-details ul {
            list-style: none;
            padding: 0;
        }
        .workout-details li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }
        .workout-details li:before {
            content: "•";
            color: #c80d7d;
            position: absolute;
            left: 0;
        }
        .difficulty-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .difficulty-beginner {
            background: #e3f2fd;
            color: #1976d2;
        }
        .difficulty-intermediate {
            background: #fff3e0;
            color: #f57c00;
        }
        .difficulty-advanced {
            background: #fce4ec;
            color: #c2185b;
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
        @media (max-width: 768px) {
            .workout-grid {
                grid-template-columns: 1fr;
            }
            .fitness-nav .nav-link {
                margin: 0.25rem 0;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">WeCare</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../body-care.php">Body Care</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../mind-care.php">Mind Care</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Fitness Navigation -->
<nav class="fitness-nav">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="workouts.php">
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

<div class="workouts-container">
    <!-- Strength Training Section -->
    <div class="workout-section">
        <h2 class="section-title">
            <i class="fas fa-dumbbell"></i>Strength Training
        </h2>
        <div class="workout-grid">
            <div class="workout-card">
                <span class="difficulty-badge difficulty-beginner">Beginner</span>
                <h3>Full Body Strength</h3>
                <p>A complete workout targeting all major muscle groups.</p>
                <div class="workout-details">
                    <ul>
                        <li>3 sets of 12 squats</li>
                        <li>3 sets of 10 push-ups</li>
                        <li>3 sets of 12 lunges</li>
                        <li>3 sets of 30s planks</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                <h3>Upper Body Focus</h3>
                <p>Build strength in your arms, chest, and back.</p>
                <div class="workout-details">
                    <ul>
                        <li>4 sets of 10 bench presses</li>
                        <li>4 sets of 12 rows</li>
                        <li>3 sets of 10 shoulder presses</li>
                        <li>3 sets of 15 bicep curls</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-advanced">Advanced</span>
                <h3>Power Lifting</h3>
                <p>Focus on compound movements for maximum strength.</p>
                <div class="workout-details">
                    <ul>
                        <li>5 sets of 5 deadlifts</li>
                        <li>5 sets of 5 squats</li>
                        <li>5 sets of 5 bench presses</li>
                        <li>3 sets of 8 overhead presses</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Cardio Section -->
    <div class="workout-section">
        <h2 class="section-title">
            <i class="fas fa-heartbeat"></i>Cardio Workouts
        </h2>
        <div class="workout-grid">
            <div class="workout-card">
                <span class="difficulty-badge difficulty-beginner">Beginner</span>
                <h3>Walking Program</h3>
                <p>Start your cardio journey with this gentle walking routine.</p>
                <div class="workout-details">
                    <ul>
                        <li>5-minute warm-up walk</li>
                        <li>20 minutes steady walking</li>
                        <li>5-minute cool-down walk</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                <h3>HIIT Circuit</h3>
                <p>High-intensity interval training for maximum calorie burn.</p>
                <div class="workout-details">
                    <ul>
                        <li>30s high knees</li>
                        <li>30s rest</li>
                        <li>30s jumping jacks</li>
                        <li>30s rest</li>
                        <li>Repeat 8 times</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-advanced">Advanced</span>
                <h3>Tabata Training</h3>
                <p>Intense 4-minute workout intervals.</p>
                <div class="workout-details">
                    <ul>
                        <li>20s all-out effort</li>
                        <li>10s rest</li>
                        <li>Repeat 8 times</li>
                        <li>Rest 1 minute</li>
                        <li>Complete 4 rounds</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Flexibility Section -->
    <div class="workout-section">
        <h2 class="section-title">
            <i class="fas fa-child"></i>Flexibility & Mobility
        </h2>
        <div class="workout-grid">
            <div class="workout-card">
                <span class="difficulty-badge difficulty-beginner">Beginner</span>
                <h3>Basic Stretching</h3>
                <p>Essential stretches for daily flexibility.</p>
                <div class="workout-details">
                    <ul>
                        <li>Neck rolls (30s each direction)</li>
                        <li>Shoulder stretches (30s each)</li>
                        <li>Hamstring stretch (30s each leg)</li>
                        <li>Quad stretch (30s each leg)</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                <h3>Dynamic Stretching</h3>
                <p>Active movements to improve range of motion.</p>
                <div class="workout-details">
                    <ul>
                        <li>Arm circles (30s each direction)</li>
                        <li>Leg swings (30s each leg)</li>
                        <li>Hip circles (30s each direction)</li>
                        <li>Walking knee hugs (10 each leg)</li>
                    </ul>
                </div>
            </div>
            <div class="workout-card">
                <span class="difficulty-badge difficulty-advanced">Advanced</span>
                <h3>Yoga Flow</h3>
                <p>Advanced flexibility and balance sequence.</p>
                <div class="workout-details">
                    <ul>
                        <li>Sun salutations (5 rounds)</li>
                        <li>Warrior poses (30s each)</li>
                        <li>Balance poses (30s each)</li>
                        <li>Deep stretches (1 min each)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 