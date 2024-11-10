<?php 
// Enable error reporting for debugging purposes
error_reporting(1);

// Establish a connection to the MySQL database
$con = mysqli_connect("localhost", "root", "", "timetable");

// Check if the connection was successful
if (!$con) {
    // If the connection fails, display an error message
    die("Connection failed: " . mysqli_connect_error());
}
?>
