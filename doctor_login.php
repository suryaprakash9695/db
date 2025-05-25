<?php
session_start();
require_once 'includes/db_connect.php';

$error = '';
$success = '';

// Display success message from session if redirected from successful signup
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $con->prepare("SELECT * FROM doctors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctor = $result->fetch_assoc();
        $stmt->close();

        if ($doctor && verify_password($password, $doctor['password'])) {
            $_SESSION['user_id'] = $doctor['doctor_id'];
            $_SESSION['user_type'] = 'doctor';
            $_SESSION['user_name'] = $doctor['full_name'];
            
            header("Location: doctor_dashboard.php");
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    } catch(Exception $e) {
        $error = 'Login failed. Please try again.';
        // Log the error for debugging
        error_log("Login error: " . $e->getMessage());
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

    <title>WeCare Doctor Login</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-7 d-none d-lg-block text-center">
                <div style="font-size: 10rem; color: #3498db; margin-top: 50px;">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
            <div class="col-lg-5 col-md-10">
                <div class="card shadow" style="padding: 2.5rem 2rem; min-width: 380px; background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);">
                    <div class="card-header text-center" style="padding: 1.2rem 0;">
                        <h3 style="font-size: 2.4rem; margin-bottom: 0; font-family: 'Dancing Script', cursive; color: #3498db; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Welcome Doctor</h3>
                        <p style="color: #666; margin-top: 1rem; font-size: 1.1rem;">Login to your WeCare Doctor Portal</p>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group mb-4">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-outline-primary" style="
                                border: 2px solid #3498db;
                                color: #3498db;
                                font-weight: 600;
                                padding: 0.8rem 2rem;
                                border-radius: 12px;
                                transition: all 0.3s ease;
                                text-decoration: none;
                                width: 100%;
                                font-size: 1.2rem;
                                text-transform: uppercase;
                            " onmouseover="this.style.backgroundColor='#3498db'; this.style.color='white';"
                              onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3498db';">
                                Login
                            </button>
                        </form>
                        <div class="text-center mt-4">
                            <p>Don't have an account? Contact your Hospital Administrator.....</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
