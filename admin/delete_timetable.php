<?php 
include('../config.php');

// Check if 'timeschedule_id' is set in the request
if(isset($_REQUEST['timeschedule_id'])) {
    // Sanitize the input to prevent SQL injection
    $tid = mysqli_real_escape_string($con, $_REQUEST['timeschedule_id']);
    
    // Perform the delete operation
    $query = "DELETE FROM timeschedule WHERE timeschedule_id='$tid'";

    if(mysqli_query($con, $query)) {
        // If the delete operation is successful, redirect to the timetable page
        header('Location: admindashboard.php?info=timetable');
        exit();
    } else {
        // If an error occurs, handle the error gracefully
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If 'timeschedule_id' is not set in the request, redirect to the timetable page
    header('Location: admindashboard.php?info=timetable');
    exit();
}
?>
