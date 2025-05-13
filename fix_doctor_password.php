<?php
require_once('config.php');

// Function to check if a string is a valid bcrypt hash
function is_valid_bcrypt($hash) {
    return preg_match('/^\$2[ayb]\$[0-9]{2}\$[A-Za-z0-9\.\/]{53}$/', $hash);
}

try {
    // Get all doctors
    $stmt = $con->prepare("SELECT doctor_id, email, password FROM doctors");
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($doctor = $result->fetch_assoc()) {
        // Check if password is properly hashed
        if (!is_valid_bcrypt($doctor['password'])) {
            // If not properly hashed, update it with a new hash
            $new_password = "doctor123"; // Default password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            
            $update_stmt = $con->prepare("UPDATE doctors SET password = ? WHERE doctor_id = ?");
            $update_stmt->bind_param("si", $hashed_password, $doctor['doctor_id']);
            $update_stmt->execute();
            
            echo "Updated password for doctor ID: " . $doctor['doctor_id'] . " (Email: " . $doctor['email'] . ")<br>";
            echo "New password is: doctor123<br><br>";
        } else {
            echo "Password for doctor ID: " . $doctor['doctor_id'] . " is properly hashed.<br>";
        }
    }
    
    echo "<br>Password check completed.";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 