<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Tracking | WeCare Fitness</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .progress-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .progress-section {
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
        }
        .stat-number {
            color: #c80d7d;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        .chart-container {
            position: relative;
            margin: 2rem 0;
            height: 300px;
        }
        .goal-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .goal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .goal-title {
            color: #333;
            font-size: 1.2rem;
            margin: 0;
        }
        .goal-progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            margin: 1rem 0;
        }
        .progress-bar {
            height: 100%;
            background: #c80d7d;
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        .goal-stats {
            display: flex;
            justify-content: space-between;
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
            .stats-grid {
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
                        <a class="nav-link active" href="progress.php">
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

<div class="progress-container">
    <!-- Overview Stats Section -->
    <div class="progress-section">
        <h2 class="section-title">
            <i class="fas fa-chart-bar"></i>Overview
        </h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">24</div>
                <div class="stat-label">Workouts Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12,450</div>
                <div class="stat-label">Calories Burned</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">18.5</div>
                <div class="stat-label">Hours Active</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">5</div>
                <div class="stat-label">Achievements</div>
            </div>
        </div>
    </div>

    <!-- Progress Charts Section -->
    <div class="progress-section">
        <h2 class="section-title">
            <i class="fas fa-chart-line"></i>Progress Charts
        </h2>
        <div class="chart-container">
            <canvas id="workoutChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="weightChart"></canvas>
        </div>
    </div>

    <!-- Goals Section -->
    <div class="progress-section">
        <h2 class="section-title">
            <i class="fas fa-bullseye"></i>Goals
        </h2>
        <div class="goal-card">
            <div class="goal-header">
                <h3 class="goal-title">Weekly Workouts</h3>
                <span>4/5</span>
            </div>
            <div class="goal-progress">
                <div class="progress-bar" style="width: 80%"></div>
            </div>
            <div class="goal-stats">
                <span>Goal: 5 workouts</span>
                <span>80% Complete</span>
            </div>
        </div>
        <div class="goal-card">
            <div class="goal-header">
                <h3 class="goal-title">Daily Steps</h3>
                <span>8,500/10,000</span>
            </div>
            <div class="goal-progress">
                <div class="progress-bar" style="width: 85%"></div>
            </div>
            <div class="goal-stats">
                <span>Goal: 10,000 steps</span>
                <span>85% Complete</span>
            </div>
        </div>
        <div class="goal-card">
            <div class="goal-header">
                <h3 class="goal-title">Water Intake</h3>
                <span>1.8/2.5L</span>
            </div>
            <div class="goal-progress">
                <div class="progress-bar" style="width: 72%"></div>
            </div>
            <div class="goal-stats">
                <span>Goal: 2.5L</span>
                <span>72% Complete</span>
            </div>
        </div>
    </div>
</div>

<script>
// Workout Chart
const workoutCtx = document.getElementById('workoutChart').getContext('2d');
new Chart(workoutCtx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
            label: 'Workouts per Week',
            data: [3, 4, 5, 4],
            borderColor: '#c80d7d',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Weight Chart
const weightCtx = document.getElementById('weightChart').getContext('2d');
new Chart(weightCtx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
            label: 'Weight (kg)',
            data: [75, 74.5, 74, 73.5],
            borderColor: '#c80d7d',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php include_once '../includes/footer.php'; ?> 