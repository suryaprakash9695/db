<?php
require_once 'includes/db_connect.php';

$admin_id = 1; // Replace with actual admin ID
$new_password = 'admin123'; // New plain text password

try {
    $stmt = $con->prepare("UPDATE admin SET password = ? WHERE admin_id = ?");
    $stmt->bind_param("si", $new_password, $admin_id);
    
    if ($stmt->execute()) {
        echo "Admin password updated successfully!";
    } else {
        echo "Error updating password: " . $stmt->error;
    }
    
    $stmt->close();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

$con->close();
?> 