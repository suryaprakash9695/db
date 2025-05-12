<?php
$host = 'localhost';
$dbname = 'wecare';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to store password (no encryption for now)
function hash_password($password) {
    return $password; // Return password as is
}

// Function to verify password (direct comparison for now)
function verify_password($password, $stored_password) {
    return $password === $stored_password; // Direct comparison
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Function to check if user is admin
function is_admin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

// Function to check if user is doctor
function is_doctor() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'doctor';
}

// Function to check if user is patient
function is_patient() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'patient';
}

// Function to redirect with message
function redirect_with_message($url, $message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $url");
    exit();
}
?> 