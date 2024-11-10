<?php
include('../config.php');

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Using prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM semester WHERE department_id = ?");
    $stmt->bind_param("i", $_GET['id']); // 'i' indicates the parameter is an integer

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if($result->num_rows > 0) {
        echo "<option value='' selected='selected' disabled='disabled'>Select Semester</option>";

        // Loop through the results and output them as options
        while($res = $result->fetch_assoc()) {
            // Sanitize the output before displaying
            $semesterName = htmlspecialchars($res['semester_name'], ENT_QUOTES, 'UTF-8');
            $semId = htmlspecialchars($res['sem_id'], ENT_QUOTES, 'UTF-8');

            echo "<option value='".$semId."'>".$semesterName."</option>";
        }
    } else {
        // If no semesters found, you can display an appropriate message
        echo "<option value='' disabled>No semesters available</option>";
    }

    // Close the statement
    $stmt->close();
} else {
    // If 'id' is not set or invalid
    echo "<option value='' disabled>Invalid department ID</option>";
}
?>
