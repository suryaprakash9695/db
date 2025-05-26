<?php
require_once('config.php');

if (isset($_POST['appointment_id'])) {
    $appointment_id = (int)$_POST['appointment_id'];
    
    try {
        // Fetch appointment details with patient and doctor information
        $query = "SELECT a.*, 
                        p.full_name as patient_name, 
                        d.full_name as doctor_name, 
                        d.specialization,
                        d.license_no,
                        p.phone as patient_phone,
                        d.phone as doctor_phone,
                        a.reason,
                        a.notes,
                        a.preferred_communication
                 FROM appointments a 
                 JOIN patients p ON a.patient_id = p.patient_id 
                 JOIN doctors d ON a.doctor_id = d.doctor_id 
                 WHERE a.appointment_id = ?";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
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
            
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Appointment not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Appointment ID not provided']);
}
?> 