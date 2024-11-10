<option value="" selected="selected" disabled="disabled">Select Semester</option>
<?php 
include('../config.php');

// Ensure the 'id' parameter is sanitized to prevent SQL injection
$department_id = $_GET['id'];

// Use a prepared statement to fetch semesters based on the department_id
$stmt = $con->prepare("SELECT sem_id, semester_name FROM semester WHERE department_id = ?");
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display the options for semesters
while ($res = $result->fetch_assoc()) {
    echo "<option value='" . $res['sem_id'] . "'>" . $res['semester_name'] . "</option>";
}

// Close the statement to free up resources
$stmt->close();
?>
