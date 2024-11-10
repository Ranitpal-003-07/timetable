<?php 
include('../config.php');

echo "<table border='1' class='table'>";

echo "<Tr>
<th><font color='#FFF'>Department</font></th>
<th><font color='#FFF'>Semester</font></th>
<th><font color='#FFF'>Subject Name</font></th>
<th><font color='#FFF'>Teacher Name</font></th>
<th><font color='#FFF'>Date</font></th>
<th><font color='#FFF'>Time</font></th>
</tr>";

// Get the user's semester ID
$que4 = mysqli_query($con, "SELECT * FROM student WHERE eid = '".$_SESSION['e_id']."'");
$res4 = mysqli_fetch_array($que4);

// Fetch the schedule based on the student's semester ID
$que = mysqli_query($con, "SELECT * FROM timeschedule WHERE semester_name = '".$res4['sem_id']."'");
while ($res = mysqli_fetch_array($que)) {
    echo "<Tr>";

    // Display department name
    $que22 = mysqli_query($con, "SELECT * FROM department WHERE department_id = '".$res['department_name']."'");
    $res22 = mysqli_fetch_array($que22);
    echo "<td style='color:white'>".$res22['department_name']."</td>";

    // Display semester name
    $que4 = mysqli_query($con, "SELECT * FROM semester WHERE sem_id = '".$res4['sem_id']."'");
    $res4 = mysqli_fetch_array($que4);
    echo "<td style='color:white'>".$res4['semester_name']."</td>";

    // Display subject name
    $que33 = mysqli_query($con, "SELECT * FROM subject WHERE subject_id = '".$res['subject_name']."'");
    $res33 = mysqli_fetch_array($que33);
    echo "<td style='color:white'>".$res33['subject_name']."</td>";

    // Display teacher name
    $que5 = mysqli_query($con, "SELECT * FROM teacher WHERE teacher_id = '".$res['teacher_id']."'");
    $res5 = mysqli_fetch_array($que5);
    echo "<td style='color:white'>".$res5['name']."</td>";

    // Display date and time
    echo "<td style='color:white'>".$res['date']."</td>";
    echo "<td style='color:white'>".$res['time']."</td>";
    
    echo "</tr>";
}

echo "</table>";	
?>
