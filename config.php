<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Password for MySQL, leave empty if no password is set
$database = "drixylir"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
