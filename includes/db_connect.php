<?php
// Include common functions
require_once __DIR__ . '/functions.php';

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'wecare';

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Set charset to utf8mb4
$con->set_charset("utf8mb4");

// Function to get database connection
function get_db_connection() {
    global $con;
    return $con;
}

// Function to close database connection
function close_db_connection() {
    global $con;
    $con->close();
}

// Function to execute query and return result
function execute_query($query, $params = [], $types = '') {
    global $con;
    
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Query preparation failed: " . $con->error);
    }
    
    if (!empty($params)) {
        if (empty($types)) {
            $types = str_repeat('s', count($params));
        }
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}

// Function to execute query and return affected rows
function execute_update($query, $params = [], $types = '') {
    global $con;
    
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Query preparation failed: " . $con->error);
    }
    
    if (!empty($params)) {
        if (empty($types)) {
            $types = str_repeat('s', count($params));
        }
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    
    return $affected_rows;
}

// Function to get last insert ID
function get_last_insert_id() {
    global $con;
    return $con->insert_id;
}

// Function to escape string
function escape_string($string) {
    global $con;
    return $con->real_escape_string($string);
}

// Function to begin transaction
function begin_transaction() {
    global $con;
    $con->begin_transaction();
}

// Function to commit transaction
function commit_transaction() {
    global $con;
    $con->commit();
}

// Function to rollback transaction
function rollback_transaction() {
    global $con;
    $con->rollback();
}
?> 