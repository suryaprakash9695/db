<?php
require_once('includes/db_connect.php');

// New admin credentials
$email = 'test@admin.com';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    // First check if admin already exists
    $stmt = $con->prepare("SELECT COUNT(*) FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Update existing admin
        $stmt = $con->prepare("UPDATE admin SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();
        echo "Admin password updated successfully.\n";
    } else {
        // Create new admin
        $stmt = $con->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();
        echo "New admin account created successfully.\n";
    }
    
    echo "Admin credentials:\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $password . "\n";
    echo "Hashed password: " . $hashed_password . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 