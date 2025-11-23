<?php


// Database connection settings for AWS EC2 MySQL
$host = "localhost";               // MySQL runs on the same EC2 server
$username = "clouduser";           // The user you created in MySQL
$password = "StrongPassword123!";  // The password you set
$database = "isd";                 // Your database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
