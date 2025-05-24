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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Recipes | WeCare</title>
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
        .recipes-container {
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
        .recipe-card {
            background: #f8f9fa;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(200,13,125,0.07);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.3s;
        }
        .recipe-card:hover {
            box-shadow: 0 8px 24px rgba(200,13,125,0.13);
        }
        .recipe-title {
            color: #c80d7d;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.7rem;
        }
        .recipe-desc {
            color: #444;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .recipe-icon {
            font-size: 2.2rem;
            color: #c80d7d;
            margin-right: 0.7rem;
            vertical-align: middle;
        }
        .recipe-meta {
            display: flex;
            justify-content: space-between;
            color: #888;
            font-size: 0.9rem;
            margin: 1rem 0;
        }
        .recipe-tags {
            margin-top: 1rem;
        }
        .recipe-tag {
            background: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-right: 5px;
            color: #c80d7d;
            border: 1px solid #c80d7d;
        }
        @media (max-width: 600px) {
            .recipes-container { padding: 1rem; }
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
                    <a href="../index.php">
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
                        <a class="nav-link link text-black display-4" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4" href="../about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4" href="../contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4" href="../index.php#features1-n">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4" href="../body.php">Body Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link text-black display-4" href="../mind.php">Mind Care</a>
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
                                <a class="dropdown-item" href="../patient/patient_login.php">
                                    <i class="fas fa-user"></i>
                                    <span>Patient Login</span>
                                </a>
                                <a class="dropdown-item" href="../doctor/doctor_login.php">
                                    <i class="fas fa-user-md"></i>
                                    <span>Doctor Login</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item signup-link" href="../patient_signup.php">
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

<div class="recipes-container">
    <h1><i class="fas fa-utensils"></i> Healthy Recipes</h1>
    <p class="lead">Discover nutritious and delicious recipes to support your health and wellness goals!</p>
    
    <!-- Breakfast Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-sun"></i> Breakfast Delights
    </h2>
    
    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-egg recipe-icon"></i>Protein-Packed Overnight Oats</div>
        <div class="recipe-desc">Start your day with this nutritious and filling breakfast that's prepared the night before.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 10 mins | Cook: 0 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegetarian</span>
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Meal Prep</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-bread-slice recipe-icon"></i>Avocado Toast with Poached Egg</div>
        <div class="recipe-desc">A modern classic combining creamy avocado with perfectly poached eggs on whole grain toast.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Cook: 10 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Low Carb</span>
            <span class="recipe-tag">Quick Meal</span>
        </div>
    </div>

    <!-- Lunch Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-cloud-sun"></i> Energizing Lunches
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-seedling recipe-icon"></i>Quinoa Buddha Bowl</div>
        <div class="recipe-desc">A nutritious bowl packed with protein-rich quinoa, fresh vegetables, and a delicious tahini dressing.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 20 mins | Cook: 15 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegetarian</span>
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Gluten Free</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-leaf recipe-icon"></i>Mediterranean Salad</div>
        <div class="recipe-desc">Fresh Mediterranean salad with olives, feta cheese, and a light olive oil dressing.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Cook: 0 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegetarian</span>
            <span class="recipe-tag">Low Carb</span>
            <span class="recipe-tag">Mediterranean</span>
        </div>
    </div>

    <!-- Dinner Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-moon"></i> Wholesome Dinners
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-fish recipe-icon"></i>Grilled Salmon</div>
        <div class="recipe-desc">Healthy grilled salmon with lemon and herbs, served with steamed vegetables.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Cook: 20 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Omega-3</span>
            <span class="recipe-tag">Low Carb</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-drumstick-bite recipe-icon"></i>Baked Chicken with Vegetables</div>
        <div class="recipe-desc">Tender baked chicken with roasted seasonal vegetables and herbs.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 20 mins | Cook: 45 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Low Carb</span>
            <span class="recipe-tag">Family Meal</span>
        </div>
    </div>

    <!-- Snacks Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-cookie"></i> Healthy Snacks
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-apple-alt recipe-icon"></i>Energy Bites</div>
        <div class="recipe-desc">No-bake energy bites made with oats, nuts, and dried fruits for a quick energy boost.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Cook: 0 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegetarian</span>
            <span class="recipe-tag">No Bake</span>
            <span class="recipe-tag">Meal Prep</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-carrot recipe-icon"></i>Crunchy Vegetable Sticks</div>
        <div class="recipe-desc">Fresh vegetable sticks with a healthy hummus dip for a satisfying crunch.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 10 mins | Cook: 0 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegan</span>
            <span class="recipe-tag">Low Calorie</span>
            <span class="recipe-tag">Quick Snack</span>
        </div>
    </div>

    <!-- Special Diets Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-heart"></i> Special Diet Recipes
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-wheat recipe-icon"></i>Gluten-Free Pasta Primavera</div>
        <div class="recipe-desc">Colorful vegetable pasta made with gluten-free noodles and fresh seasonal vegetables.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 20 mins | Cook: 15 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Gluten Free</span>
            <span class="recipe-tag">Vegetarian</span>
            <span class="recipe-tag">Quick Meal</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-seedling recipe-icon"></i>Vegan Buddha Bowl</div>
        <div class="recipe-desc">A complete plant-based meal with grains, legumes, and roasted vegetables.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 25 mins | Cook: 20 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegan</span>
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Meal Prep</span>
        </div>
    </div>

    <!-- Healthy Tips Section -->
    <div class="recipe-card" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);">
        <div class="recipe-title"><i class="fas fa-lightbulb recipe-icon"></i>Healthy Eating Tips</div>
        <div class="recipe-desc">
            <ul style="list-style: none; padding-left: 0;">
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Plan your meals ahead of time</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Stay hydrated throughout the day</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Include protein in every meal</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Choose whole foods over processed ones</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Practice mindful eating</li>
            </ul>
        </div>
    </div>

    <!-- Smoothies & Drinks Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-glass-whiskey"></i> Healthy Smoothies & Drinks
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-blender recipe-icon"></i>Green Detox Smoothie</div>
        <div class="recipe-desc">A refreshing blend of spinach, apple, cucumber, and lemon for a natural detox boost.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 5 mins | Blend: 2 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegan</span>
            <span class="recipe-tag">Detox</span>
            <span class="recipe-tag">Quick</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-mug-hot recipe-icon"></i>Golden Turmeric Latte</div>
        <div class="recipe-desc">Anti-inflammatory drink with turmeric, ginger, and plant-based milk.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 5 mins | Cook: 5 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegan</span>
            <span class="recipe-tag">Anti-inflammatory</span>
            <span class="recipe-tag">Warm Drink</span>
        </div>
    </div>

    <!-- Desserts Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-ice-cream"></i> Healthy Desserts
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-cookie recipe-icon"></i>Chocolate Avocado Mousse</div>
        <div class="recipe-desc">Creamy chocolate mousse made with avocado, cacao, and natural sweeteners.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 10 mins | Chill: 2 hours</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Vegan</span>
            <span class="recipe-tag">No Bake</span>
            <span class="recipe-tag">Gluten Free</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-birthday-cake recipe-icon"></i>Protein Banana Bread</div>
        <div class="recipe-desc">Moist banana bread with added protein powder and natural sweeteners.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Bake: 45 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Gluten Free</span>
            <span class="recipe-tag">Meal Prep</span>
        </div>
    </div>

    <!-- Meal Prep Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-calendar-check"></i> Meal Prep Ideas
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-box recipe-icon"></i>Weekly Meal Prep Guide</div>
        <div class="recipe-desc">Complete guide for preparing a week's worth of healthy meals in advance.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 2 hours | Cook: 1 hour</span>
            <span><i class="fas fa-signal"></i> Advanced</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Meal Prep</span>
            <span class="recipe-tag">Time Saving</span>
            <span class="recipe-tag">Budget Friendly</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-utensils recipe-icon"></i>Freezer-Friendly Meals</div>
        <div class="recipe-desc">Collection of healthy meals that can be prepared and frozen for later use.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 3 hours | Cook: 2 hours</span>
            <span><i class="fas fa-signal"></i> Advanced</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Freezer Friendly</span>
            <span class="recipe-tag">Batch Cooking</span>
            <span class="recipe-tag">Time Saving</span>
        </div>
    </div>

    <!-- Seasonal Recipes Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-calendar-alt"></i> Seasonal Specialties
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-snowflake recipe-icon"></i>Winter Comfort Bowl</div>
        <div class="recipe-desc">Warming bowl with roasted root vegetables, grains, and hearty protein.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 20 mins | Cook: 40 mins</span>
            <span><i class="fas fa-signal"></i> Medium</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Seasonal</span>
            <span class="recipe-tag">Comfort Food</span>
            <span class="recipe-tag">High Protein</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-sun recipe-icon"></i>Summer Fresh Salad</div>
        <div class="recipe-desc">Light and refreshing salad with seasonal fruits and vegetables.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 15 mins | Cook: 0 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Seasonal</span>
            <span class="recipe-tag">Light</span>
            <span class="recipe-tag">Quick</span>
        </div>
    </div>

    <!-- Quick & Easy Section -->
    <h2 class="section-title" style="color: #c80d7d; margin: 2rem 0 1rem 0; font-size: 1.8rem;">
        <i class="fas fa-bolt"></i> Quick & Easy
    </h2>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-fire recipe-icon"></i>15-Minute Stir Fry</div>
        <div class="recipe-desc">Quick and healthy stir fry with your choice of protein and vegetables.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 5 mins | Cook: 10 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Quick</span>
            <span class="recipe-tag">High Protein</span>
            <span class="recipe-tag">Customizable</span>
        </div>
    </div>

    <div class="recipe-card">
        <div class="recipe-title"><i class="fas fa-mug-hot recipe-icon"></i>5-Minute Oatmeal Bowl</div>
        <div class="recipe-desc">Quick and nutritious oatmeal with customizable toppings.</div>
        <div class="recipe-meta">
            <span><i class="fas fa-clock"></i> Prep: 2 mins | Cook: 3 mins</span>
            <span><i class="fas fa-signal"></i> Easy</span>
        </div>
        <div class="recipe-tags">
            <span class="recipe-tag">Quick</span>
            <span class="recipe-tag">Breakfast</span>
            <span class="recipe-tag">Customizable</span>
        </div>
    </div>

    <!-- Nutrition Tips Section -->
    <div class="recipe-card" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);">
        <div class="recipe-title"><i class="fas fa-book-medical recipe-icon"></i>Nutrition Tips & Guidelines</div>
        <div class="recipe-desc">
            <ul style="list-style: none; padding-left: 0;">
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Balance your macronutrients (proteins, carbs, fats)</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Include a variety of colorful vegetables</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Choose whole grains over refined grains</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Stay hydrated with water and herbal teas</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Practice portion control</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Read food labels carefully</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Plan meals ahead of time</li>
                <li><i class="fas fa-check-circle" style="color: #c80d7d;"></i> Cook at home more often</li>
            </ul>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<?php include_once '../includes/footer.php'; ?> 