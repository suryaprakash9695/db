<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness Community | WeCare Fitness</title>
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
        .community-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .community-section {
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
        .post-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }
        .post-info h3 {
            color: #333;
            font-size: 1.1rem;
            margin: 0;
        }
        .post-info p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }
        .post-content {
            margin-bottom: 1rem;
        }
        .post-actions {
            display: flex;
            gap: 1rem;
            color: #666;
        }
        .post-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .post-action:hover {
            color: #c80d7d;
        }
        .event-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #c80d7d;
        }
        .event-date {
            color: #c80d7d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .event-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .event-details {
            color: #666;
            font-size: 0.9rem;
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
            .post-actions {
                flex-wrap: wrap;
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
                        <a class="nav-link active" href="community.php">
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

<div class="community-container">
    <!-- Community Posts Section -->
    <div class="community-section">
        <h2 class="section-title">
            <i class="fas fa-comments"></i>Community Posts
        </h2>
        <div class="post-card">
            <div class="post-header">
                <img src="https://via.placeholder.com/50" alt="User Avatar" class="post-avatar">
                <div class="post-info">
                    <h3>Sarah Johnson</h3>
                    <p>2 hours ago</p>
                </div>
            </div>
            <div class="post-content">
                <p>Just completed my first 10K run! 🏃‍♀️ Feeling amazing and proud of my progress. Who else is training for a race?</p>
            </div>
            <div class="post-actions">
                <div class="post-action">
                    <i class="fas fa-heart"></i>
                    <span>24</span>
                </div>
                <div class="post-action">
                    <i class="fas fa-comment"></i>
                    <span>8</span>
                </div>
                <div class="post-action">
                    <i class="fas fa-share"></i>
                    <span>Share</span>
                </div>
            </div>
        </div>
        <div class="post-card">
            <div class="post-header">
                <img src="https://via.placeholder.com/50" alt="User Avatar" class="post-avatar">
                <div class="post-info">
                    <h3>Mike Chen</h3>
                    <p>5 hours ago</p>
                </div>
            </div>
            <div class="post-content">
                <p>Looking for a workout buddy in the downtown area. I usually train at 6 AM. Anyone interested?</p>
            </div>
            <div class="post-actions">
                <div class="post-action">
                    <i class="fas fa-heart"></i>
                    <span>12</span>
                </div>
                <div class="post-action">
                    <i class="fas fa-comment"></i>
                    <span>15</span>
                </div>
                <div class="post-action">
                    <i class="fas fa-share"></i>
                    <span>Share</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="community-section">
        <h2 class="section-title">
            <i class="fas fa-calendar-alt"></i>Upcoming Events
        </h2>
        <div class="event-card">
            <div class="event-date">March 15, 2024</div>
            <h3 class="event-title">Group HIIT Session</h3>
            <p class="event-details">
                <i class="fas fa-map-marker-alt"></i> Downtown Fitness Center<br>
                <i class="fas fa-clock"></i> 9:00 AM - 10:30 AM<br>
                <i class="fas fa-users"></i> 12 spots remaining
            </p>
        </div>
        <div class="event-card">
            <div class="event-date">March 20, 2024</div>
            <h3 class="event-title">Nutrition Workshop</h3>
            <p class="event-details">
                <i class="fas fa-map-marker-alt"></i> Community Center<br>
                <i class="fas fa-clock"></i> 6:00 PM - 7:30 PM<br>
                <i class="fas fa-users"></i> 8 spots remaining
            </p>
        </div>
    </div>

    <!-- Community Challenges Section -->
    <div class="community-section">
        <h2 class="section-title">
            <i class="fas fa-trophy"></i>Active Challenges
        </h2>
        <div class="post-card">
            <h3>30-Day Push-up Challenge</h3>
            <p>Join 156 members in this month's push-up challenge. Start with 10 push-ups and increase by 5 each day!</p>
            <div class="post-actions">
                <div class="post-action">
                    <i class="fas fa-users"></i>
                    <span>156 participants</span>
                </div>
                <div class="post-action">
                    <i class="fas fa-calendar-check"></i>
                    <span>Day 12</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 