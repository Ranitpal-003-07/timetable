<option value="" selected="selected" disabled="disabled">Select subject</option>

<?php
include('../config.php');

// Check if sem_id is set and is a valid integer to prevent SQL injection
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sem_id = (int)$_GET['id'];  // Cast the sem_id to an integer for security

    // Use prepared statement to fetch subjects for the given semester ID
    $stmt = $con->prepare("SELECT * FROM subject WHERE sem_id = ?");
    $stmt->bind_param("i", $sem_id);  // Bind the parameter to avoid SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and display the subjects
    while ($res = $result->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($res['sem_id']) . "'>" . htmlspecialchars($res['subject_name']) . "</option>";
    }
} else {
    echo "<option value='' disabled>No subjects available</option>";
}
?>
