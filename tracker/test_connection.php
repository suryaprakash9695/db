<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db/config.php';

echo "Testing database connection...<br>";

if ($con) {
    echo "Database connection successful!<br>";
    
    // Test if cycle_tracker table exists
    $result = $con->query("SHOW TABLES LIKE 'cycle_tracker'");
    if ($result->num_rows > 0) {
        echo "cycle_tracker table exists!<br>";
        
        // Show table structure
        $result = $con->query("DESCRIBE cycle_tracker");
        echo "Table structure:<br>";
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . " - " . $row['Type'] . "<br>";
        }
    } else {
        echo "cycle_tracker table does not exist!<br>";
        
        // Create the table
        $sql = "CREATE TABLE IF NOT EXISTS `cycle_tracker` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `last_period` date NOT NULL,
            `cycle_length` int(11) NOT NULL,
            `mood` varchar(50) DEFAULT NULL,
            `flow` varchar(50) DEFAULT NULL,
            `symptoms` json DEFAULT NULL,
            `notes` text DEFAULT NULL,
            `next_period` date NOT NULL,
            `fertile_start` date NOT NULL,
            `fertile_end` date NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        
        if ($con->query($sql)) {
            echo "cycle_tracker table created successfully!<br>";
        } else {
            echo "Error creating table: " . $con->error . "<br>";
        }
    }
} else {
    echo "Database connection failed!<br>";
    echo "Error: " . $con->connect_error . "<br>";
}
?> 