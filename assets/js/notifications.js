// Function to update notification count
function updateNotificationCount() {
    fetch('../includes/notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_notifications'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationBadge = document.querySelector('.notification-badge');
            if (notificationBadge) {
                if (data.notifications.length > 0) {
                    notificationBadge.textContent = data.notifications.length;
                    notificationBadge.style.display = 'block';
                } else {
                    notificationBadge.style.display = 'none';
                }
            }
        }
    })
    .catch(error => console.error('Error fetching notifications:', error));
}

// Function to mark notification as read
function markNotificationAsRead(notificationId) {
    fetch('../includes/notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=mark_read&notification_id=${notificationId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateNotificationCount();
            // Hide the notification item after marking as read
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.remove();
            }
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

// Function to show notifications dropdown
function showNotifications() {
    const dropdown = document.querySelector('.notifications-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Close notifications dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.notifications-dropdown');
    const bell = document.querySelector('.notification-bell');
    
    if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

// Update notifications every 30 seconds
setInterval(updateNotificationCount, 30000);

// Initial update
document.addEventListener('DOMContentLoaded', () => {
    updateNotificationCount();
    
    // Add click event listener to notification bell
    const notificationBell = document.querySelector('.notification-bell');
    if (notificationBell) {
        notificationBell.addEventListener('click', (event) => {
            event.stopPropagation();
            showNotifications();
        });
    }
}); 