<?php
session_start();
require_once('../config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.0 403 Forbidden");
    exit("Access denied");
}

// Validate and sanitize the path
if (!isset($_GET['path']) || empty($_GET['path'])) {
    header("HTTP/1.0 400 Bad Request");
    exit("Invalid request");
}

$path = $_GET['path'];
$base_dir = dirname(__DIR__) . '/private/';

// Prevent directory traversal
if (strpos(realpath($base_dir . $path), realpath($base_dir)) !== 0) {
    header("HTTP/1.0 403 Forbidden");
    exit("Access denied");
}

$file_path = $base_dir . $path;

// Check if file exists and is readable
if (!file_exists($file_path) || !is_readable($file_path)) {
    header("HTTP/1.0 404 Not Found");
    exit("File not found");
}

// Get file information
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $file_path);
finfo_close($finfo);

// Only allow image files
$allowed_types = ['image/jpeg', 'image/png'];
if (!in_array($mime_type, $allowed_types)) {
    header("HTTP/1.0 403 Forbidden");
    exit("Invalid file type");
}

// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Set headers for image
header('Content-Type: ' . $mime_type);
header('Content-Length: ' . filesize($file_path));
header('Cache-Control: public, max-age=31536000');
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', filemtime($file_path)));

// Output image
readfile($file_path); 