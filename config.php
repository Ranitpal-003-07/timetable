<?php 
error_reporting(1);

$con = mysqli_connect("localhost", "root", "", "timetable");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
