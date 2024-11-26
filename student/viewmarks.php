<?php

include("../config.php");
// Assuming the student's ID is stored in the session
$stu_id = $_SESSION['stu_id'];

// Fetching the marks from the database
$query = "SELECT sm.marks, sub.subject_name 
          FROM student_marks sm
          JOIN subject sub ON sm.subject_id = sub.subject_id
          WHERE sm.student_id = '$stu_id'";

$result = mysqli_query($con, $query);

// Check if there are any marks for the student
if (mysqli_num_rows($result) > 0) {
    echo "<h3>Your Marks</h3>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Subject</th><th>Marks</th></tr></thead>";
    echo "<tbody>";

    // Displaying the marks
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row['subject_name'] . "</td><td>" . $row['marks'] . "</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No marks found for your courses.</p>";
}
?>
