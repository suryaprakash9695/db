<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: ../doctor_login.php");
    exit;
}

$doctorId = $_SESSION['user_id'];

// Get all patients who have appointments with this doctor
$stmt = $con->prepare("
    SELECT DISTINCT p.*, 
           COUNT(DISTINCT a.appointment_id) as total_appointments,
           MAX(a.appointment_date) as last_visit
    FROM patients p
    JOIN appointments a ON p.patient_id = a.patient_id
    WHERE a.doctor_id = ?
    GROUP BY p.patient_id
    ORDER BY p.full_name ASC
");
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$patients = $stmt->get_result();

// Handle patient search
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $search = "%$search%";
    $stmt = $con->prepare("
        SELECT DISTINCT p.*, 
               COUNT(DISTINCT a.appointment_id) as total_appointments,
               MAX(a.appointment_date) as last_visit
        FROM patients p
        JOIN appointments a ON p.patient_id = a.patient_id
        WHERE a.doctor_id = ? AND (p.full_name LIKE ? OR p.email LIKE ? OR p.phone LIKE ?)
        GROUP BY p.patient_id
        ORDER BY p.full_name ASC
    ");
    $stmt->bind_param("isss", $doctorId, $search, $search, $search);
    $stmt->execute();
    $patients = $stmt->get_result();
}

$schedule_result = $stmt->get_result();
$schedule = [];
while ($row = $schedule_result->fetch_assoc()) {
    $schedule[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - WeCare</title>
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

        .patients-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .patient-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            padding: 1.5rem;
        }

        .patient-header {
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }

        .patient-details {
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-view {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-chat {
            background-color: var(--success-color);
            color: white;
        }

        .btn-appointment {
            background-color: var(--secondary-color);
            color: white;
        }

        .stats-badge {
            background-color: #e3f2fd;
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .last-visit {
            color: var(--light-text);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="patients-header">
                <h2>Patients List</h2>
                <p class="text-muted">View and manage your patients</p>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="search" placeholder="Search patients by name, email, or phone..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Patients List -->
            <?php while ($patient = $patients->fetch_assoc()): ?>
                <div class="patient-card">
                    <div class="patient-header">
                        <div class="patient-info">
                            <img src="../<?php echo $patient['profile_image'] ?? 'assets/images/default-profile.png'; ?>" 
                                 alt="Patient" class="patient-image">
                            <div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($patient['full_name']); ?></h5>
                                <small class="text-muted">Patient ID: <?php echo $patient['patient_id']; ?></small>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <a href="patient_details.php?id=<?php echo $patient['patient_id']; ?>" class="btn-action btn-view">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="chat.php?patient=<?php echo $patient['patient_id']; ?>" class="btn-action btn-chat">
                                <i class="fas fa-comments"></i> Chat
                            </a>
                            <a href="appointments.php?patient=<?php echo $patient['patient_id']; ?>" class="btn-action btn-appointment">
                                <i class="fas fa-calendar-plus"></i> New Appointment
                            </a>
                        </div>
                    </div>
                    
                    <div class="patient-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlspecialchars($patient['email']); ?></span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($patient['phone']); ?></span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <span class="stats-badge">
                                <?php echo $patient['total_appointments']; ?> Appointments
                            </span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span class="last-visit">
                                Last Visit: <?php echo $patient['last_visit'] ? date('M d, Y', strtotime($patient['last_visit'])) : 'Never'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 