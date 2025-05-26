<?php
require_once('includes/db_connect.php');

// New password to set
$new_password = 'admin1';
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

try {
    // Update both admin accounts
    $stmt = $con->prepare("UPDATE admin SET password = ? WHERE email IN ('admin@gmail.com', 'testadmin@gmail.com')");
    $stmt->bind_param("s", $hashed_password);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Admin passwords updated successfully.\n";
    } else {
        echo "No admin accounts updated.\n";
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 