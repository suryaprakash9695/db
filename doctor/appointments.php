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

$doctorId = $_SESSION['user_id'];

// Handle appointment status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];
    $stmt = $con->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ? AND doctor_id = ?");
    $stmt->bind_param("sii", $status, $appointmentId, $doctorId);
    $stmt->execute();
}

// Get all appointments
$stmt = $con->prepare("
    SELECT a.*, p.full_name as patient_name, p.profile_image as patient_image 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = ? 
    ORDER BY a.appointment_date DESC, a.appointment_time ASC
");
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$appointments_result = $stmt->get_result();
$appointments = [];
while ($row = $appointments_result->fetch_assoc()) {
    $appointments[] = $row;
}

// Get doctor's schedule
$stmt = $con->prepare("
    SELECT day, start_time, end_time, max_patients 
    FROM doctor_schedule 
    WHERE doctor_id = ?
");
$stmt->bind_param("i", $doctorId);
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
            $stmt->bind_param("iss", $doctorId, $today, $timeSlot);
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

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }

        .appointments-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .appointment-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            padding: 1.5rem;
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .patient-info {
            display: flex;
            align-items: center;
        }

        .patient-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }

        .appointment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
        }

        .detail-item i {
            margin-right: 0.5rem;
            color: var(--primary-color);
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.25rem 0.75rem;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-complete {
            background-color: var(--success-color);
            color: white;
        }

        .btn-cancel {
            background-color: var(--danger-color);
            color: white;
        }

        .filter-section {
            margin-bottom: 1.5rem;
        }

        .filter-section select {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid var(--border-color);
        }

        .available-slots {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .time-slot {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            background-color: #e3f2fd;
            color: var(--primary-color);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .time-slot:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="appointments-header">
                <h2>Appointments</h2>
                <p class="text-muted">Manage your patient appointments</p>
            </div>

            <!-- Available Slots -->
            <div class="available-slots">
                <h4 class="mb-3">Available Time Slots for Today</h4>
                <?php if (empty($availableSlots)): ?>
                    <p class="text-muted">No available slots for today</p>
                <?php else: ?>
                    <?php foreach ($availableSlots as $slot): ?>
                        <span class="time-slot">
                            <?php echo date('g:i A', strtotime($slot)); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                </div>
            </div>

            <!-- Appointments List -->
            <?php foreach ($appointments as $appointment): ?>
                <div class="appointment-card">
                    <div class="appointment-header">
                        <div class="patient-info">
                            <img src="../<?php echo $appointment['patient_image'] ?? 'assets/images/default-profile.png'; ?>" 
                                 alt="Patient" class="patient-image">
                            <div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($appointment['patient_name']); ?></h5>
                                <small class="text-muted">Appointment #<?php echo $appointment['appointment_id']; ?></small>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <?php if ($appointment['status'] === 'scheduled'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn-action btn-complete">
                                        <i class="fas fa-check"></i> Complete
                                    </button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn-action btn-cancel">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="appointment-details">
                        <div class="detail-item">
                            <i class="far fa-calendar"></i>
                            <span><?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <i class="far fa-clock"></i>
                            <span><?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-stethoscope"></i>
                            <span><?php echo htmlspecialchars($appointment['reason']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                                <?php echo ucfirst($appointment['status']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', filterAppointments);
        document.getElementById('dateFilter').addEventListener('change', filterAppointments);

        function filterAppointments() {
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;
            const appointments = document.querySelectorAll('.appointment-card');

            appointments.forEach(appointment => {
                const appointmentStatus = appointment.querySelector('.status-badge').textContent.toLowerCase();
                const appointmentDate = appointment.querySelector('.detail-item:first-child span').textContent;
                
                let show = true;
                
                if (status && appointmentStatus !== status) {
                    show = false;
                }
                
                if (date) {
                    const filterDate = new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    if (appointmentDate !== filterDate) {
                        show = false;
                    }
                }
                
                appointment.style.display = show ? 'block' : 'none';
            });
        }
    </script>
</body>
</html> 