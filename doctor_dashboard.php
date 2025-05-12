<?php
session_start();
require_once 'includes/db_connect.php';

// Redirect if not logged in as doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header('Location: doctor_login.php');
    exit();
}

$doctorId = $_SESSION['user_id'];
$doctorName = $_SESSION['user_name'];

// Fetch upcoming appointments
$appointments = [];
try {
    $stmt = $pdo->prepare("SELECT a.*, p.full_name as patient_name, p.email as patient_email, p.phone as patient_phone
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        WHERE a.doctor_id = ? AND a.appointment_date >= CURDATE()
        ORDER BY a.appointment_date ASC, a.appointment_time ASC
        LIMIT 5");
    $stmt->execute([$doctorId]);
    $appointments = $stmt->fetchAll();
} catch (Exception $e) {
    $appointments = [];
}

// Fetch recent patients (last 5 unique patients)
$recent_patients = [];
try {
    $stmt = $pdo->prepare("SELECT DISTINCT p.patient_id, p.full_name, p.email, p.phone
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        WHERE a.doctor_id = ?
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
        LIMIT 5");
    $stmt->execute([$doctorId]);
    $recent_patients = $stmt->fetchAll();
} catch (Exception $e) {
    $recent_patients = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2>Welcome, Dr. <?php echo htmlspecialchars($doctorName); ?>!</h2>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Upcoming Appointments</h5>
                </div>
                <div class="card-body">
                    <?php if (count($appointments) > 0): ?>
                        <ul class="list-group">
                            <?php foreach ($appointments as $appt): ?>
                                <li class="list-group-item">
                                    <strong><?php echo htmlspecialchars($appt['patient_name']); ?></strong><br>
                                    Date: <?php echo htmlspecialchars($appt['appointment_date']); ?> <br>
                                    Time: <?php echo htmlspecialchars($appt['appointment_time']); ?> <br>
                                    Email: <?php echo htmlspecialchars($appt['patient_email']); ?> <br>
                                    Phone: <?php echo htmlspecialchars($appt['patient_phone']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No upcoming appointments.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Recent Patients</h5>
                </div>
                <div class="card-body">
                    <?php if (count($recent_patients) > 0): ?>
                        <ul class="list-group">
                            <?php foreach ($recent_patients as $pat): ?>
                                <li class="list-group-item">
                                    <strong><?php echo htmlspecialchars($pat['full_name']); ?></strong><br>
                                    Email: <?php echo htmlspecialchars($pat['email']); ?> <br>
                                    Phone: <?php echo htmlspecialchars($pat['phone']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent patients.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
            <a href="doctor_logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html> 