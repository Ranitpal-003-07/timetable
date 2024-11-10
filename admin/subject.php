<script>
    function deleteData(id) {
        if (confirm("Are you sure you want to delete this subject?")) {
            window.location.href = "deletesubject.php?subject_id=" + id;
        }
    }
</script>

<?php 
include('../config.php');

// Use prepared statements to fetch subjects securely
$stmt = $con->prepare("SELECT * FROM subject");
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="container mt-5">';
echo '<h1 class="text-center mb-4">Manage Subjects</h1>';

// Add New Subject Button
echo '<div class="text-end mb-3">';
echo '<a href="admindashboard.php?info=add_subject" class="btn btn-primary">Add New Subject</a>';
echo '</div>';

echo '<table class="table table-bordered table-hover">';
echo '<thead class="table-danger">';
echo '<tr>';
echo '<th>Subject ID</th>';
echo '<th>Subject Name</th>';
echo '<th>Semester</th>';
echo '<th>Department</th>';
echo '<th>Teacher</th>';
echo '<th>Lecture/Week</th>';
echo '<th>Type</th>';
echo '<th>Update</th>';
echo '<th>Delete</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($res = $result->fetch_assoc()) {
    // Fetch semester name using prepared statement
    $stmt1 = $con->prepare("SELECT semester_name FROM semester WHERE sem_id = ?");
    $stmt1->bind_param("i", $res['sem_id']);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $semester = $result1->fetch_assoc();

    // Fetch department name using prepared statement
    $stmt2 = $con->prepare("SELECT department_name FROM department WHERE department_id = ?");
    $stmt2->bind_param("i", $res['department_id']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $department = $result2->fetch_assoc();

    // Fetch teacher name using prepared statement
    $stmt3 = $con->prepare("SELECT name FROM teacher WHERE teacher_id = ?");
    $stmt3->bind_param("i", $res['teacher_id']);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $teacher = $result3->fetch_assoc();

    // Display subject data
    echo '<tr>';
    echo '<td>' . htmlspecialchars($res['subject_id']) . '</td>';
    echo '<td>' . htmlspecialchars($res['subject_name']) . '</td>';
    echo '<td>' . htmlspecialchars($semester['semester_name']) . '</td>';
    echo '<td>' . htmlspecialchars($department['department_name']) . '</td>';
    echo '<td>' . htmlspecialchars($teacher['name']) . '</td>';
    echo '<td>' . htmlspecialchars($res['lecture_per_week']) . '</td>';
    echo '<td>' . htmlspecialchars($res['type']) . '</td>';
    echo '<td><a href="admindashboard.php?info=updatesubject&subject_id=' . $res['subject_id'] . '" class="btn btn-warning btn-sm">Update</a></td>';
    echo '<td><button onclick="deleteData(' . $res['subject_id'] . ')" class="btn btn-danger btn-sm">Delete</button></td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';
?>
