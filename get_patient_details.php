<?php
require_once('config.php');

if (isset($_POST['patient_id'])) {
    $patient_id = (int)$_POST['patient_id'];
    
    $query = "SELECT * FROM patients WHERE patient_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Patient not found']);
    }
} else {
    echo json_encode(['error' => 'No patient ID provided']);
}
?> 