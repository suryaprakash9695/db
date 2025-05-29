<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness Resources | WeCare Fitness</title>
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
        .resources-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .resources-section {
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
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .resource-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        .resource-card:hover {
            transform: translateY(-5px);
        }
        .resource-card h3 {
            color: #c80d7d;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .resource-card p {
            color: #666;
            margin-bottom: 1rem;
        }
        .resource-link {
            display: inline-flex;
            align-items: center;
            color: #c80d7d;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .resource-link i {
            margin-left: 0.5rem;
        }
        .resource-link:hover {
            color: #a00a65;
        }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .video-card {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .video-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .video-info {
            padding: 1rem;
            background: #fff;
        }
        .video-info h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .video-info p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
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
            .resource-grid,
            .video-grid {
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
                        <a class="nav-link active" href="resources.php">
                            <i class="fas fa-book"></i>Resources
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="resources-container">
    <!-- Educational Articles Section -->
    <div class="resources-section">
        <h2 class="section-title">
            <i class="fas fa-book-open"></i>Educational Articles
        </h2>
        <div class="resource-grid">
            <div class="resource-card">
                <h3>Understanding Muscle Growth</h3>
                <p>Learn about the science behind muscle hypertrophy and how to optimize your training for maximum gains.</p>
                <a href="#" class="resource-link">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="resource-card">
                <h3>Nutrition Fundamentals</h3>
                <p>A comprehensive guide to understanding macronutrients, micronutrients, and their role in fitness.</p>
                <a href="#" class="resource-link">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="resource-card">
                <h3>Recovery Strategies</h3>
                <p>Essential techniques for proper recovery, including stretching, foam rolling, and rest protocols.</p>
                <a href="#" class="resource-link">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Video Tutorials Section -->
    <div class="resources-section">
        <h2 class="section-title">
            <i class="fas fa-video"></i>Video Tutorials
        </h2>
        <div class="video-grid">
            <div class="video-card">
                <img src="https://via.placeholder.com/400x200" alt="Video Thumbnail" class="video-thumbnail">
                <div class="video-info">
                    <h3>Proper Form: Squats</h3>
                    <p>Learn the correct technique for performing squats safely and effectively.</p>
                </div>
            </div>
            <div class="video-card">
                <img src="https://via.placeholder.com/400x200" alt="Video Thumbnail" class="video-thumbnail">
                <div class="video-info">
                    <h3>HIIT Workout Guide</h3>
                    <p>Complete guide to High-Intensity Interval Training for maximum results.</p>
                </div>
            </div>
            <div class="video-card">
                <img src="https://via.placeholder.com/400x200" alt="Video Thumbnail" class="video-thumbnail">
                <div class="video-info">
                    <h3>Mobility Exercises</h3>
                    <p>Essential mobility drills to improve flexibility and prevent injuries.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Downloadable Resources Section -->
    <div class="resources-section">
        <h2 class="section-title">
            <i class="fas fa-download"></i>Downloadable Resources
        </h2>
        <div class="resource-grid">
            <div class="resource-card">
                <h3>Workout Planner</h3>
                <p>Printable workout planner to track your exercises, sets, and reps.</p>
                <a href="#" class="resource-link">Download PDF <i class="fas fa-download"></i></a>
            </div>
            <div class="resource-card">
                <h3>Meal Planning Template</h3>
                <p>Weekly meal planning template with portion guidelines and shopping list.</p>
                <a href="#" class="resource-link">Download PDF <i class="fas fa-download"></i></a>
            </div>
            <div class="resource-card">
                <h3>Progress Tracker</h3>
                <p>Comprehensive progress tracking sheet for measurements and goals.</p>
                <a href="#" class="resource-link">Download PDF <i class="fas fa-download"></i></a>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 