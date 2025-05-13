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

// Handle schedule updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $day = $_POST['day'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $maxPatients = $_POST['max_patients'];

            $stmt = $con->prepare("INSERT INTO doctor_schedules (doctor_id, day, start_time, end_time, max_patients) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("Error preparing statement: " . $con->error);
            }
            $stmt->bind_param("isssi", $doctorId, $day, $startTime, $endTime, $maxPatients);
            $stmt->execute();
        } elseif ($_POST['action'] === 'delete' && isset($_POST['schedule_id'])) {
            $scheduleId = $_POST['schedule_id'];
            $stmt = $con->prepare("DELETE FROM doctor_schedules WHERE schedule_id = ? AND doctor_id = ?");
            if ($stmt === false) {
                die("Error preparing statement: " . $con->error);
            }
            $stmt->bind_param("ii", $scheduleId, $doctorId);
            $stmt->execute();
        }
    }
}

// Get current schedule
$stmt = $con->prepare("SELECT * FROM doctor_schedules WHERE doctor_id = ? ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time");
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$schedule_result = $stmt->get_result();
$schedule = [];
while ($row = $schedule_result->fetch_assoc()) {
    $schedule[] = $row;
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - WeCare</title>
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

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .schedule-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .schedule-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            padding: 1.5rem;
        }

        .time-slot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .time-slot:last-child {
            border-bottom: none;
        }

        .time-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .time-badge {
            background-color: #e3f2fd;
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        .add-schedule-form {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <div class="schedule-header">
            <h2>Schedule Timing</h2>
            <p class="text-muted">Manage your availability for appointments</p>
        </div>

        <!-- Add Schedule Form -->
        <div class="add-schedule-form">
            <h4 class="mb-3">Add New Schedule</h4>
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="add">
                <div class="col-md-3">
                    <select name="day" class="form-select" required>
                        <option value="">Select Day</option>
                        <?php foreach ($days as $day): ?>
                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_patients" class="form-control" placeholder="Max Patients" min="1" value="1" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </form>
        </div>

        <!-- Schedule List -->
        <?php foreach ($days as $day): ?>
            <div class="schedule-card">
                <h4 class="mb-3"><?php echo $day; ?></h4>
                <?php
                $day_schedules = array_filter($schedule, function($slot) use ($day) {
                    return $slot['day'] === $day;
                });
                
                if (empty($day_schedules)): ?>
                    <p class="text-muted">No schedule set for this day</p>
                <?php else: ?>
                    <?php foreach ($day_schedules as $slot): ?>
                        <div class="time-slot">
                            <div class="time-info">
                                <div class="time-badge">
                                    <i class="far fa-clock"></i>
                                    <?php echo date('h:i A', strtotime($slot['start_time'])); ?> - 
                                    <?php echo date('h:i A', strtotime($slot['end_time'])); ?>
                                </div>
                                <span class="text-muted">
                                    Max Patients: <?php echo $slot['max_patients']; ?>
                                </span>
                            </div>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="schedule_id" value="<?php echo $slot['schedule_id']; ?>">
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 