<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

// Check if appointment_id is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Invalid request. Appointment ID is required.";
    header("Location: doctor_appointments.php");
    exit;
}

$appointment_id = $_GET['id'];
$doctor_id = $_SESSION['user_id'];

try {
    // Get appointment details with patient information
    $query = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.status, 
                     a.reason, a.notes, a.doctor_id, a.patient_id,
                     p.full_name as patient_name, p.phone as patient_phone, 
                     p.email as patient_email, p.date_of_birth, p.gender,
                     p.medical_history, p.allergies
              FROM appointments a 
              JOIN patients p ON a.patient_id = p.patient_id 
              WHERE a.appointment_id = ? AND a.doctor_id = ?";
    
    $stmt = $con->prepare($query);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $con->error);
    }
    
    $stmt->bind_param("ii", $appointment_id, $doctor_id);
    if (!$stmt->execute()) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Appointment not found or you don't have permission to view it.";
        header("Location: doctor_appointments.php");
        exit;
    }
    
    $appointment = $result->fetch_assoc();
    
} catch (Exception $e) {
    $_SESSION['error'] = "An error occurred while fetching the appointment details.";
    error_log("Error in view_appointment.php: " . $e->getMessage());
    header("Location: doctor_appointments.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointment - WeCare</title>
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
            max-width: 1000px;
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
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .section {
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--primary-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            color: var(--light-text);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-scheduled { background: #e3f2fd; color: #1976d2; }
        .status-completed { background: #e8f5e9; color: #2e7d32; }
        .status-cancelled { background: #ffebee; color: #c62828; }

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

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0;">
                    <i class="fas fa-calendar-check" style="color: var(--primary-color);"></i>
                    Appointment Details
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    View detailed information about this appointment
                </p>
            </div>
            <a href="doctor_appointments.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Appointments
            </a>
        </div>

        <!-- Main Content -->
        <div class="card">
            <!-- Appointment Status -->
            <div class="section">
                <h2 class="section-title">Appointment Status</h2>
                <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                    <?php echo $appointment['status']; ?>
                </span>
            </div>

            <!-- Appointment Details -->
            <div class="section">
                <h2 class="section-title">Appointment Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Date</div>
                        <div class="info-value">
                            <?php echo date('F d, Y', strtotime($appointment['appointment_date'])); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Time</div>
                        <div class="info-value">
                            <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Reason for Visit</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['reason'] ?? 'Not specified'); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Notes</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['notes'] ?? 'No notes available'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="section">
                <h2 class="section-title">Patient Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['patient_name']); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['patient_phone']); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['patient_email']); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value">
                            <?php echo date('F d, Y', strtotime($appointment['date_of_birth'])); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Gender</div>
                        <div class="info-value">
                            <?php echo htmlspecialchars($appointment['gender']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="section">
                <h2 class="section-title">Medical Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Medical History</div>
                        <div class="info-value">
                            <?php echo nl2br(htmlspecialchars($appointment['medical_history'] ?? 'No medical history recorded')); ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Allergies</div>
                        <div class="info-value">
                            <?php echo nl2br(htmlspecialchars($appointment['allergies'] ?? 'No allergies recorded')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="doctor_appointments.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Appointments
                </a>
                <?php if ($appointment['status'] === 'Scheduled'): ?>
                    <form method="POST" action="cancel_appointment.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this appointment? This action cannot be undone.');">
                        <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancel Appointment
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 