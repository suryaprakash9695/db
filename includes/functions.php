<?php
/**
 * Common functions used across the application
 */

/**
 * Verify password against hash
 * @param string $password The password to verify
 * @param string $hash The hash to verify against
 * @return bool True if password matches hash, false otherwise
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Hash a password
 * @param string $password The password to hash
 * @return string The hashed password
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Generate a random token
 * @param int $length Length of the token
 * @return string The generated token
 */
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Sanitize input data
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Format date to display format
 * @param string $date The date to format
 * @param string $format The format to use
 * @return string The formatted date
 */
function format_date($date, $format = 'F d, Y') {
    return date($format, strtotime($date));
}

/**
 * Format time to display format
 * @param string $time The time to format
 * @param string $format The format to use
 * @return string The formatted time
 */
function format_time($time, $format = 'h:i A') {
    return date($format, strtotime($time));
}

/**
 * Check if user is logged in
 * @param string $type The type of user to check
 * @return bool True if user is logged in, false otherwise
 */
function is_logged_in($type = null) {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    if ($type !== null && $_SESSION['user_type'] !== $type) {
        return false;
    }
    
    return true;
}

/**
 * Redirect with message
 * @param string $url The URL to redirect to
 * @param string $message The message to display
 * @param string $type The type of message (success, error, warning, info)
 */
function redirect_with_message($url, $message, $type = 'success') {
    $_SESSION[$type . '_message'] = $message;
    header("Location: $url");
    exit;
}

/**
 * Display message and clear it
 * @param string $type The type of message (success, error, warning, info)
 * @return string|null The message if exists, null otherwise
 */
function get_message($type = 'success') {
    $message = isset($_SESSION[$type . '_message']) ? $_SESSION[$type . '_message'] : null;
    unset($_SESSION[$type . '_message']);
    return $message;
} 