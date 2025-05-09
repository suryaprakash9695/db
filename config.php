<?php
// config.php

$servername = "localhost";  // Change if you have a different host (e.g., for remote databases)
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (empty for local default)
$dbname = "wecare";         // Your database name

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
