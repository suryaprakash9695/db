<?php
session_start();
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

// Initialize database connection
try {
    if (!isset($con) || $con->connect_error) {
        throw new Exception("Database connection failed: " . ($con->connect_error ?? "Connection not established"));
    }
} catch (Exception $e) {
    error_log("Database connection error in book_appointment.php: " . $e->getMessage());
    die("Unable to connect to the database. Please try again later.");
}

$username = $_SESSION['user_name'];
$userId = $_SESSION['user_id'];

// Define specializations with descriptions
$specializations = [
    'Cardiology' => 'Heart & cardiovascular care, including heart disease, hypertension, and heart failure',
    'Dermatology' => 'Skin, hair, and nail disorders, cosmetic procedures, and skin cancer screening',
    'Neurology' => 'Brain, spinal cord, and nervous system disorders, including stroke and epilepsy',
    'Pediatrics' => 'Child healthcare from birth to adolescence, including growth monitoring and vaccinations',
    'Orthopedics' => 'Bone, joint, and muscle care, sports injuries, and joint replacement surgery',
    'Gynecology' => 'Women\'s health, reproductive care, pregnancy, and menopause management',
    'Ophthalmology' => 'Eye care, vision correction, and treatment of eye diseases',
    'ENT' => 'Ear, nose, throat disorders, hearing problems, and sinus conditions',
    'Dentistry' => 'Oral health, dental procedures, and preventive dental care',
    'General Medicine' => 'Primary healthcare, disease prevention, and general health management',
    'Psychiatry' => 'Mental health, emotional disorders, and behavioral therapy',
    'Gastroenterology' => 'Digestive system, liver, and gastrointestinal disorders',
    'Endocrinology' => 'Hormone disorders, diabetes, and thyroid conditions',
    'Pulmonology' => 'Lung diseases, respiratory disorders, and sleep apnea',
    'Urology' => 'Urinary system, kidney disorders, and male reproductive health',
    'Rheumatology' => 'Joint pain, arthritis, and autoimmune diseases',
    'Oncology' => 'Cancer diagnosis, treatment, and management',
    'Nephrology' => 'Kidney diseases, dialysis, and kidney transplantation',
    'Hematology' => 'Blood disorders, anemia, and blood cancer treatment',
    'Allergology' => 'Allergies, asthma, and immune system disorders',
    'Geriatrics' => 'Elderly care, age-related conditions, and senior health management',
    'Sports Medicine' => 'Sports injuries, physical therapy, and athletic performance',
    'Plastic Surgery' => 'Reconstructive and cosmetic procedures',
    'Vascular Surgery' => 'Blood vessel disorders and circulatory system surgery',
    'Infectious Disease' => 'Viral, bacterial, and parasitic infections'
];

// Initialize variables
$error = '';
$success = '';
$selected_doctor = null;
$available_slots = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['doctor_id', 'appointment_date', 'appointment_time', 'reason', 'preferred_communication'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = ucwords(str_replace('_', ' ', $field));
        }
    }
    
    if (!empty($missing_fields)) {
        $error = "Please fill in all required fields: " . implode(', ', $missing_fields);
    } else {
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $reason = $_POST['reason'];
        $notes = $_POST['notes'] ?? '';
        $preferred_communication = $_POST['preferred_communication'];

        try {
            // Check if the time slot is available
            $stmt = $con->prepare("SELECT COUNT(*) as count FROM appointments 
                                  WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? 
                                  AND status != 'Cancelled'");
            $stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();

            if ($result['count'] > 0) {
                $error = "This time slot is already booked. Please choose another time.";
            } else {
                // Insert the appointment
                $stmt = $con->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, 
                                      reason, notes, preferred_communication, status) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, 'Scheduled')");
                $stmt->bind_param("iisssss", $userId, $doctor_id, $appointment_date, $appointment_time, 
                                $reason, $notes, $preferred_communication);

                if ($stmt->execute()) {
                    // Only show success message, do not send email or notification
                    $success = "Appointment booked successfully!";
                    // Clear form data after successful submission
                    $_POST = array();
                } else {
                    $error = "Failed to book appointment. Please try again.";
                }
            }
        } catch (Exception $e) {
            $error = "An error occurred. Please try again.";
            error_log("Error in book_appointment.php: " . $e->getMessage());
        }
    }
}

// Get available doctors
try {
    $stmt = $con->prepare("SELECT * FROM doctors WHERE is_verified = 1 ORDER BY full_name");
    $stmt->execute();
    $doctors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $error = "Error fetching doctors. Please try again.";
    error_log("Error in book_appointment.php: " . $e->getMessage());
    $doctors = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - WeCare</title>
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
            --success-color: #4CAF50;
            --warning-color: #ff9800;
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
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-text);
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .required::after {
            content: " *";
            color: var(--danger-color);
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

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .doctor-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .doctor-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .doctor-card.selected {
            border-color: var(--primary-color);
            background-color: #e3f2fd;
        }

        .doctor-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .doctor-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.4rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .doctor-details {
            flex: 1;
        }

        .doctor-name {
            margin: 0;
            font-size: 1.2rem;
            color: var(--dark-text);
        }

        .doctor-specialization {
            color: var(--primary-color);
            font-weight: 500;
            margin: 0.25rem 0;
        }

        .doctor-meta {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .doctor-meta i {
            margin-right: 0.25rem;
        }

        .doctor-rating {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--accent-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .time-slot {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .time-slot:hover {
            border-color: var(--primary-color);
            background-color: #e3f2fd;
            transform: translateY(-1px);
        }

        .time-slot.selected {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .time-slot.booked {
            background-color: #f5f5f5;
            color: var(--light-text);
            cursor: not-allowed;
            position: relative;
        }

        .time-slot.booked::after {
            content: 'Booked';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .time-slot.booked:hover::after {
            opacity: 1;
        }

        .communication-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .communication-option {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .communication-option:hover {
            border-color: var(--primary-color);
            background-color: #e3f2fd;
        }

        .communication-option.selected {
            border-color: var(--primary-color);
            background-color: #e3f2fd;
        }

        .communication-option i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .appointment-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            display: none;
        }

        .appointment-summary.visible {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            color: var(--light-text);
        }

        .summary-value {
            font-weight: 500;
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }

        .loading.visible {
            display: flex;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .specialization-select {
            margin-bottom: 2rem;
        }

        .specialization-select select {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .specialization-select select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .specialization-description {
            margin-top: 0.5rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: var(--light-text);
            font-size: 0.9rem;
            display: none;
        }

        .specialization-description.visible {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .doctors-container {
            display: none;
        }

        .doctors-container.visible {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center;">
                <img src="assets/images/thrive_logo.png" alt="WeCare Logo" style="height: 40px; margin-right: 1rem;">
            </div>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
    <div class="container">
            <div class="card">
                <h2 style="margin: 0 0 2rem; color: var(--dark-text);">
                    <i class="fas fa-calendar-check" style="color: var(--primary-color);"></i>
                    Book an Appointment
                </h2>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
            <?php endif; ?>

                <form method="POST" action="" id="appointmentForm">
                    <div class="form-group">
                        <label for="doctor_id" class="required">Select Doctor</label>
                        <select name="doctor_id" id="doctor_id" required>
                            <option value="">Select a doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?php echo $doctor['doctor_id']; ?>" 
                                        <?php echo (isset($_POST['doctor_id']) && $_POST['doctor_id'] == $doctor['doctor_id']) ? 'selected' : ''; ?>>
                                    Dr. <?php echo htmlspecialchars($doctor['full_name']); ?> - 
                                    <?php echo htmlspecialchars($doctor['specialization']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointment_date" class="required">Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" 
                               min="<?php echo date('Y-m-d'); ?>" 
                               value="<?php echo $_POST['appointment_date'] ?? ''; ?>" required>
                    </div>

                <div class="form-group">
                        <label for="appointment_time" class="required">Appointment Time</label>
                        <select name="appointment_time" id="appointment_time" required>
                            <option value="">Select a time</option>
                        <?php
                            $start_time = strtotime('09:00');
                            $end_time = strtotime('17:00');
                            $interval = 30 * 60; // 30 minutes

                            for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $time_value = date('H:i:s', $time);
                                $time_display = date('g:i A', $time);
                                $selected = (isset($_POST['appointment_time']) && $_POST['appointment_time'] == $time_value) ? 'selected' : '';
                                echo "<option value=\"$time_value\" $selected>$time_display</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                        <label for="reason" class="required">Reason for Visit</label>
                        <textarea name="reason" id="reason" required><?php echo $_POST['reason'] ?? ''; ?></textarea>
                </div>

                <div class="form-group">
                        <label for="notes">Additional Notes (Optional)</label>
                        <textarea name="notes" id="notes"><?php echo $_POST['notes'] ?? ''; ?></textarea>
                </div>

                <div class="form-group">
                        <label for="preferred_communication" class="required">Preferred Communication</label>
                        <select name="preferred_communication" id="preferred_communication" required>
                            <option value="">Select preferred communication</option>
                            <option value="Phone" <?php echo (isset($_POST['preferred_communication']) && $_POST['preferred_communication'] == 'Phone') ? 'selected' : ''; ?>>Phone</option>
                            <option value="Email" <?php echo (isset($_POST['preferred_communication']) && $_POST['preferred_communication'] == 'Email') ? 'selected' : ''; ?>>Email</option>
                            <option value="SMS" <?php echo (isset($_POST['preferred_communication']) && $_POST['preferred_communication'] == 'SMS') ? 'selected' : ''; ?>>SMS</option>
                        </select>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fas fa-calendar-check"></i> Book Appointment
                        </button>
                        <a href="patient_dashboard.php" class="btn btn-secondary" style="flex: 1;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                </div>
            </form>
        </div>
    </div>
    </main>

    <script>
        // Add client-side validation
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger-color)';
                } else {
                    field.style.borderColor = 'var(--border-color)';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields marked with *');
            }
        });
    </script>
</body>
</html>
