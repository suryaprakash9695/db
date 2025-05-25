<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$patient_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize variables
$patient = null;
$medical_records = [];
$error = '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

try {
    // Fetch patient details
    $stmt = $con->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$patient) {
        header("Location: doctor_patients.php");
        exit;
    }

    // Fetch medical records
    $query = "SELECT mr.*, d.full_name as doctor_name 
              FROM medical_records mr 
              JOIN doctors d ON mr.doctor_id = d.doctor_id 
              WHERE mr.patient_id = ?";

    // Add filter conditions
    switch ($filter) {
        case 'recent':
            $query .= " AND mr.record_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
            break;
    }

    // Add sorting
    switch ($sort) {
        case 'date_asc':
            $query .= " ORDER BY mr.record_date ASC";
            break;
        case 'date_desc':
            $query .= " ORDER BY mr.record_date DESC";
            break;
    }

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $medical_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
    error_log("Error in patient_records.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records - WeCare</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .patient-info {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .patient-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .patient-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
        }

        .patient-details {
            flex: 1;
        }

        .patient-name {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .patient-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
        }

        .meta-item i {
            color: var(--primary-color);
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--dark-text);
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .sort-select {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            margin-left: auto;
        }

        .record-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .record-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .record-date {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .record-doctor {
            color: var(--primary-color);
            font-weight: 500;
        }

        .record-content {
            margin-bottom: 1rem;
        }

        .record-section {
            margin-bottom: 1rem;
        }

        .section-title {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .prescription-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .prescription-item {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0;">
                    <i class="fas fa-file-medical" style="color: var(--primary-color);"></i>
                    Patient Records
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    View and manage patient medical records
                </p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="add_medical_record.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Record
                </a>
                <a href="doctor_patients.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Patients
                </a>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="patient-info">
            <div class="patient-header">
                <div class="patient-avatar">
                    <?php echo strtoupper(substr($patient['full_name'], 0, 1)); ?>
                </div>
                <div class="patient-details">
                    <h2 class="patient-name"><?php echo htmlspecialchars($patient['full_name']); ?></h2>
                    <div class="patient-meta">
                        <div class="meta-item">
                            <i class="fas fa-phone"></i>
                            <?php echo htmlspecialchars($patient['phone']); ?>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-envelope"></i>
                            <?php echo htmlspecialchars($patient['email']); ?>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-birthday-cake"></i>
                            <?php echo date('F d, Y', strtotime($patient['date_of_birth'])); ?>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-venus-mars"></i>
                            <?php echo htmlspecialchars($patient['gender']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <a href="?id=<?php echo $patient_id; ?>&filter=all&sort=<?php echo $sort; ?>" 
               class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                All Records
            </a>
            <a href="?id=<?php echo $patient_id; ?>&filter=recent&sort=<?php echo $sort; ?>" 
               class="filter-btn <?php echo $filter === 'recent' ? 'active' : ''; ?>">
                Recent (3 Months)
            </a>
            <select class="sort-select" onchange="window.location.href='?id=<?php echo $patient_id; ?>&filter=<?php echo $filter; ?>&sort='+this.value">
                <option value="date_desc" <?php echo $sort === 'date_desc' ? 'selected' : ''; ?>>Sort by Date (Newest)</option>
                <option value="date_asc" <?php echo $sort === 'date_asc' ? 'selected' : ''; ?>>Sort by Date (Oldest)</option>
            </select>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($medical_records)): ?>
            <div class="empty-state">
                <i class="fas fa-file-medical"></i>
                <h3>No Medical Records Found</h3>
                <p>There are no medical records matching your current filter.</p>
            </div>
        <?php else: ?>
            <?php foreach ($medical_records as $record): ?>
                <div class="record-card">
                    <div class="record-header">
                        <div>
                            <div class="record-date">
                                <i class="fas fa-calendar"></i> 
                                <?php echo date('F d, Y', strtotime($record['record_date'])); ?>
                            </div>
                            <div class="record-doctor">
                                <i class="fas fa-user-md"></i> 
                                Dr. <?php echo htmlspecialchars($record['doctor_name']); ?>
                            </div>
                        </div>
                        <?php if ($record['follow_up_date']): ?>
                            <div class="follow-up-date">
                                <i class="fas fa-calendar-check"></i>
                                Follow-up: <?php echo date('F d, Y', strtotime($record['follow_up_date'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="record-content">
                        <div class="record-section">
                            <h3 class="section-title">Diagnosis</h3>
                            <p><?php echo nl2br(htmlspecialchars($record['diagnosis'])); ?></p>
                        </div>

                        <div class="record-section">
                            <h3 class="section-title">Prescription</h3>
                            <ul class="prescription-list">
                                <?php 
                                $prescriptions = json_decode($record['prescription'], true);
                                if ($prescriptions): 
                                    foreach ($prescriptions as $prescription): 
                                ?>
                                    <li class="prescription-item">
                                        <strong><?php echo htmlspecialchars($prescription['medication']); ?></strong>
                                        <br>
                                        Dosage: <?php echo htmlspecialchars($prescription['dosage']); ?>
                                        <br>
                                        Frequency: <?php echo htmlspecialchars($prescription['frequency']); ?>
                                        <br>
                                        Duration: <?php echo htmlspecialchars($prescription['duration']); ?>
                                    </li>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </ul>
                        </div>

                        <?php if ($record['notes']): ?>
                            <div class="record-section">
                                <h3 class="section-title">Additional Notes</h3>
                                <p><?php echo nl2br(htmlspecialchars($record['notes'])); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html> 