<?php
require_once('config.php');

if (isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    
    $query = "SELECT bio, consultation_fee, available_days, start_time, end_time FROM doctors WHERE doctor_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode([
            'bio' => '',
            'consultation_fee' => '',
            'available_days' => '',
            'start_time' => '',
            'end_time' => ''
        ]);
    }
} else {
    echo json_encode(['error' => 'Doctor ID not provided']);
}
?> 