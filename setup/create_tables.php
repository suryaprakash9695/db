<?php
require_once '../config.php';

// Read and execute the SQL file
$sql = file_get_contents('../sql/create_users_table.sql');

try {
    if ($con->multi_query($sql)) {
        echo "Users table created successfully!";
    } else {
        echo "Error creating users table: " . $con->error;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$con->close();
?> 