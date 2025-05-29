<?php
require_once 'includes/db_connect.php';

$email = 'admin@wecare.com';
$password = 'admin123'; // Store plain text password

try {
    // Check if admin already exists
    $stmt = $con->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Admin with email $email already exists.";
    } else {
        // Insert new admin
        $stmt = $con->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        
        if ($stmt->execute()) {
            echo "Admin account created successfully!";
        } else {
            echo "Error creating admin account: " . $stmt->error;
        }
    }
    
    $stmt->close();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

$con->close();
?> 