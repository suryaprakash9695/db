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

// Initialize variables
$patients = [];
$error = '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';

try {
    // Base query
    $query = "SELECT DISTINCT p.*, 
              (SELECT COUNT(*) FROM appointments a WHERE a.patient_id = p.patient_id AND a.doctor_id = ?) as appointment_count,
              (SELECT MAX(appointment_date) FROM appointments a WHERE a.patient_id = p.patient_id AND a.doctor_id = ?) as last_visit
              FROM patients p
              JOIN appointments a ON p.patient_id = a.patient_id
              WHERE a.doctor_id = ?";

    // Add search condition if search term exists
    if (!empty($search)) {
        $query .= " AND (p.full_name LIKE ? OR p.email LIKE ? OR p.phone LIKE ?)";
    }

    // Add sorting
    switch ($sort) {
        case 'name_asc':
            $query .= " ORDER BY p.full_name ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY p.full_name DESC";
            break;
        case 'recent':
            $query .= " ORDER BY last_visit DESC";
            break;
        case 'appointments':
            $query .= " ORDER BY appointment_count DESC";
            break;
    }

    $stmt = $con->prepare($query);
    
    if (!empty($search)) {
        $search_param = "%$search%";
        $stmt->bind_param("iiisss", $doctor_id, $doctor_id, $doctor_id, $search_param, $search_param, $search_param);
    } else {
        $stmt->bind_param("iii", $doctor_id, $doctor_id, $doctor_id);
    }
    
    $stmt->execute();
    $patients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
    error_log("Error in doctor_patients.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patients - WeCare</title>
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

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
        }

        .sort-select {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            font-family: inherit;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .patient-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .patient-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .patient-card:hover {
            transform: translateY(-5px);
        }

        .patient-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .patient-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .patient-info {
            flex: 1;
        }

        .patient-name {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .patient-stats {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--light-text);
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
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
                    <i class="fas fa-users" style="color: var(--primary-color);"></i>
                    My Patients
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    View and manage your patient list
                </p>
            </div>
            <a href="doctor_dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Search and Sort -->
        <div class="search-bar">
            <form method="GET" action="" style="flex: 1; display: flex; gap: 1rem;">
                <input type="text" name="search" class="search-input" 
                       placeholder="Search patients by name, email, or phone..."
                       value="<?php echo htmlspecialchars($search); ?>">
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Sort by Name (A-Z)</option>
                    <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Sort by Name (Z-A)</option>
                    <option value="recent" <?php echo $sort === 'recent' ? 'selected' : ''; ?>>Sort by Recent Visit</option>
                    <option value="appointments" <?php echo $sort === 'appointments' ? 'selected' : ''; ?>>Sort by Appointment Count</option>
                </select>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($patients)): ?>
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <h3>No Patients Found</h3>
                <p><?php echo !empty($search) ? 'No patients match your search criteria.' : 'You have no patients yet.'; ?></p>
            </div>
        <?php else: ?>
            <div class="patient-grid">
                <?php foreach ($patients as $patient): ?>
                    <div class="patient-card">
                        <div class="patient-header">
                            <div class="patient-avatar">
                                <?php echo strtoupper(substr($patient['full_name'], 0, 1)); ?>
                            </div>
                            <div class="patient-info">
                                <h3 class="patient-name"><?php echo htmlspecialchars($patient['full_name']); ?></h3>
                                <p style="margin: 0; color: var(--light-text);">
                                    <i class="fas fa-phone"></i> <?php echo htmlspecialchars($patient['phone']); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="patient-stats">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $patient['appointment_count']; ?></div>
                                <div class="stat-label">Appointments</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <?php echo $patient['last_visit'] ? date('M d', strtotime($patient['last_visit'])) : 'N/A'; ?>
                                </div>
                                <div class="stat-label">Last Visit</div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="patient_records.php?id=<?php echo $patient['patient_id']; ?>" class="btn btn-primary">
                                <i class="fas fa-file-medical"></i> View Records
                            </a>
                            <a href="schedule_appointment.php?patient_id=<?php echo $patient['patient_id']; ?>" class="btn btn-secondary">
                                <i class="fas fa-calendar-plus"></i> Schedule
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 