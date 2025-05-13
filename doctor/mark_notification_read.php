<?php
session_start();
require_once(__DIR__ . '/../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get the notification ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$notification_id = $data['notification_id'] ?? null;

if (!$notification_id) {
    echo json_encode(['success' => false, 'message' => 'Notification ID is required']);
    exit;
}

// Update the notification as read
$update_query = "UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND user_type = 'doctor'";
$stmt = $con->prepare($update_query);
$stmt->bind_param("ii", $notification_id, $_SESSION['user_id']);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to mark notification as read']);
}
?> 