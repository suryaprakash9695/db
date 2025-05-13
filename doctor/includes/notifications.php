<?php
// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    $notifications = [];
    $unread_count = 0;
} else {
    // Get notifications for the current doctor
    $doctor_id = $_SESSION['user_id'];
    $notifications_query = "SELECT * FROM notifications WHERE user_id = ? AND user_type = 'doctor' ORDER BY created_at DESC LIMIT 5";
    $stmt = $con->prepare($notifications_query);
    if (!$stmt) {
        error_log("Prepare failed: " . $con->error);
        $notifications = [];
    } else {
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $notifications_result = $stmt->get_result();
        $notifications = $notifications_result->fetch_all(MYSQLI_ASSOC);
    }

    // Count unread notifications
    $unread_query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND user_type = 'doctor' AND is_read = 0";
    $stmt = $con->prepare($unread_query);
    if (!$stmt) {
        error_log("Prepare failed: " . $con->error);
        $unread_count = 0;
    } else {
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $unread_result = $stmt->get_result();
        $unread_count = $unread_result->fetch_assoc()['count'];
    }
}
?>

<script>
function showNotifications() {
    const dropdown = document.querySelector('.notifications-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

function markAsRead(notificationId) {
    fetch('mark_notification_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ notification_id: notificationId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update notification badge
            const badge = document.querySelector('.notification-badge');
            const currentCount = parseInt(badge.textContent);
            if (currentCount > 0) {
                badge.textContent = currentCount - 1;
            }
            // Remove the notification from the dropdown
            const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notification) {
                notification.remove();
            }
        }
    });
}
</script>

<style>
.notifications-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    min-width: 300px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
}

.notification-item {
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.notification-item:hover {
    background: #f5f5f5;
}

.notification-item.unread {
    background: #f0f7ff;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e71f68;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    display: <?php echo $unread_count > 0 ? 'block' : 'none'; ?>;
}

.notification-bell {
    background: none;
    border: none;
    cursor: pointer;
    position: relative;
    padding: 10px;
}

.notification-bell i {
    font-size: 20px;
    color: #333;
}
</style>

<div class="notifications-dropdown">
    <?php if (empty($notifications)): ?>
        <div class="notification-item">No notifications</div>
    <?php else: ?>
        <?php foreach ($notifications as $notification): ?>
            <div class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>" 
                 data-notification-id="<?php echo $notification['id']; ?>"
                 onclick="markAsRead(<?php echo $notification['id']; ?>)">
                <div class="notification-content">
                    <?php echo htmlspecialchars($notification['message']); ?>
                </div>
                <div class="notification-time">
                    <?php echo date('M d, Y H:i', strtotime($notification['created_at'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.notifications-dropdown');
    const bell = document.querySelector('.notification-bell');
    
    if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script> 