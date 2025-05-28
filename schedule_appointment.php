<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['user_name'];
$error = '';
$success = '';

// Get patient_id from URL if provided
$patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : null;

// Fetch doctor's schedule
try {
    $stmt = $con->prepare("SELECT * FROM doctor_schedule WHERE doctor_id = ?");
    if ($stmt === false) {
        throw new Exception("Database error: Unable to prepare statement for fetching doctor schedule. Check SQL syntax or connection.");
    }
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $schedule = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching doctor schedule: " . $e->getMessage());
}

// Fetch patients list
try {
    $stmt = $con->prepare("SELECT DISTINCT p.* FROM patients p 
                          JOIN appointments a ON p.patient_id = a.patient_id 
                          WHERE a.doctor_id = ? 
                          ORDER BY p.full_name ASC");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $patients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching patients: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = $_POST['reason'];
    $notes = $_POST['notes'] ?? '';
    $preferred_communication = $_POST['preferred_communication'] ?? 'email'; // Default to email if not specified

    try {
        // Check if the time slot is available
        $check_stmt = $con->prepare("SELECT COUNT(*) as count FROM appointments 
                                   WHERE doctor_id = ? AND appointment_date = ? 
                                   AND appointment_time = ? AND status != 'Cancelled'");
        $check_stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
        $check_stmt->execute();
        $result = $check_stmt->get_result()->fetch_assoc();
        $check_stmt->close();

        if ($result['count'] > 0) {
            $error = "This time slot is already booked. Please choose another time.";
        } else {
            // Insert new appointment
            $insert_stmt = $con->prepare("INSERT INTO appointments 
                                        (doctor_id, patient_id, appointment_date, appointment_time, 
                                         reason, notes, preferred_communication, status, created_at) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, 'Scheduled', NOW())");
            $insert_stmt->bind_param("iisssss", $doctor_id, $patient_id, $appointment_date, 
                                   $appointment_time, $reason, $notes, $preferred_communication);
            
            if ($insert_stmt->execute()) {
                $success = "Appointment scheduled successfully!";
                // Clear form data
                $patient_id = null;
                $appointment_date = '';
                $appointment_time = '';
                $reason = '';
                $notes = '';
                $preferred_communication = 'email';
            } else {
                $error = "Failed to schedule appointment. Please try again.";
            }
            $insert_stmt->close();
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
        error_log("Error in schedule_appointment.php: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-text);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
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
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1976d2;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
        }

        .schedule-info {
            background: #e3f2fd;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .schedule-info h3 {
            margin: 0 0 0.5rem;
            color: #1976d2;
        }

        .schedule-info p {
            margin: 0;
            color: var(--dark-text);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0;">
                    <i class="fas fa-calendar-plus" style="color: var(--primary-color);"></i>
                    Schedule Appointment
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    Schedule a new appointment with a patient
                </p>
            </div>
            <a href="doctor_dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="card">
            <!-- Schedule Information -->
            <div class="schedule-info">
                <h3><i class="fas fa-info-circle"></i> Your Schedule</h3>
                <p>
                    <strong>Working Hours:</strong> 
                    <?php echo date('h:i A', strtotime($schedule['start_time'] ?? '09:00:00')); ?> - 
                    <?php echo date('h:i A', strtotime($schedule['end_time'] ?? '17:00:00')); ?>
                </p>
                <p><strong>Appointment Duration:</strong> 30 minutes</p>
            </div>

            <!-- Appointment Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="patient_id">Select Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control" required>
                        <option value="">Choose a patient...</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['patient_id']; ?>" 
                                    <?php echo $patient_id == $patient['patient_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($patient['full_name']); ?> 
                                (<?php echo htmlspecialchars($patient['phone']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" 
                           class="form-control" required 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" 
                           class="form-control" required 
                           min="<?php echo $schedule['start_time'] ?? '09:00'; ?>" 
                           max="<?php echo $schedule['end_time'] ?? '17:00'; ?>">
                </div>

                <div class="form-group">
                    <label for="reason">Reason for Visit</label>
                    <input type="text" name="reason" id="reason" class="form-control" 
                           required placeholder="Enter reason for visit">
                </div>

                <div class="form-group">
                    <label for="preferred_communication">Preferred Communication Method</label>
                    <select name="preferred_communication" id="preferred_communication" class="form-control" required>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="sms">SMS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="4" 
                              placeholder="Enter any additional notes or instructions"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i> Schedule Appointment
                </button>
            </form>
        </div>
    </div>

    <script>
        // Add client-side validation for time slots
        document.getElementById('appointment_time').addEventListener('change', function() {
            const time = this.value;
            const [hours, minutes] = time.split(':');
            
            // Ensure time is in 30-minute intervals
            if (minutes !== '00' && minutes !== '30') {
                alert('Please select a time in 30-minute intervals (e.g., 9:00, 9:30, 10:00)');
                this.value = '';
            }
        });
    </script>
</body>
</html> 