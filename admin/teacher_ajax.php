<option value="" selected="selected" disabled="disabled">Select Teacher</option>
<?php 
include('../config.php');

// Use prepared statement to avoid SQL injection
$stmt = $con->prepare("SELECT teacher_id, name FROM teacher WHERE department_id = ?");
$stmt->bind_param("i", $_GET['id']); // Bind the department_id from the URL parameter
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display teachers securely
while ($res = $result->fetch_assoc()) {
    echo "<option value='" . htmlspecialchars($res['teacher_id']) . "'>" . htmlspecialchars($res['name']) . "</option>";
}
?>
