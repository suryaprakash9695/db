<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctorId = $_SESSION['user_id'];

// Get doctor's information
try {
    $stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $doctor = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    error_log("Error in doctor dashboard: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2196f3;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --light-text: #6c757d;
            --dark-text: #343a40;
            --border-color: #dee2e6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }

        .doctor-profile {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .nav-item {
            padding: 0.5rem 1.5rem;
            margin: 0.5rem 0;
        }

        .nav-link {
            color: var(--dark-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .dashboard-header {
            background: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: var(--light-text);
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .recent-appointments {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .appointment-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .appointment-item:last-child {
            border-bottom: none;
        }

        .patient-info {
            flex: 1;
        }

        .appointment-time {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-scheduled {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="doctor-profile">
                <img src="../<?php echo $doctor['profile_image'] ?? 'assets/images/default-profile.png'; ?>" alt="Doctor Profile" class="profile-image">
                <h4>Dr. <?php echo htmlspecialchars($doctor['full_name']); ?></h4>
                <p class="text-muted"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
            </div>
            <nav>
                <div class="nav-item">
                    <a href="dashboard.php" class="nav-link active">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="appointments.php" class="nav-link">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </div>
                <div class="nav-item">
                    <a href="schedule.php" class="nav-link">
                        <i class="fas fa-clock"></i> Schedule Timing
                    </a>
                </div>
                <div class="nav-item">
                    <a href="patients.php" class="nav-link">
                        <i class="fas fa-users"></i> Patients List
                    </a>
                </div>
                <div class="nav-item">
                    <a href="chat.php" class="nav-link">
                        <i class="fas fa-comments"></i> Chat
                    </a>
                </div>
                <div class="nav-item">
                    <a href="invoices.php" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i> Invoices
                    </a>
                </div>
                <div class="nav-item">
                    <a href="reviews.php" class="nav-link">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </div>
                <div class="nav-item">
                    <a href="profile.php" class="nav-link">
                        <i class="fas fa-user-cog"></i> Profile Settings
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <h2>Welcome back, Dr. <?php echo htmlspecialchars($doctor['full_name']); ?></h2>
                <p class="text-muted">Here's what's happening with your practice today.</p>
            </div>

            <!-- Stats -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Today's Appointments</h3>
                    <div class="number">
                        <?php
                        $today = date('Y-m-d');
                        $stmt = $con->prepare("SELECT COUNT(*) as count FROM appointments WHERE doctor_id = ? AND appointment_date = ?");
                        $stmt->bind_param("is", $doctorId, $today);
                        $stmt->execute();
                        echo $stmt->get_result()->fetch_assoc()['count'];
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Total Patients</h3>
                    <div class="number">
                        <?php
                        $stmt = $con->prepare("SELECT COUNT(DISTINCT patient_id) as count FROM appointments WHERE doctor_id = ?");
                        $stmt->bind_param("i", $doctorId);
                        $stmt->execute();
                        echo $stmt->get_result()->fetch_assoc()['count'];
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Pending Reviews</h3>
                    <div class="number">
                        <?php
                        $stmt = $con->prepare("SELECT COUNT(*) as count FROM reviews WHERE doctor_id = ? AND status = 'pending'");
                        $stmt->bind_param("i", $doctorId);
                        $stmt->execute();
                        echo $stmt->get_result()->fetch_assoc()['count'];
                        ?>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="recent-appointments">
                <h3 class="mb-4">Today's Appointments</h3>
                <?php
                $stmt = $con->prepare("
                    SELECT a.*, p.full_name as patient_name, p.profile_image as patient_image 
                    FROM appointments a 
                    JOIN patients p ON a.patient_id = p.patient_id 
                    WHERE a.doctor_id = ? AND a.appointment_date = ? 
                    ORDER BY a.appointment_time ASC
                ");
                $stmt->bind_param("is", $doctorId, $today);
                $stmt->execute();
                $appointments = $stmt->get_result();

                if ($appointments->num_rows > 0):
                    while ($appointment = $appointments->fetch_assoc()):
                ?>
                    <div class="appointment-item">
                        <img src="../<?php echo $appointment['patient_image'] ?? 'assets/images/default-profile.png'; ?>" 
                             alt="Patient" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 1rem;">
                        <div class="patient-info">
                            <h5 class="mb-1"><?php echo htmlspecialchars($appointment['patient_name']); ?></h5>
                            <div class="appointment-time">
                                <i class="far fa-clock"></i> 
                                <?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?>
                            </div>
                        </div>
                        <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                            <?php echo ucfirst($appointment['status']); ?>
                        </span>
                    </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <p class="text-muted text-center py-3">No appointments scheduled for today.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add active class to current page link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html> 