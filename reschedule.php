<?php
session_start();
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$error = '';
$success = '';

// Check if appointment ID is provided
if (!isset($_GET['id'])) {
    header("Location: appointments.php");
    exit;
}

$appointmentId = $_GET['id'];

// Get appointment details
try {
    $stmt = $con->prepare("SELECT a.*, d.full_name as doctor_name, d.specialization 
                          FROM appointments a 
                          JOIN doctors d ON a.doctor_id = d.doctor_id 
                          WHERE a.appointment_id = ? AND a.patient_id = ? AND a.status = 'Scheduled'");
    $stmt->bind_param("ii", $appointmentId, $userId);
    $stmt->execute();
    $appointment = $stmt->get_result()->fetch_assoc();

    if (!$appointment) {
        header("Location: appointments.php");
        exit;
    }
} catch (Exception $e) {
    $error = "Error fetching appointment details.";
    error_log("Error in reschedule.php: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_date = $_POST['appointment_date'];
    $new_time = $_POST['appointment_time'];

    try {
        // Check if the new time slot is available
        $stmt = $con->prepare("SELECT COUNT(*) as count FROM appointments 
                              WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? 
                              AND status != 'Cancelled' AND appointment_id != ?");
        $stmt->bind_param("issi", $appointment['doctor_id'], $new_date, $new_time, $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['count'] > 0) {
            $error = "This time slot is already booked. Please choose another time.";
        } else {
            // Update the appointment
            $stmt = $con->prepare("UPDATE appointments 
                                  SET appointment_date = ?, appointment_time = ? 
                                  WHERE appointment_id = ? AND patient_id = ?");
            $stmt->bind_param("ssii", $new_date, $new_time, $appointmentId, $userId);

            if ($stmt->execute()) {
                $success = "Appointment rescheduled successfully!";
                // Redirect after 2 seconds
                header("refresh:2;url=appointments.php");
            } else {
                $error = "Failed to reschedule appointment. Please try again.";
            }
        }
    } catch (Exception $e) {
        $error = "An error occurred. Please try again.";
        error_log("Error in reschedule.php: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            color: var(--dark-text);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-text);
            font-weight: 500;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
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

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .current-appointment {
            background-color: #e3f2fd;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .current-appointment h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .current-appointment p {
            margin: 0.5rem 0;
            color: var(--dark-text);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="card">
                <h2 style="margin-bottom: 1.5rem;">
                    <i class="fas fa-calendar-alt" style="color: var(--primary-color);"></i>
                    Reschedule Appointment
                </h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <div class="current-appointment">
                    <h3>Current Appointment Details</h3>
                    <p><strong>Doctor:</strong> Dr. <?php echo htmlspecialchars($appointment['doctor_name']); ?></p>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($appointment['specialization']); ?></p>
                    <p><strong>Current Date:</strong> <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?></p>
                    <p><strong>Current Time:</strong> <?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></p>
                </div>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="appointment_date">New Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" 
                               min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="appointment_time">New Appointment Time</label>
                        <select name="appointment_time" id="appointment_time" required>
                            <option value="">Select a time</option>
                            <?php
                            $start_time = strtotime('09:00');
                            $end_time = strtotime('17:00');
                            $interval = 30 * 60; // 30 minutes

                            for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $time_value = date('H:i:s', $time);
                                $time_display = date('g:i A', $time);
                                echo "<option value=\"$time_value\">$time_display</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fas fa-calendar-check"></i> Reschedule Appointment
                        </button>
                        <a href="appointments.php" class="btn btn-secondary" style="flex: 1;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Add client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const date = document.getElementById('appointment_date').value;
            const time = document.getElementById('appointment_time').value;

            if (!date || !time) {
                e.preventDefault();
                alert('Please select both date and time for the appointment.');
            }
        });
    </script>
</body>
</html> 