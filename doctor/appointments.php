<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: ../doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];

// Handle appointment status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];
    $stmt = $con->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ? AND doctor_id = ?");
    $stmt->bind_param("sii", $status, $appointmentId, $doctor_id);
    $stmt->execute();
}

// Get all appointments for the doctor
$stmt = $con->prepare("
    SELECT a.*, p.full_name as patient_name, p.profile_image as patient_image 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = ? 
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get doctor's schedule
$stmt = $con->prepare("
    CREATE TABLE IF NOT EXISTS doctor_schedules (
        schedule_id INT AUTO_INCREMENT PRIMARY KEY,
        doctor_id INT NOT NULL,
        day VARCHAR(10) NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        max_patients INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
    )
");

if ($stmt === false) {
    die("Error creating table: " . $con->error);
}

$stmt->execute();

// Now get the schedule
$stmt = $con->prepare("
    SELECT day, start_time, end_time, max_patients 
    FROM doctor_schedules 
    WHERE doctor_id = ?
");

if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}

$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$schedule = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get available time slots for today
$today = date('Y-m-d');
$dayOfWeek = date('l');
$availableSlots = [];

foreach ($schedule as $slot) {
    if ($slot['day'] === $dayOfWeek) {
        $startTime = strtotime($slot['start_time']);
        $endTime = strtotime($slot['end_time']);
        $currentTime = $startTime;
        
        while ($currentTime < $endTime) {
            $timeSlot = date('H:i:s', $currentTime);
            $stmt = $con->prepare("
                SELECT COUNT(*) as count 
                FROM appointments 
                WHERE doctor_id = ? 
                AND appointment_date = ? 
                AND appointment_time = ?
            ");
            $stmt->bind_param("iss", $doctor_id, $today, $timeSlot);
            $stmt->execute();
            $count = $stmt->get_result()->fetch_assoc()['count'];
            
            if ($count < $slot['max_patients']) {
                $availableSlots[] = $timeSlot;
            }
            
            $currentTime += 1800; // Add 30 minutes
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .main-content {
            margin-top: 80px;
            padding: 2rem;
        }
        .appointments-container {
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
            transition: background-color 0.3s ease;
        }
        .appointment-card:hover {
            background-color: #f8f9fa;
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
        .filter-section {
            margin-bottom: 1.5rem;
        }
        .filter-section .btn-group {
            margin-right: 1rem;
        }
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <div class="appointments-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>All Appointments</h3>
                <div class="filter-section d-flex align-items-center">
                    <div class="btn-group me-3">
                        <button type="button" class="btn btn-outline-primary active">All</button>
                        <button type="button" class="btn btn-outline-primary">Today</button>
                        <button type="button" class="btn btn-outline-primary">Upcoming</button>
                    </div>
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Search appointments...">
                    </div>
                </div>
            </div>

            <?php if (empty($appointments)): ?>
                <p class="text-muted text-center py-3">No appointments found.</p>
            <?php else: ?>
                <?php foreach ($appointments as $appointment): ?>
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
    <script>
        // Filter functionality
        document.querySelectorAll('.btn-group .btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                // Add filter logic here
            });
        });

        // Search functionality
        document.querySelector('.search-box input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.appointment-card').forEach(card => {
                const patientName = card.querySelector('h5').textContent.toLowerCase();
                const appointmentDate = card.querySelector('.appointment-time').textContent.toLowerCase();
                if (patientName.includes(searchTerm) || appointmentDate.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 