<?php
// Get doctor details
$stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();
?>

<div class="sidebar">
    <div class="doctor-profile">
        <img src="../<?php echo $doctor['profile_image'] ?? 'assets/images/default-profile.png'; ?>" alt="Doctor Profile" class="profile-image">
        <h4>Dr. <?php echo htmlspecialchars($doctor['full_name']); ?></h4>
        <p class="text-muted"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
    </div>
    <nav>
        <div class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="appointments.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
        </div>
        <div class="nav-item">
            <a href="schedule.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : ''; ?>">
                <i class="fas fa-clock"></i> Schedule Timing
            </a>
        </div>
        <div class="nav-item">
            <a href="patients.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'patients.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Patients List
            </a>
        </div>
        <div class="nav-item">
            <a href="chat.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'chat.php' ? 'active' : ''; ?>">
                <i class="fas fa-comments"></i> Chat
            </a>
        </div>
        <div class="nav-item">
            <a href="invoices.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'invoices.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice-dollar"></i> Invoices
            </a>
        </div>
        <div class="nav-item">
            <a href="reviews.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : ''; ?>">
                <i class="fas fa-star"></i> Reviews
            </a>
        </div>
        <div class="nav-item">
            <a href="profile.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-cog"></i> Profile Settings
            </a>
        </div>
    </nav>
</div>

<style>
.sidebar {
    width: 250px;
    background: white;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    padding: 2rem 0;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.doctor-profile {
    text-align: center;
    padding: 0 1rem;
    margin-bottom: 2rem;
}

.doctor-profile .profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 1rem;
    object-fit: cover;
}

.nav-item {
    padding: 0.5rem 1rem;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--dark-text);
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.nav-link i {
    margin-right: 0.75rem;
    width: 20px;
    text-align: center;
}

.nav-link:hover, .nav-link.active {
    background-color: var(--primary-color);
    color: white;
}

.nav-link.active {
    font-weight: 500;
}
</style> 