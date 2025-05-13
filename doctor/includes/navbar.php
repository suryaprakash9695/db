<?php
// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: ../doctor_login.php");
    exit;
}

// Get unread notifications count
$stmt = $con->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND user_type = 'doctor' AND is_read = 0");
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$unread_count = $stmt->get_result()->fetch_assoc()['count'];
?>

<style>
    :root {
        --sidebar-width: 250px;
        --sidebar-bg: #2c3e50;
        --sidebar-hover: #34495e;
        --sidebar-active: #3498db;
        --text-light: #ecf0f1;
        --text-muted: #95a5a6;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--sidebar-bg);
        color: var(--text-light);
        z-index: 1000;
        transition: transform 0.3s ease;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-header {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-header h3 {
        margin: 0;
        font-size: 1.5rem;
        color: var(--text-light);
    }

    .sidebar-menu {
        padding: 1rem 0;
    }

    .menu-item {
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .menu-item:hover {
        background: var(--sidebar-hover);
        color: var(--text-light);
        border-left-color: var(--sidebar-active);
    }

    .menu-item.active {
        background: var(--sidebar-hover);
        color: var(--text-light);
        border-left-color: var(--sidebar-active);
    }

    .menu-item i {
        width: 20px;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .notification-badge {
        background: #e74c3c;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        margin-left: auto;
    }

    .profile-section {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 1rem 1.5rem;
        background: rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--sidebar-active);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        flex-shrink: 0;
    }

    .profile-info {
        flex-grow: 1;
        min-width: 0;
    }

    .profile-name {
        font-weight: 500;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-role {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1001;
        background: var(--sidebar-bg);
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
    }

    @media (max-width: 991px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display: block;
        }

        .main-content {
            margin-left: 0 !important;
        }
    }

    /* Hide scrollbar but keep functionality */
    .sidebar::-webkit-scrollbar {
        width: 0px;
    }

    .sidebar {
        scrollbar-width: none;
    }
</style>

<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>WeCare</h3>
    </div>

    <div class="sidebar-menu">
        <a href="dashboard.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="appointments.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
            <i class="fas fa-calendar-check"></i>
            Appointments
        </a>
        <a href="patients.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'patients.php' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            Patients
        </a>
        <a href="schedule.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : ''; ?>">
            <i class="fas fa-clock"></i>
            Schedule
        </a>
        <a href="profile_settings.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile_settings.php' ? 'active' : ''; ?>">
            <i class="fas fa-user-cog"></i>
            Profile Settings
        </a>
        <a href="../logout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

    <div class="profile-section">
        <div class="profile-image">
            <?php 
                $name = explode(' ', $_SESSION['full_name']);
                echo strtoupper(substr($name[0], 0, 1));
            ?>
        </div>
        <div class="profile-info">
            <h4 class="profile-name"><?php echo htmlspecialchars($_SESSION['full_name']); ?></h4>
            <p class="profile-role">Doctor</p>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.main-content');

    // Function to handle sidebar toggle
    function toggleSidebar() {
        sidebar.classList.toggle('active');
    }

    // Add click event listener to toggle button
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isClickInside = sidebar.contains(event.target) || sidebarToggle.contains(event.target);
        
        if (!isClickInside && window.innerWidth <= 991 && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('active');
            }
        }, 250);
    });
});
</script> 