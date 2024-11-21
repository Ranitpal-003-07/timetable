<?php
// Include necessary files for database connection and timetable generation
include('../config.php');
include("timetablegen.php"); // Assumes this file sets $generatedTimetable based on logic

// Initialize an error message variable and success message flag
$err = "";
$updated = false;

// Check if the timetable has been generated
if (isset($_GET['generated']) && !empty($_GET['generated'])) {
    echo "<form method='POST' action=''>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead class='thead-dark'>";
    echo "<tr><th>Days/Lecture</th><th>Lecture 1</th><th>Lecture 2</th><th>Lecture 3</th><th>Lecture 4</th><th>Lecture 5</th><th>Lecture 6</th><th>Action</th></tr>";
    echo "</thead><tbody>";

    // Assuming $generatedTimetable is set in timetablegen.php
    foreach ($generatedTimetable as $day => $lectures) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($day) . "</td>";

        // Loop through lectures for each day and display them in input fields for updates
        for ($i = 0; $i < 6; $i++) {
            $lecture = isset($lectures[$i]) ? htmlspecialchars($lectures[$i]) : "No Lecture";
            echo "<td><input type='text' name='lecture[$day][$i]' value='$lecture' class='form-control' /></td>";
        }

        // Add a column for the update button specific to each day
        echo "<td><button type='submit' name='update[$day]' class='btn btn-primary'>Update</button></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</form>";
}

// Handle updates to the timetable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['update'] as $day => $lectures) {
        foreach ($lectures as $period => $lecture) {
            // Update the timetable in the database using a prepared statement
            $stmt = $con->prepare("UPDATE timetable SET lecture = ? WHERE day = ? AND period = ?");
            $stmt->bind_param('ssi', $lecture, $day, $period);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Set success message
    $updated = true;
}

// Display success message after update
if ($updated) {
    echo "<div class='alert alert-success'>Timetable has been updated successfully!</div>";
}

?>

<!-- Optional JavaScript for extra functionality (e.g., confirmation dialogs) -->
<script>
// JavaScript can be added here for additional functionality if needed
</script>

<style>
    /* Optional CSS for styling */
    .container { max-width: 900px; margin: 0 auto; }
    .table th, .table td { text-align: center; padding: 10px; }
    .table-bordered { border: 1px solid #ddd; }
    .table-hover tbody tr:hover { background-color: #f5f5f5; }
</style>