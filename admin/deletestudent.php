<?php 
include('../config.php');

// Check if 'stu_id' is set in the request
if(isset($_REQUEST['stu_id'])) {
    // Sanitize the input to prevent SQL injection
    $stuid = mysqli_real_escape_string($con, $_REQUEST['stu_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM student WHERE stu_id='$stuid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the student page
        header('Location: admindashboard.php?info=student');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'stu_id' is not set in the request, redirect to the student page
    header('Location: admindashboard.php?info=student');
    exit();
}
?>
