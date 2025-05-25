<?php
session_start();
require_once 'includes/db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize_input($_POST['fullname']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            // Check if email already exists
            $stmt = $con->prepare("SELECT COUNT(*) FROM patients WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $error = 'Email already registered';
            } else {
                // Insert new patient
                $hashed_password = hash_password($password);
                $stmt = $con->prepare("INSERT INTO patients (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $full_name, $email, $phone, $hashed_password);
                $stmt->execute();
                $stmt->close();
                
                // Redirect to login page after successful registration
                $_SESSION['success_message'] = 'Registration successful! You can now login.';
                header("Location: patient_login.php");
                exit;
            }
        } catch(Exception $e) {
            $error = 'Registration failed. Please try again.';
            // Log the error for debugging
            error_log("Registration error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">

    <title>WeCare Patient Signup</title>
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
            background-color: #fff;
            transform: translateY(-2px);
        }
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.7rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            display: block;
            padding-left: 0.5rem;
        }
        .form-group:hover label {
            color: #3498db;
            transform: translateX(5px);
        }
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.15);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #2980b9);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.2);
        }
        .card-header {
            border-bottom: 2px solid rgba(52, 152, 219, 0.1);
            background: transparent;
            padding: 2rem 0 1.5rem;
        }
        .signup-btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1.2rem;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #3498db, #2980b9);
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
            color: white;
            width: 100%;
        }
        .signup-btn:hover {
            background-color: #2980b9 !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
            color: white;
            text-decoration: none;
        }
        .signup-btn:active {
            transform: translateY(-1px);
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .alert {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            font-weight: 500;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #dc2626;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #16a34a;
        }
        @media (max-width: 991.98px) {
            .container {
                padding: 0 20px;
            }
            .card {
                min-width: 100% !important;
                margin: 0 15px;
            }
            .card-header h3 {
                font-size: 2rem !important;
            }
            .form-group label {
                font-size: 1.2rem !important;
            }
            .form-control {
                font-size: 1.1rem !important;
                padding: 1rem 1.2rem !important;
            }
            .btn {
                font-size: 1.3rem !important;
                padding: 1rem 0 !important;
            }
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container" style="margin-top: 60px;">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-7 d-none d-lg-block text-center">
            <img src="assets/images/consult-626x417.jpeg" alt="Patient Signup" class="img-fluid rounded shadow" style="max-width: 95%; min-height: 450px; object-fit: cover;">
        </div>
        <div class="col-lg-5 col-md-10">
            <div class="card shadow" style="padding: 2.5rem 2rem; min-width: 380px; background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);">
                <div class="card-header text-center" style="padding: 1.2rem 0;">
                    <h3 style="font-size: 2.4rem; margin-bottom: 0; font-family: 'Dancing Script', cursive; color: #3498db; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Join WeCare</h3>
                    <p style="color: #666; margin-top: 1rem; font-size: 1.1rem;">Create your account to get started</p>
                </div>
                <div class="card-body">
                    <?php
                    // Display success message from session if redirected from successful signup
                    if (isset($_SESSION['success_message'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']); // Clear the message
                    }
                    ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="form-group mb-4">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                        <button type="submit" class="signup-btn">Create Account</button>
                    </form>
                    <div class="mt-4 text-center">
                        <p style="color: #666; font-size: 1.1rem; margin-bottom: 1rem;">Already have an account?</p>
                        <a href="patient_login.php" class="btn btn-outline-primary" style="
                            border: 2px solid #3498db;
                            color: #3498db;
                            font-weight: 600;
                            padding: 0.8rem 2rem;
                            border-radius: 12px;
                            transition: all 0.3s ease;
                            text-decoration: none;
                            display: inline-block;
                        " onmouseover="this.style.backgroundColor='#3498db'; this.style.color='white';"
                          onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3498db';">
                            Login Here
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <a href="https://mobirise.site/e"></a>
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/tether/tether.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>
    <script src="assets/parallax/jarallax.min.js"></script>
    <script src="assets/mbr-tabs/mbr-tabs.js"></script>
    <script src="assets/dropdown/js/nav-dropdown.js"></script>
    <script src="assets/dropdown/js/navbar-dropdown.js"></script>
    <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="assets/theme/js/script.js"></script>

<?php include 'includes/footer.php'; ?>

</body>

</html>