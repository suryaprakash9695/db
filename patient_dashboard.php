<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

$username = $_SESSION['user_name'];
$userId = $_SESSION['user_id'];

// Fetch patient details
try {
    $stmt = $con->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $patientDetails = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (Exception $e) {
    // Handle error silently
    error_log("Error fetching patient details: " . $e->getMessage());
    $patientDetails = [];
}

// Fetch upcoming appointments
try {
    $stmt = $con->prepare("SELECT a.*, d.full_name as doctor_name, d.specialization, d.phone as doctor_phone
                          FROM appointments a
                          JOIN doctors d ON a.doctor_id = d.doctor_id
                          WHERE a.patient_id = ? AND a.appointment_date >= CURDATE()
                          ORDER BY a.appointment_date ASC
                          LIMIT 3");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $upcomingAppointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $upcomingAppointments = [];
    error_log("Error fetching upcoming appointments: " . $e->getMessage());
}

// Fetch recent medical records
try {
    $stmt = $con->prepare("SELECT mr.*, d.full_name as doctor_name, d.specialization
                          FROM medical_records mr
                          JOIN doctors d ON mr.doctor_id = d.doctor_id
                          WHERE mr.patient_id = ?
                          ORDER BY mr.record_date DESC
                          LIMIT 3");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $medicalRecords = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $medicalRecords = [];
    error_log("Error fetching medical records: " . $e->getMessage());
}

// Fetch unread notifications
try {
    $stmt = $con->prepare("SELECT * FROM notifications
                          WHERE user_id = ? AND user_type = 'patient' AND is_read = 0
                          ORDER BY created_at DESC
                          LIMIT 5");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $notifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $notifications = [];
    error_log("Error fetching notifications: " . $e->getMessage());
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: patient_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2196f3;
            --secondary-color: #4CAF50;
            --accent-color: #ff9800;
            --danger-color: #f44336;
            --light-bg: #f5f5f5;
            --dark-text: #333;
            --light-text: #666;
            --border-color: #e0e0e0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
            color: var(--dark-text);
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .main-content {
            margin-top: 100px;
            padding: 2rem 0;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-accent {
            background-color: var(--accent-color);
            color: white;
        }

        .notification-badge {
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), #64b5f6);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-card h3 {
            margin: 0.5rem 0;
            font-size: 1.5rem;
        }

        .stat-card p {
            margin: 0;
            color: var(--light-text);
        }

        .appointment-card {
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            margin-bottom: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .medical-record-card {
            border-left: 4px solid var(--secondary-color);
            padding: 1rem;
            margin-bottom: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .action-buttons .btn {
            flex: 1;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .health-tip {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .health-tip h4 {
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
        }

        .health-tip p {
            margin: 0;
            color: var(--dark-text);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center;">
                <img src="assets/images/thrive_logo.png" alt="WeCare Logo" style="height: 40px; margin-right: 1rem;">
                </div>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <div class="profile-section">
                    <div class="profile-icon">
                        <?php echo strtoupper(substr($username, 0, 1)); ?>
                    </div>
                    <span style="font-weight: 500;"><?php echo htmlspecialchars($username); ?></span>
                                    </div>
                <div style="position: relative;">
                    <a href="notifications.php" class="btn btn-secondary">
                        <i class="fas fa-bell"></i>
                        <?php if (count($notifications) > 0): ?>
                            <span class="notification-badge"><?php echo count($notifications); ?></span>
                                <?php endif; ?>
                    </a>
                </div>
                <a href="?logout=true" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <h2 style="margin: 0; font-size: 2rem;">Welcome back, <?php echo htmlspecialchars($username); ?>!</h2>
                <p style="margin: 0.5rem 0 0; opacity: 0.9;">Here's your health summary for today.</p>
            </section>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3><?php echo count($upcomingAppointments); ?></h3>
                    <p>Upcoming Appointments</p>
                        </div>
                <div class="stat-card">
                    <i class="fas fa-file-medical"></i>
                    <h3><?php echo count($medicalRecords); ?></h3>
                    <p>Recent Records</p>
                    </div>
                <div class="stat-card">
                    <i class="fas fa-bell"></i>
                    <h3><?php echo count($notifications); ?></h3>
                    <p>New Notifications</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid">
                <div class="card">
                    <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                        <i class="fas fa-calendar-check" style="color: var(--primary-color);"></i>
                        Book Appointment
                    </h3>
                    <p style="color: var(--light-text);">Schedule a consultation with our expert healthcare professionals.</p>
                    <div class="action-buttons">
                        <a href="book_appointment.php" class="btn btn-primary">Book Now</a>
                        <a href="appointments.php" class="btn btn-secondary">View All</a>
                        </div>
                        </div>

                <div class="card">
                    <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                        <i class="fas fa-file-medical" style="color: var(--secondary-color);"></i>
                        Medical Records
                    </h3>
                    <p style="color: var(--light-text);">Access your complete medical history and treatment records.</p>
                    <div class="action-buttons">
                        <a href="patient_medical_history.php" class="btn btn-secondary">View Records</a>
                        <a href="download_records.php" class="btn btn-primary">Download</a>
                    </div>
                </div>

                <div class="card">
                    <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                        <i class="fas fa-phone-alt" style="color: var(--accent-color);"></i>
                        Emergency Contact
                    </h3>
                    <p style="color: var(--light-text);">Quick access to emergency services and support.</p>
                    <div class="action-buttons">
                        <a href="tel:911" class="btn btn-accent">Call Now</a>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <section class="card">
                <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                    <i class="fas fa-calendar" style="color: var(--primary-color);"></i>
                    Upcoming Appointments
                </h3>
                <?php if (empty($upcomingAppointments)): ?>
                    <p style="color: var(--light-text);">No upcoming appointments scheduled.</p>
                <?php else: ?>
                    <div style="display: grid; gap: 1rem;">
                        <?php foreach ($upcomingAppointments as $appointment): ?>
                            <div class="appointment-card">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h4 style="margin: 0; color: var(--dark-text);">Dr. <?php echo htmlspecialchars($appointment['doctor_name']); ?></h4>
                                        <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                                            <?php echo htmlspecialchars($appointment['specialization']); ?> - 
                                            <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?>
                                        </p>
                                        <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                                            <i class="fas fa-phone"></i> <?php echo htmlspecialchars($appointment['doctor_phone']); ?>
                                        </p>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="color: var(--light-text);">
                                            <?php echo date('g:i A', strtotime($appointment['appointment_date'])); ?>
                                        </span>
                                        <div class="action-buttons" style="margin-top: 0.5rem;">
                                            <a href="tel:<?php echo htmlspecialchars($appointment['doctor_phone']); ?>" class="btn btn-primary">Call</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Recent Medical Records -->
            <section class="card">
                <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                    <i class="fas fa-file-medical" style="color: var(--secondary-color);"></i>
                    Recent Medical Records
                </h3>
                <?php if (empty($medicalRecords)): ?>
                    <p style="color: var(--light-text);">No recent medical records found.</p>
                <?php else: ?>
                    <div style="display: grid; gap: 1rem;">
                        <?php foreach ($medicalRecords as $record): ?>
                            <div class="medical-record-card">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h4 style="margin: 0; color: var(--dark-text);">Dr. <?php echo htmlspecialchars($record['doctor_name']); ?></h4>
                                        <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                                            <?php echo htmlspecialchars($record['specialization']); ?>
                                        </p>
                                        <p style="margin: 0.5rem 0 0; color: var(--dark-text);">
                                            <?php echo htmlspecialchars($record['diagnosis']); ?>
                                        </p>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="color: var(--light-text);">
                                            <?php echo date('M j, Y', strtotime($record['record_date'])); ?>
                                        </span>
                                        <div class="action-buttons" style="margin-top: 0.5rem;">
                                            <a href="view_record.php?id=<?php echo $record['record_id']; ?>" class="btn btn-primary">View Details</a>
                                            <a href="download_record.php?id=<?php echo $record['record_id']; ?>" class="btn btn-secondary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Health Tips -->
            <section class="card">
                <h3 style="margin: 0 0 1rem; color: var(--dark-text);">
                    <i class="fas fa-heart" style="color: var(--danger-color);"></i>
                    Health Tips
                </h3>
                <div style="display: grid; gap: 1rem;">
                    <div class="health-tip">
                        <h4><i class="fas fa-tint"></i> Stay Hydrated</h4>
                        <p>Drink at least 8 glasses of water daily for optimal health and better digestion.</p>
                    </div>
                    <div class="health-tip">
                        <h4><i class="fas fa-running"></i> Regular Exercise</h4>
                        <p>Aim for 30 minutes of moderate exercise daily to maintain a healthy lifestyle.</p>
                        </div>
                    <div class="health-tip">
                        <h4><i class="fas fa-bed"></i> Quality Sleep</h4>
                        <p>Get 7-8 hours of sleep each night to boost your immune system and mental health.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php require_once 'includes/footer.php'; ?>
</body>
</html>

