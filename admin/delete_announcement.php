<?php
session_start();
include('../config.php');

// Check if the admin session is set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == "") {
    header("Location: login.php");
    exit;
}

// Check if an announcement id is provided for deletion
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Prepare SQL query to delete the announcement
    $query = "DELETE FROM announcements WHERE id = '$announcement_id'";

    if (mysqli_query($con, $query)) {
        // Redirect back to the manage announcements page with a success message
        echo "<script>alert('Announcement deleted successfully!'); window.location.href='manage_announcements.php';</script>";
    } else {
        // If there's an error in deletion
        echo "<script>alert('Error deleting announcement. Please try again!'); window.location.href='manage_announcements.php';</script>";
    }
} else {
    // If no id is provided, redirect back to the manage announcements page
    header("Location: manage_announcements.php");
    exit;
}
?>
