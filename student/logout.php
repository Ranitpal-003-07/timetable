<?php 
session_start(); // Start the session

// Unset individual session variables
unset($_SESSION['stu_id']);
unset($_SESSION['name']);
unset($_SESSION['e_id']); // Make sure to unset all relevant session variables

// Destroy the entire session
session_destroy();

// Redirect to the home page
header('Location: index.php');
exit(); // It's a good practice to call exit after header redirection to stop further execution
?>
