<?php
session_start();

// Store user type for redirect
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Set success message in a new session
session_start();
$_SESSION['logout_message'] = "You have successfully logged out from this device.";

// Redirect based on user type
switch ($user_type) {
    case 'doctor':
        header("Location: doctor_login.php");
        break;
    case 'patient':
        header("Location: patient_login.php");
        break;
    case 'admin':
        header("Location: admin_login.php");
        break;
    default:
        header("Location: index.php");
        break;
}
exit; 