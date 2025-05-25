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
$appointments = [];
$error = '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

try {
    // Base query
    $query = "SELECT a.*, p.full_name as patient_name, p.phone as patient_phone, p.email as patient_email
              FROM appointments a 
              JOIN patients p ON a.patient_id = p.patient_id 
              WHERE a.doctor_id = ?";

    // Add filter conditions
    switch ($filter) {
        case 'upcoming':
            $query .= " AND a.appointment_date >= CURDATE() AND a.status != 'Cancelled'";
            break;
        case 'past':
            $query .= " AND a.appointment_date < CURDATE()";
            break;
        case 'cancelled':
            $query .= " AND a.status = 'Cancelled'";
            break;
    }

    // Add sorting
    switch ($sort) {
        case 'date_asc':
            $query .= " ORDER BY a.appointment_date ASC, a.appointment_time ASC";
            break;
        case 'date_desc':
            $query .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
            break;
        case 'patient':
            $query .= " ORDER BY p.full_name ASC";
            break;
        case 'status':
            $query .= " ORDER BY a.status ASC, a.appointment_date DESC";
            break;
    }

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
    error_log("Error in doctor_appointments.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - WeCare</title>
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

        .card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
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

        .appointment-card {
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .status-badge {
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
                    <i class="fas fa-calendar" style="color: var(--primary-color);"></i>
                    My Appointments
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    Manage and view all your appointments
                </p>
            </div>
            <a href="doctor_dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="background-color: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="card">
            <!-- Filters -->
            <div class="filters">
                <a href="?filter=all&sort=<?php echo $sort; ?>" 
                   class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                    All Appointments
                </a>
                <a href="?filter=upcoming&sort=<?php echo $sort; ?>" 
                   class="filter-btn <?php echo $filter === 'upcoming' ? 'active' : ''; ?>">
                    Upcoming
                </a>
                <a href="?filter=past&sort=<?php echo $sort; ?>" 
                   class="filter-btn <?php echo $filter === 'past' ? 'active' : ''; ?>">
                    Past
                </a>
                <a href="?filter=cancelled&sort=<?php echo $sort; ?>" 
                   class="filter-btn <?php echo $filter === 'cancelled' ? 'active' : ''; ?>">
                    Cancelled
                </a>
                <select class="sort-select" onchange="window.location.href='?filter=<?php echo $filter; ?>&sort='+this.value">
                    <option value="date_desc" <?php echo $sort === 'date_desc' ? 'selected' : ''; ?>>Sort by Date (Newest)</option>
                    <option value="date_asc" <?php echo $sort === 'date_asc' ? 'selected' : ''; ?>>Sort by Date (Oldest)</option>
                    <option value="patient" <?php echo $sort === 'patient' ? 'selected' : ''; ?>>Sort by Patient Name</option>
                    <option value="status" <?php echo $sort === 'status' ? 'selected' : ''; ?>>Sort by Status</option>
                </select>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (empty($appointments)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Appointments Found</h3>
                    <p>There are no appointments matching your current filter.</p>
                </div>
            <?php else: ?>
                <?php foreach ($appointments as $appointment): ?>
                    <div class="appointment-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h3 style="margin: 0 0 0.5rem;">
                                    <?php echo htmlspecialchars($appointment['patient_name']); ?>
                                </h3>
                                <p style="margin: 0.25rem 0; color: var(--light-text);">
                                    <i class="fas fa-calendar"></i> 
                                    <?php echo date('F d, Y', strtotime($appointment['appointment_date'])); ?>
                                </p>
                                <p style="margin: 0.25rem 0; color: var(--light-text);">
                                    <i class="fas fa-clock"></i> 
                                    <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?>
                                </p>
                                <p style="margin: 0.25rem 0; color: var(--light-text);">
                                    <i class="fas fa-phone"></i> 
                                    <?php echo htmlspecialchars($appointment['patient_phone']); ?>
                                </p>
                            </div>
                            <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                                <?php echo $appointment['status']; ?>
                            </span>
                        </div>
                        <div class="action-buttons">
                            <a href="view_appointment.php?id=<?php echo $appointment['appointment_id']; ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <?php if ($appointment['status'] === 'Scheduled'): ?>
                                <form method="POST" action="cancel_appointment.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this appointment? This action cannot be undone.');">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 