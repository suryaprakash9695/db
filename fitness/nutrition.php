<?php
// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nutrition Plans | WeCare Fitness</title>
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
        .nutrition-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .nutrition-section {
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
        .meal-plan {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .meal-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        .meal-card:hover {
            transform: translateY(-5px);
        }
        .meal-card h3 {
            color: #c80d7d;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .meal-card ul {
            list-style: none;
            padding: 0;
        }
        .meal-card li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }
        .meal-card li:before {
            content: "•";
            color: #c80d7d;
            position: absolute;
            left: 0;
        }
        .nutrition-tip {
            background: #fff3f8;
            border-left: 4px solid #c80d7d;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0 4px 4px 0;
        }
        .macro-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        .macro-card {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .macro-card i {
            font-size: 2rem;
            color: #c80d7d;
            margin-bottom: 0.5rem;
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
            .meal-plan {
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
                        <a class="nav-link active" href="nutrition.php">
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

<div class="nutrition-container">
    <!-- Macronutrients Section -->
    <div class="nutrition-section">
        <h2 class="section-title">
            <i class="fas fa-chart-pie"></i>Understanding Macronutrients
        </h2>
        <div class="macro-info">
            <div class="macro-card">
                <i class="fas fa-drumstick-bite"></i>
                <h3>Protein</h3>
                <p>Essential for muscle repair and growth</p>
                <p>Recommended: 1.6-2.2g per kg of body weight</p>
            </div>
            <div class="macro-card">
                <i class="fas fa-bread-slice"></i>
                <h3>Carbohydrates</h3>
                <p>Primary energy source for workouts</p>
                <p>Recommended: 45-65% of daily calories</p>
            </div>
            <div class="macro-card">
                <i class="fas fa-cheese"></i>
                <h3>Healthy Fats</h3>
                <p>Important for hormone production</p>
                <p>Recommended: 20-35% of daily calories</p>
            </div>
        </div>
    </div>

    <!-- Meal Plans Section -->
    <div class="nutrition-section">
        <h2 class="section-title">
            <i class="fas fa-utensils"></i>Sample Meal Plans
        </h2>
        <div class="meal-plan">
            <div class="meal-card">
                <h3>Breakfast Options</h3>
                <ul>
                    <li>Greek yogurt with berries and granola</li>
                    <li>Oatmeal with banana and nuts</li>
                    <li>Whole grain toast with avocado</li>
                    <li>Protein smoothie with spinach</li>
                </ul>
            </div>
            <div class="meal-card">
                <h3>Lunch Ideas</h3>
                <ul>
                    <li>Grilled chicken salad</li>
                    <li>Quinoa bowl with vegetables</li>
                    <li>Turkey and vegetable wrap</li>
                    <li>Lentil soup with whole grain bread</li>
                </ul>
            </div>
            <div class="meal-card">
                <h3>Dinner Suggestions</h3>
                <ul>
                    <li>Baked salmon with sweet potato</li>
                    <li>Lean beef stir-fry with brown rice</li>
                    <li>Vegetable curry with chickpeas</li>
                    <li>Grilled chicken with roasted vegetables</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Nutrition Tips Section -->
    <div class="nutrition-section">
        <h2 class="section-title">
            <i class="fas fa-lightbulb"></i>Nutrition Tips
        </h2>
        <div class="nutrition-tip">
            <h3>Stay Hydrated</h3>
            <p>Drink at least 8 glasses of water daily. Increase intake during workouts.</p>
        </div>
        <div class="nutrition-tip">
            <h3>Meal Timing</h3>
            <p>Eat a balanced meal 2-3 hours before exercise and refuel within 30 minutes after.</p>
        </div>
        <div class="nutrition-tip">
            <h3>Portion Control</h3>
            <p>Use your hand as a guide: palm for protein, fist for vegetables, cupped hand for carbs.</p>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 