<?php
session_start();
require_once('config.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['user_name'] ?? '';

// Initialize arrays
$appointments = [];
$prescriptions = [];
$medical_records = [];
$error = '';

// Fetch patient's medical history
try {
    // Verify database connection
    if ($con->connect_error) {
        throw new Exception("Database connection failed: " . $con->connect_error);
    }

    // Get past appointments
    $stmt = $con->prepare("
        SELECT a.*, d.full_name as doctor_name, d.specialization 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE a.patient_id = ? 
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
    ");
    
    if (!$stmt) {
        throw new Exception("Error preparing appointments query: " . $con->error);
    }
    
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        throw new Exception("Error executing appointments query: " . $stmt->error);
    }
    $appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Get prescriptions
    $stmt = $con->prepare("
        SELECT p.*, d.full_name as doctor_name 
        FROM prescriptions p 
        JOIN doctors d ON p.doctor_id = d.doctor_id 
        WHERE p.patient_id = ? 
        ORDER BY p.prescribed_date DESC
    ");
    
    if (!$stmt) {
        throw new Exception("Error preparing prescriptions query: " . $con->error);
    }
    
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        throw new Exception("Error executing prescriptions query: " . $stmt->error);
    }
    $prescriptions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Get medical records
    $stmt = $con->prepare("
        SELECT m.*, d.full_name as doctor_name 
        FROM medical_records m 
        JOIN doctors d ON m.doctor_id = d.doctor_id 
        WHERE m.patient_id = ? 
        ORDER BY m.record_date DESC
    ");
    
    if (!$stmt) {
        throw new Exception("Error preparing medical records query: " . $con->error);
    }
    
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        throw new Exception("Error executing medical records query: " . $stmt->error);
    }
    $medical_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
    error_log("Error in patient_medical_history.php: " . $e->getMessage());
}

// Debug information
$debug = [
    'user_id' => $userId,
    'username' => $username,
    'appointments_count' => count($appointments),
    'prescriptions_count' => count($prescriptions),
    'medical_records_count' => count($medical_records),
    'error' => $error
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-content {
            padding: 2rem 0;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 1rem;
        }

        .tab {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .tab:hover {
            background-color: #f0f0f0;
        }

        .tab.active {
            background-color: #3498db;
            color: #fff;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .history-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .history-item:hover {
            transform: translateY(-2px);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .history-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .history-details {
            margin-bottom: 1rem;
        }

        .history-meta {
            display: flex;
            gap: 1.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .download-btn {
            background-color: #3498db;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .download-btn:hover {
            background-color: #2980b9;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state i {
            font-size: 3rem;
            color: #bdc3c7;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .debug-info {
            background-color: #f5f5f5;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-family: monospace;
            font-size: 0.9rem;
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
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php if ($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['debug'])): ?>
                <div class="debug-info">
                    <pre><?php print_r($debug); ?></pre>
                </div>
            <?php endif; ?>

            <div class="card">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    Medical History
                </h2>

                <!-- Tabs -->
                <div class="tabs">
                    <div class="tab active" data-tab="appointments">Appointments</div>
                    <div class="tab" data-tab="prescriptions">Prescriptions</div>
                    <div class="tab" data-tab="records">Medical Records</div>
                </div>

                <!-- Appointments Tab -->
                <div class="tab-content active" id="appointments">
                    <?php if (empty($appointments)): ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>No Past Appointments</h3>
                            <p>You haven't had any appointments yet.</p>
                            <a href="book_appointment.php" class="btn btn-primary">Book an Appointment</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <div class="history-item">
                                <div class="history-header">
                                    <div class="history-title">
                                        Appointment with Dr. <?php echo htmlspecialchars($appointment['doctor_name']); ?>
                                    </div>
                                    <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                                        <?php echo htmlspecialchars($appointment['status']); ?>
                                    </span>
                                </div>
                                <div class="history-details">
                                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($appointment['specialization']); ?></p>
                                    <p><strong>Reason:</strong> <?php echo htmlspecialchars($appointment['reason']); ?></p>
                                    <?php if ($appointment['notes']): ?>
                                        <p><strong>Notes:</strong> <?php echo htmlspecialchars($appointment['notes']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="history-meta">
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        <?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-comments"></i>
                                        <?php echo htmlspecialchars($appointment['preferred_communication']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Prescriptions Tab -->
                <div class="tab-content" id="prescriptions">
                    <?php if (empty($prescriptions)): ?>
                        <div class="empty-state">
                            <i class="fas fa-prescription-bottle-alt"></i>
                            <h3>No Prescriptions</h3>
                            <p>You don't have any prescriptions yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <div class="history-item">
                                <div class="history-header">
                                    <div class="history-title">
                                        Prescription from Dr. <?php echo htmlspecialchars($prescription['doctor_name']); ?>
                                    </div>
                                    <a href="download_prescription.php?id=<?php echo $prescription['prescription_id']; ?>" 
                                       class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                                <div class="history-details">
                                    <p><strong>Medications:</strong></p>
                                    <ul>
                                        <?php 
                                        $medications = json_decode($prescription['medications'], true);
                                        foreach ($medications as $med): ?>
                                            <li>
                                                <?php echo htmlspecialchars($med['name']); ?> - 
                                                <?php echo htmlspecialchars($med['dosage']); ?> - 
                                                <?php echo htmlspecialchars($med['frequency']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php if ($prescription['notes']): ?>
                                        <p><strong>Notes:</strong> <?php echo htmlspecialchars($prescription['notes']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="history-meta">
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('F j, Y', strtotime($prescription['prescribed_date'])); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        Valid until: <?php echo date('F j, Y', strtotime($prescription['valid_until'])); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Medical Records Tab -->
                <div class="tab-content" id="records">
                    <?php if (empty($medical_records)): ?>
                        <div class="empty-state">
                            <i class="fas fa-file-medical"></i>
                            <h3>No Medical Records</h3>
                            <p>You don't have any medical records yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($medical_records as $record): ?>
                            <div class="history-item">
                                <div class="history-header">
                                    <div class="history-title">
                                        Medical Record from Dr. <?php echo htmlspecialchars($record['doctor_name']); ?>
                                    </div>
                                    <a href="download_record.php?id=<?php echo $record['record_id']; ?>" 
                                       class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                                <div class="history-details">
                                    <p><strong>Diagnosis:</strong> <?php echo htmlspecialchars($record['diagnosis']); ?></p>
                                    <p><strong>Treatment:</strong> <?php echo htmlspecialchars($record['treatment']); ?></p>
                                    <?php if ($record['notes']): ?>
                                        <p><strong>Notes:</strong> <?php echo htmlspecialchars($record['notes']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="history-meta">
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('F j, Y', strtotime($record['record_date'])); ?>
                                    </span>
                                    <?php if ($record['next_followup']): ?>
                                        <span>
                                            <i class="fas fa-calendar-check"></i>
                                            Next Follow-up: <?php echo date('F j, Y', strtotime($record['next_followup'])); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Tab switching functionality with error handling
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            // Debug information
            console.log('Found tabs:', tabs.length);
            console.log('Found tab contents:', tabContents.length);

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default behavior
                    
                    // Get the target tab ID
                    const targetTab = this.getAttribute('data-tab');
                    console.log('Clicked tab:', targetTab);

                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Find and activate the corresponding content
                    const targetContent = document.getElementById(targetTab);
                    if (targetContent) {
                        targetContent.classList.add('active');
                        console.log('Activated content:', targetTab);
                    } else {
                        console.error('Target content not found:', targetTab);
                    }
                });
            });

            // Add error handling for tab content visibility
            tabContents.forEach(content => {
                if (content.classList.contains('active')) {
                    console.log('Active content:', content.id);
                }
            });
        });
    </script>
</body>
</html> 