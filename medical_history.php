<?php
session_start();
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['user_name'] ?? '';

// Fetch patient's medical history
try {
    // Get past appointments
    $stmt = $con->prepare("
        SELECT a.*, d.full_name as doctor_name, d.specialization 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE a.patient_id = ? 
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Get prescriptions
    $stmt = $con->prepare("
        SELECT p.*, d.full_name as doctor_name 
        FROM prescriptions p 
        JOIN doctors d ON p.doctor_id = d.doctor_id 
        WHERE p.patient_id = ? 
        ORDER BY p.prescribed_date DESC
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $prescriptions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Get medical records
    $stmt = $con->prepare("
        SELECT m.*, d.full_name as doctor_name 
        FROM medical_records m 
        JOIN doctors d ON m.doctor_id = d.doctor_id 
        WHERE m.patient_id = ? 
        ORDER BY m.record_date DESC
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $medical_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    error_log("Error in medical_history.php: " . $e->getMessage());
    $appointments = [];
    $prescriptions = [];
    $medical_records = [];
}
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

        .section-title {
            color: var(--dark-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .history-item {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .history-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-text);
        }

        .history-date {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .history-details {
            color: var(--light-text);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .history-meta {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .history-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
        }

        .history-meta i {
            color: var(--primary-color);
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

        .status-scheduled {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
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

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 1rem;
        }

        .tab {
            padding: 0.5rem 1rem;
            cursor: pointer;
            color: var(--light-text);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .tab.active {
            background-color: var(--primary-color);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--light-text);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--border-color);
            margin-bottom: 1rem;
        }

        .download-btn {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .download-btn:hover {
            background-color: #43a047;
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
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });
    </script>
</body>
</html> 