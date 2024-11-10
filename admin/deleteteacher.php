<?php 
include('../config.php');

// Check if 'teacher_id' is set in the request
if(isset($_REQUEST['teacher_id'])) {
    // Sanitize the input to prevent SQL injection
    $teacherid = mysqli_real_escape_string($con, $_REQUEST['teacher_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM teacher WHERE teacher_id='$teacherid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the teacher page
        header('Location: admindashboard.php?info=teacher');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'teacher_id' is not set in the request, redirect to the teacher page
    header('Location: admindashboard.php?info=teacher');
    exit();
}
?>
