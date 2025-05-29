<?php
require_once 'includes/db_connect.php';

// Function to store password as plain text
function store_password($password) {
    return $password;
}

try {
    // Check if doctor already exists
    $stmt = $con->prepare("SELECT * FROM doctors WHERE email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Doctor with this email already exists.";
    } else {
        // Insert new doctor
        $stmt = $con->prepare("INSERT INTO doctors (full_name, email, password, specialization, qualification, experience, license_no, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $plain_password = store_password($_POST['password']);
        $is_verified = 1;
        
        $stmt->bind_param("sssssisi", 
            $_POST['full_name'],
            $_POST['email'],
            $plain_password,
            $_POST['specialization'],
            $_POST['qualification'],
            $_POST['experience'],
            $_POST['license_no'],
            $is_verified
        );
        
        if ($stmt->execute()) {
            echo "Doctor account created successfully!";
        } else {
            echo "Error creating doctor account: " . $stmt->error;
        }
    }
    
    $stmt->close();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

$con->close();
?> 