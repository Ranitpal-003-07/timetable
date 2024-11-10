<?php 
include('../config.php');

// Check if 'course_id' is set in the request
if(isset($_REQUEST['course_id'])) {
    // Sanitize the input to prevent SQL injection
    $courseid = mysqli_real_escape_string($con, $_REQUEST['course_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM department WHERE department_id='$courseid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the course page
        header('Location: admindashboard.php?info=course');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'course_id' is not set in the request, redirect to the course page
    header('Location: admindashboard.php?info=course');
    exit();
}
?>
