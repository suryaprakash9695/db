<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the start of the request
error_log("get_appointment_details.php started");

require_once('config.php');

// Check if appointment_id is set
if (!isset($_POST['appointment_id'])) {
    error_log("No appointment_id provided");
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Appointment ID not provided']);
    exit;
}

$appointment_id = (int)$_POST['appointment_id'];
error_log("Processing appointment_id: " . $appointment_id);

try {
    // Check database connection
    if (!isset($con) || $con->connect_error) {
        throw new Exception("Database connection failed: " . ($con->connect_error ?? "Connection not established"));
    }

    // Fetch appointment details with patient and doctor information
    $query = "SELECT 
                a.appointment_id,
                a.appointment_date,
                a.appointment_time,
                a.status,
                a.reason,
                a.notes,
                a.preferred_communication,
                p.full_name as patient_name,
                p.phone as patient_phone,
                d.full_name as doctor_name,
                d.phone as doctor_phone,
                d.specialization,
                d.license_no
             FROM appointments a 
             INNER JOIN patients p ON a.patient_id = p.patient_id 
             INNER JOIN doctors d ON a.doctor_id = d.doctor_id 
             WHERE a.appointment_id = ?";
    
    error_log("Executing query: " . $query);
    
    $stmt = $con->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $con->error);
    }
    
    $stmt->bind_param("i", $appointment_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        error_log("Appointment found: " . json_encode($row));
        
        // Format the date and time
        $row['appointment_date'] = date('d M Y', strtotime($row['appointment_date']));
        $row['appointment_time'] = date('h:i A', strtotime($row['appointment_time']));
        
        // Ensure all fields have values
        $row['patient_name'] = $row['patient_name'] ?? 'Not specified';
        $row['doctor_name'] = $row['doctor_name'] ?? 'Not specified';
        $row['specialization'] = $row['specialization'] ?? 'Not specified';
        $row['reason'] = $row['reason'] ?? 'Not specified';
        $row['notes'] = $row['notes'] ?? 'No additional notes';
        $row['preferred_communication'] = $row['preferred_communication'] ?? 'Not specified';
        $row['patient_phone'] = $row['patient_phone'] ?? 'Not specified';
        $row['doctor_phone'] = $row['doctor_phone'] ?? 'Not specified';
        $row['license_no'] = $row['license_no'] ?? 'Not specified';
        
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($row);
        error_log("Successfully sent response");
    } else {
        error_log("No appointment found for ID: " . $appointment_id);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Appointment not found']);
    }
} catch (Exception $e) {
    error_log("Error in get_appointment_details.php: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?> 