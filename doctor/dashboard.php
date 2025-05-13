<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: ../doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];

// Get doctor's information
    $stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $doctor = $stmt->get_result()->fetch_assoc();

// Get today's appointments count
$today = date('Y-m-d');
$stmt = $con->prepare("SELECT COUNT(*) as count FROM appointments WHERE doctor_id = ? AND appointment_date = ?");
$stmt->bind_param("is", $doctor_id, $today);
$stmt->execute();
$today_appointments = $stmt->get_result()->fetch_assoc()['count'];

// Get total patients count
$stmt = $con->prepare("SELECT COUNT(DISTINCT patient_id) as count FROM appointments WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$total_patients = $stmt->get_result()->fetch_assoc()['count'];

// Get upcoming appointments
$stmt = $con->prepare("
    SELECT a.*, p.full_name as patient_name, p.profile_image as patient_image 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = ? AND a.appointment_date >= ? 
    ORDER BY a.appointment_date ASC, a.appointment_time ASC 
    LIMIT 5
");
$stmt->bind_param("is", $doctor_id, $today);
$stmt->execute();
$upcoming_appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
            --sidebar-width: 250px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
            padding: 1rem;
            }
        }

        .dashboard-stats {
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
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            background: #3498db;
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .appointments-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .appointment-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .appointment-card:last-child {
            border-bottom: none;
        }
        .patient-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            background: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .appointment-info {
            flex-grow: 1;
        }
        .appointment-time {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .appointment-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-scheduled {
            background: #e3f2fd;
            color: #1976d2;
        }
        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }
        .sidebar {
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value"><?php echo $today_appointments; ?></div>
                <div class="stat-label">Today's Appointments</div>
            </div>
                <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?php echo $total_patients; ?></div>
                <div class="stat-label">Total Patients</div>
                </div>
                <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value">4.8</div>
                <div class="stat-label">Average Rating</div>
                </div>
            </div>

        <div class="appointments-section">
            <h3 class="mb-4">Upcoming Appointments</h3>
            <?php if (empty($upcoming_appointments)): ?>
                <p class="text-muted">No upcoming appointments</p>
            <?php else: ?>
                <?php foreach ($upcoming_appointments as $appointment): ?>
                    <div class="appointment-card">
                        <div class="patient-avatar">
                <?php
                                if (isset($appointment['patient_image']) && file_exists("../" . $appointment['patient_image'])) {
                                    echo '<img src="../' . $appointment['patient_image'] . '" alt="Patient" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">';
                                } else {
                                    echo strtoupper(substr($appointment['patient_name'], 0, 1));
                                }
                            ?>
                        </div>
                        <div class="appointment-info">
                            <h5 class="mb-1"><?php echo htmlspecialchars($appointment['patient_name']); ?></h5>
                            <div class="appointment-time">
                                <i class="far fa-calendar"></i> <?php echo date('F d, Y', strtotime($appointment['appointment_date'])); ?>
                                <i class="far fa-clock ms-3"></i> <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?>
                            </div>
                        </div>
                        <div class="appointment-status status-<?php echo strtolower($appointment['status']); ?>">
                            <?php echo ucfirst($appointment['status']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 