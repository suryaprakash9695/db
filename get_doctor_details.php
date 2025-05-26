<?php
require_once('config.php');

if (isset($_POST['doctor_id'])) {
    $doctor_id = (int)$_POST['doctor_id'];
    
    $query = "SELECT * FROM doctors WHERE doctor_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Doctor not found']);
    }
} else {
    echo json_encode(['error' => 'No doctor ID provided']);
}
?> 