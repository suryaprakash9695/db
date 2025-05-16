<?php
session_start();
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db_connect.php';

// Check if user is already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'patient') {
    header("Location: dashboard.php");
    exit;
}

// Get logout message if exists
$logout_message = isset($_SESSION['logout_message']) ? $_SESSION['logout_message'] : '';
unset($_SESSION['logout_message']); // Clear the message after displaying

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
    } else {
        // Check if patient exists
        $query = "SELECT * FROM patients WHERE email = ?";
        $result = execute_query($query, [$email], 's');
        
        if ($result->num_rows === 1) {
            $patient = $result->fetch_assoc();
            
            // Verify password
            if ($password === $patient['password'] || verify_password($password, $patient['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $patient['patient_id'];
                $_SESSION['user_type'] = 'patient';
                $_SESSION['full_name'] = $patient['full_name'];
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password";
            }
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 1000px;
            max-width: 100%;
            display: flex;
            min-height: 600px;
        }

        .login-image {
            flex: 1;
            background: url('../assets/images/patient-login.jpg') center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: white;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(52, 152, 219, 0.8);
        }

        .login-image-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .login-image-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .login-image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .login-form {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .login-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-login {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 0.75rem;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(45deg, #2980b9, #3498db);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
            padding: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
        }

        .signup-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .form-control::placeholder {
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .form-control:focus::placeholder {
            color: #6c757d;
        }

        .form-group label {
            transition: all 0.3s ease;
        }

        .form-group:hover label {
            color: #3498db;
        }

        @media (max-width: 991px) {
            .login-container {
                flex-direction: column;
                width: 100%;
                max-width: 500px;
            }

            .login-image {
                display: none;
            }

            .login-form {
                padding: 2rem;
            }
        }

        @media (max-width: 576px) {
            .login-form {
                padding: 1.5rem;
            }

            .login-header h2 {
                font-size: 1.75rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn-login {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="login-image-content">
                <h2>Welcome Back!</h2>
                <p>Access your healthcare dashboard and manage your appointments</p>
            </div>
        </div>
        <div class="login-form">
            <div class="login-header">
                <h2>Patient Login</h2>
                <p>Welcome back! Please login to your account.</p>
            </div>

            <?php if ($logout_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($logout_message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php 
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-login">Login to Your Account</button>
            </form>

            <div class="signup-link">
                Don't have an account? <a href="../patient_signup.php">Create Account</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>