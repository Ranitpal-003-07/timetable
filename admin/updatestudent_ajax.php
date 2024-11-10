<option value="" selected="selected" disabled="disabled">Select Semester</option>
<?php 
include('../config.php');

// Get department ID from the query parameter
$department_id = $_GET['id'];

// Use prepared statements to safely query the database
$stmt = $con->prepare("SELECT * FROM semester WHERE department_id = ?");
$stmt->bind_param("i", $department_id); // Bind the department ID as an integer
$stmt->execute();
$result = $stmt->get_result();

// Loop through the results and display them as options
while ($res = $result->fetch_assoc()) {
    echo "<option value='" . htmlspecialchars($res['sem_id']) . "'>" . htmlspecialchars($res['semester_name']) . "</option>";
}

$stmt->close();
?>
