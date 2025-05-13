<?php
require_once('config.php');

function getUnreadNotifications($userId, $userType) {
    global $con;
    try {
        $stmt = $con->prepare("SELECT * FROM notifications 
                              WHERE user_id = ? AND user_type = ? AND is_read = 0 
                              ORDER BY created_at DESC");
        $stmt->bind_param("is", $userId, $userType);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching notifications: " . $e->getMessage());
        return [];
    }
}

function markNotificationAsRead($notificationId) {
    global $con;
    try {
        $stmt = $con->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = ?");
        $stmt->bind_param("i", $notificationId);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error marking notification as read: " . $e->getMessage());
        return false;
    }
}

function createNotification($userId, $userType, $message) {
    global $con;
    try {
        $stmt = $con->prepare("INSERT INTO notifications (user_id, user_type, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $userType, $message);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error creating notification: " . $e->getMessage());
        return false;
    }
}

// AJAX handler for marking notifications as read
if (isset($_POST['action']) && $_POST['action'] === 'mark_read') {
    header('Content-Type: application/json');
    if (!isset($_POST['notification_id'])) {
        echo json_encode(['success' => false, 'message' => 'Notification ID is required']);
        exit;
    }
    
    $notificationId = $_POST['notification_id'];
    $success = markNotificationAsRead($notificationId);
    echo json_encode(['success' => $success]);
    exit;
}

// AJAX handler for getting unread notifications
if (isset($_POST['action']) && $_POST['action'] === 'get_notifications') {
    header('Content-Type: application/json');
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }
    
    $notifications = getUnreadNotifications($_SESSION['user_id'], $_SESSION['user_type']);
    echo json_encode(['success' => true, 'notifications' => $notifications]);
    exit;
}
?> 