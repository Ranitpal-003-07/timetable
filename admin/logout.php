<?php 
session_start();

// Destroy session securely
session_regenerate_id(true);  // Regenerate session ID to prevent session fixation attacks
unset($_SESSION['admin']);  // Remove session data for 'admin'

// Flash message for successful logout
$_SESSION['logout_message'] = "You have logged out successfully.";

// Redirect to the login page with a smooth transition
header('location:index.php');
exit;
?>
