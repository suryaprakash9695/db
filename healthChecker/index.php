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
    <title>Physical Health Diagnosis | WeCare</title>
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
        .diagnosis-container {
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
        .diagnosis-card {
            background: #f8f9fa;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(200,13,125,0.07);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.3s;
        }
        .diagnosis-card:hover {
            box-shadow: 0 8px 24px rgba(200,13,125,0.13);
        }
        .diagnosis-title {
            color: #c80d7d;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.7rem;
        }
        .diagnosis-desc {
            color: #444;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .diagnosis-icon {
            font-size: 2.2rem;
            color: #c80d7d;
            margin-right: 0.7rem;
            vertical-align: middle;
        }
        .symptom-list {
            list-style: none;
            padding-left: 0;
            margin-top: 1rem;
        }
        .symptom-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .symptom-list li:last-child {
            border-bottom: none;
        }
        .btn-diagnose {
            background: #c80d7d;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-diagnose:hover {
            background: #a00a63;
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .diagnosis-container { padding: 1rem; }
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

<div class="diagnosis-container">
    <h1><i class="fas fa-stethoscope"></i> Physical Health Diagnosis</h1>
    <p class="lead">Get a preliminary assessment of your symptoms and understand potential health conditions.</p>
    
    <div class="diagnosis-card">
        <div class="diagnosis-title"><i class="fas fa-head-side-cough diagnosis-icon"></i>Respiratory Symptoms</div>
        <div class="diagnosis-desc">Check for common respiratory conditions and get guidance on when to seek medical attention.</div>
        <ul class="symptom-list">
            <li>Cough (dry or with phlegm)</li>
            <li>Shortness of breath</li>
            <li>Chest pain or tightness</li>
            <li>Wheezing or whistling sound</li>
        </ul>
        <button class="btn btn-diagnose mt-3">Start Diagnosis</button>
    </div>
    
    <div class="diagnosis-card">
        <div class="diagnosis-title"><i class="fas fa-brain diagnosis-icon"></i>Neurological Symptoms</div>
        <div class="diagnosis-desc">Assess symptoms related to the nervous system and brain function.</div>
        <ul class="symptom-list">
            <li>Headaches or migraines</li>
            <li>Dizziness or vertigo</li>
            <li>Memory problems</li>
            <li>Numbness or tingling</li>
        </ul>
        <button class="btn btn-diagnose mt-3">Start Diagnosis</button>
    </div>
    
    <div class="diagnosis-card">
        <div class="diagnosis-title"><i class="fas fa-heartbeat diagnosis-icon"></i>Cardiovascular Symptoms</div>
        <div class="diagnosis-desc">Evaluate symptoms related to heart and blood vessel health.</div>
        <ul class="symptom-list">
            <li>Chest pain or discomfort</li>
            <li>Irregular heartbeat</li>
            <li>High blood pressure</li>
            <li>Swelling in legs or ankles</li>
        </ul>
        <button class="btn btn-diagnose mt-3">Start Diagnosis</button>
    </div>
    
    <div class="diagnosis-card">
        <div class="diagnosis-title"><i class="fas fa-bone diagnosis-icon"></i>Musculoskeletal Symptoms</div>
        <div class="diagnosis-desc">Check for issues related to muscles, bones, and joints.</div>
        <ul class="symptom-list">
            <li>Joint pain or stiffness</li>
            <li>Muscle weakness</li>
            <li>Back pain</li>
            <li>Limited range of motion</li>
        </ul>
        <button class="btn btn-diagnose mt-3">Start Diagnosis</button>
    </div>

    <div class="diagnosis-card">
        <div class="diagnosis-title"><i class="fas fa-exclamation-triangle diagnosis-icon"></i>Important Notice</div>
        <div class="diagnosis-desc">
            <p>This tool is for preliminary assessment only and should not replace professional medical advice. Always consult with a healthcare provider for proper diagnosis and treatment.</p>
            <p class="mt-3"><strong>Emergency Warning:</strong> If you're experiencing severe symptoms like chest pain, difficulty breathing, or sudden severe pain, seek immediate medical attention.</p>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<?php include_once '../includes/footer.php'; ?>

<script>
    // Add click handlers for diagnosis buttons
    document.querySelectorAll('.btn-diagnose').forEach(button => {
        button.addEventListener('click', function() {
            const category = this.closest('.diagnosis-card').querySelector('.diagnosis-title').textContent.trim();
            window.location.href = `diagnosis.php?category=${encodeURIComponent(category)}`;
        });
    });
</script>
</body>
</html> 