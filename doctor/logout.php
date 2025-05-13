<?php
session_start();

// Store the user type before clearing session
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Start a new session to store the logout message
session_start();
$_SESSION['logout_message'] = 'You have been successfully logged out.';

// Redirect based on user type
switch ($user_type) {
    case 'doctor':
        header("Location: doctor_login.php");
        break;
    case 'patient':
        header("Location: ../patient/patient_login.php");
        break;
    case 'admin':
        header("Location: ../admin/admin_login.php");
        break;
    default:
        header("Location: doctor_login.php");
}

exit; 