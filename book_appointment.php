<?php
session_start();
require_once('config.php'); // Assumes config.php sets up the $con variable for DB connection

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$userId = $_SESSION['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorId = $_POST['doctor_id'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];
    $notes = $_POST['notes'];

    // Insert appointment into the database
    $stmt = $con->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $userId, $doctorId, $appointmentDate, $appointmentTime, $notes);

    if ($stmt->execute()) {
        $successMessage = "Appointment booked successfully!";
    } else {
        $errorMessage = "Failed to book the appointment. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center">Book Appointment</h3>
            <?php if (!empty($successMessage)) : ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php elseif (!empty($errorMessage)) : ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="doctor_id">Select Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                        <!-- Dynamically load doctors -->
                        <?php
                        $result = $con->query("SELECT id, name, specialization FROM doctors");
                        while ($doctor = $result->fetch_assoc()) {
                            echo "<option value='{$doctor['id']}'>{$doctor['name']} ({$doctor['specialization']})</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="appointment_time">Appointment Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Book Appointment</button>
            </form>
        </div>
    </div>
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
