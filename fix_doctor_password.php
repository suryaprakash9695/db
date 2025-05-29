<?php
require_once 'includes/db_connect.php';

$doctor_id = 1; // Replace with actual doctor ID
$new_password = '123456'; // New plain text password

try {
    $stmt = $con->prepare("UPDATE doctors SET password = ? WHERE doctor_id = ?");
    $stmt->bind_param("si", $new_password, $doctor_id);
    
    if ($stmt->execute()) {
        echo "Doctor password updated successfully!";
    } else {
        echo "Error updating password: " . $stmt->error;
    }
    
    $stmt->close();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

$con->close();
?> 