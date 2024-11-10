<?php 
include('../config.php');

// Check if 'sem_id' is set in the request
if(isset($_REQUEST['sem_id'])) {
    // Sanitize the input to prevent SQL injection
    $semesterid = mysqli_real_escape_string($con, $_REQUEST['sem_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM semester WHERE sem_id='$semesterid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the semester page
        header('Location: admindashboard.php?info=semester');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'sem_id' is not set in the request, redirect to the semester page
    header('Location: admindashboard.php?info=semester');
    exit();
}
?>
