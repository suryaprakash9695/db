<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['user_name'];

// Fetch doctor details
try {
    $stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $doctorDetails = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching doctor details: " . $e->getMessage());
    $doctorDetails = [];
}

// Fetch upcoming appointments
try {
    $stmt = $con->prepare("SELECT a.*, p.full_name as patient_name, p.phone as patient_phone
                          FROM appointments a
                          JOIN patients p ON a.patient_id = p.patient_id
                          WHERE a.doctor_id = ? AND a.appointment_date >= CURDATE()
                          ORDER BY a.appointment_date ASC
                          LIMIT 3");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $upcomingAppointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $upcomingAppointments = [];
    error_log("Error fetching upcoming appointments: " . $e->getMessage());
}

// Fetch recent patients
try {
    $stmt = $con->prepare("SELECT DISTINCT p.* 
                          FROM patients p
                          JOIN appointments a ON p.patient_id = a.patient_id
                          WHERE a.doctor_id = ?
                          ORDER BY a.appointment_date DESC
                          LIMIT 3");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $recentPatients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $recentPatients = [];
    error_log("Error fetching recent patients: " . $e->getMessage());
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), #64b5f6);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            margin: 0;
            opacity: 0.9;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-text);
            margin: 0;
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
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1976d2;
        }

        .appointment-item, .patient-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .appointment-item:last-child, .patient-item:last-child {
            border-bottom: none;
        }

        .logout-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: white;
            color: var(--primary-color);
        }

        /* Add new styles for buttons */
        .action-buttons {
            display: grid;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            border-radius: 10px;
            background: white;
            border: 1px solid var(--border-color);
            color: var(--dark-text);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .action-btn i {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></h1>
                <p>Here's your dashboard overview</p>
            </div>
            <a href="?logout=1" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <h3><?php echo count($upcomingAppointments); ?></h3>
                <p>Upcoming Appointments</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo count($recentPatients); ?></h3>
                <p>Recent Patients</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h3>Today</h3>
                <p><?php echo date('l, F j, Y'); ?></p>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Upcoming Appointments -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Upcoming Appointments</h2>
                    <a href="doctor_appointments.php" class="btn btn-primary">View All</a>
                </div>
                <?php if (!empty($upcomingAppointments)): ?>
                    <?php foreach ($upcomingAppointments as $appointment): ?>
                        <div class="appointment-item">
                            <h4><?php echo htmlspecialchars($appointment['patient_name']); ?></h4>
                            <p><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></p>
                            <p><i class="fas fa-clock"></i> <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></p>
                            <div class="action-buttons">
                                <a href="view_appointment.php?id=<?php echo $appointment['appointment_id']; ?>" class="action-btn">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No upcoming appointments</p>
                <?php endif; ?>
            </div>

            <!-- Recent Patients -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Patients</h2>
                    <a href="doctor_patients.php" class="btn btn-primary">View All</a>
                </div>
                <?php if (!empty($recentPatients)): ?>
                    <?php foreach ($recentPatients as $patient): ?>
                        <div class="patient-item">
                            <h4><?php echo htmlspecialchars($patient['full_name']); ?></h4>
                            <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($patient['phone']); ?></p>
                            <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($patient['email']); ?></p>
                            <div class="action-buttons">
                                <a href="patient_records.php?id=<?php echo $patient['patient_id']; ?>" class="action-btn">
                                    <i class="fas fa-file-medical"></i> View Records
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No recent patients</p>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quick Actions</h2>
                </div>
                <div class="action-buttons">
                    <a href="schedule_appointment.php" class="action-btn">
                        <i class="fas fa-calendar-plus"></i> Schedule Appointment
                    </a>
                    <a href="add_medical_record.php" class="action-btn">
                        <i class="fas fa-file-medical"></i> Add Medical Record
                    </a>
                    <a href="doctor_profile.php" class="action-btn">
                        <i class="fas fa-user-edit"></i> Update Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 