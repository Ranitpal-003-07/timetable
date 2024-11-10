<option value="" selected="selected" disabled="disabled">Select Subject</option>

<?php 
include('../config.php');

// Get the department ID from the URL parameter
$department_id = $_GET['id'];

// Use prepared statements for the query
$stmt = $con->prepare("SELECT * FROM semester WHERE department_id = ?");
$stmt->bind_param("i", $department_id);  // 'i' for integer (department_id)
$stmt->execute();
$result = $stmt->get_result();

while ($res = $result->fetch_assoc()) {
    echo "<option value='" . htmlspecialchars($res['sem_id']) . "'>" . htmlspecialchars($res['semester_name']) . "</option>";
}

$stmt->close();
?>
