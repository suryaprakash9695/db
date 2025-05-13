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
            const dropdown = document.querySelector('.notifications-dropdown');
            if (dropdown) {
                dropdown.innerHTML = '';
                if (data.notifications.length > 0) {
                    data.notifications.forEach(notification => {
                        const notificationItem = document.createElement('div');
                        notificationItem.className = 'notification-item';
                        notificationItem.setAttribute('data-notification-id', notification.notification_id);
                        notificationItem.innerHTML = `
                            <div class="notification-content">
                                <p>${notification.message}</p>
                                <small>${new Date(notification.created_at).toLocaleString()}</small>
                            </div>
                            <button onclick="markNotificationAsRead(${notification.notification_id})" class="mark-read-btn">
                                <i class="fas fa-check"></i>
                            </button>
                        `;
                        dropdown.appendChild(notificationItem);
                    });
                    dropdown.classList.add('show');
                } else {
                    dropdown.innerHTML = '<div class="no-notifications">No new notifications</div>';
                    dropdown.classList.add('show');
                }
            }
        }
    })
    .catch(error => console.error('Error fetching notifications:', error));
}

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
    const dropdown = document.querySelector('.notifications-dropdown');
    const bell = document.querySelector('.notification-bell');
    if (dropdown && !bell.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
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