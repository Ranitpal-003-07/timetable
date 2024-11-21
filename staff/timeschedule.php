<?php 

echo '<table class="table table-bordered table-striped table-hover mt-4">';

echo '<thead class="table-dark text-center">
<tr>
    <th>Time Schedule ID</th>
    <th>Department</th>
    <th>Subject Name</th>
    <th>Semester Name</th>
    <th>Teacher Name</th>
    <th>Time</th>
    <th>Date</th>
</tr>
</thead>';

$que = mysqli_query($con, "SELECT * FROM timeschedule WHERE teacher_id = '".$_SESSION['teacher_id']."'");

echo '<tbody>';
while ($res = mysqli_fetch_array($que)) {
    echo '<tr>';

    echo '<td>'.$res['timeschedule_id'].'</td>';

    // Display department name
    $que2 = mysqli_query($con, "SELECT * FROM department WHERE department_id = '".$res['department_name']."'");
    $res2 = mysqli_fetch_array($que2);
    echo '<td>'.$res2['department_name'].'</td>';

    // Display subject name
    $que3 = mysqli_query($con, "SELECT * FROM subject WHERE subject_id = '".$res['subject_name']."'");
    $res3 = mysqli_fetch_array($que3);
    echo '<td>'.$res3['subject_name'].'</td>';

    // Display semester name
    $que4 = mysqli_query($con, "SELECT * FROM semester WHERE sem_id = '".$res['semester_name']."'");
    $res4 = mysqli_fetch_array($que4);
    echo '<td>'.$res4['semester_name'].'</td>';

    // Display teacher name
    $que5 = mysqli_query($con, "SELECT * FROM teacher WHERE teacher_id = '".$res['teacher_id']."'");
    $res5 = mysqli_fetch_array($que5);
    echo '<td>'.$res5['name'].'</td>';

    // Display time and date
    echo '<td>'.$res['time'].'</td>';
    echo '<td>'.$res['date'].'</td>';
    
    echo '</tr>';
}
echo '</tbody>';

echo '</table>';
?>
