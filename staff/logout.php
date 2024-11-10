<?php 
session_start();

// Unset specific session variables
unset($_SESSION['teacher_id']);
unset($_SESSION['name']);

// Destroy the session completely
session_destroy();

// Redirect to the login page (or any other page)
header('location:index.php');
exit;
?>
