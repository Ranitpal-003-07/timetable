<option value="" selected="selected" disabled="disabled">Select semester</option>
<?php 
include('../config.php');

// Use prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM semester WHERE department_id = ?");
$stmt->bind_param("i", $_GET['id']);  // 'i' is for integer
$stmt->execute();
$result = $stmt->get_result();

while ($res = $result->fetch_assoc()) {
    echo "<option>" . htmlspecialchars($res['semester_name']) . "</option>";
}

$stmt->close();
?>
