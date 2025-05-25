<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

// Check if appointment_id is provided
if (!isset($_POST['appointment_id'])) {
    $_SESSION['error'] = "Invalid request. Appointment ID is required.";
    header("Location: doctor_appointments.php");
    exit;
}

$appointment_id = $_POST['appointment_id'];
$doctor_id = $_SESSION['user_id'];

try {
    // First verify that the appointment belongs to this doctor
    $check_query = "SELECT * FROM appointments WHERE appointment_id = ? AND doctor_id = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("ii", $appointment_id, $doctor_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "You don't have permission to cancel this appointment.";
        header("Location: doctor_appointments.php");
        exit;
    }

    // Update the appointment status to Cancelled
    $update_query = "UPDATE appointments SET status = 'Cancelled' WHERE appointment_id = ? AND doctor_id = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("ii", $appointment_id, $doctor_id);
    
    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Appointment has been cancelled successfully.";
    } else {
        $_SESSION['error'] = "Failed to cancel the appointment. Please try again.";
    }

} catch (Exception $e) {
    $_SESSION['error'] = "An error occurred while cancelling the appointment.";
    error_log("Error in cancel_appointment.php: " . $e->getMessage());
}

header("Location: doctor_appointments.php");
exit;
?> 