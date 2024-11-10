<?php 
include('../config.php');

// Check if 'subject_id' is set in the request
if(isset($_REQUEST['subject_id'])) {
    // Sanitize the input to prevent SQL injection
    $subjectid = mysqli_real_escape_string($con, $_REQUEST['subject_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM subject WHERE subject_id='$subjectid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the subject page
        header('Location: admindashboard.php?info=subject');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'subject_id' is not set in the request, redirect to the subject page
    header('Location: admindashboard.php?info=subject');
    exit();
}
?>
