<script>
    function deleteData(id) {
        if (confirm("Are you sure you want to delete this semester?")) {
            // Use AJAX to delete data without reloading the page
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "deletesemester.php?sem_id=" + id, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // Reload the page after successful deletion
                    alert("Semester deleted successfully!");
                    location.reload();
                } else {
                    alert("Failed to delete semester.");
                }
            };
            xhr.send();
        }
    }
</script>

<?php
include('../config.php');

// Start the table with Bootstrap classes for better design
echo "<table class='table table-striped table-bordered'>";

// Table heading
echo "<thead class='thead-dark'>
        <tr>
            <th colspan='5' class='text-center'>
                <a href='admindashboard.php?info=add_semester' class='btn btn-success btn-sm'>Add New Semester</a>
            </th>
        </tr>
        <tr>
            <th>Sem Id</th>
            <th>Semester</th>
            <th>Department</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
      </thead>";

// Table body
echo "<tbody>";

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM semester");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($res = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($res['sem_id']) . "</td>";
        echo "<td>" . htmlspecialchars($res['semester_name']) . "</td>";

        // Display department name by querying the department table
        $deptStmt = $con->prepare("SELECT department_name FROM department WHERE department_id = ?");
        $deptStmt->bind_param("i", $res['department_id']);
        $deptStmt->execute();
        $deptResult = $deptStmt->get_result();
        $department = $deptResult->fetch_assoc();

        echo "<td>" . htmlspecialchars($department['department_name']) . "</td>";

        // Update and Delete buttons
        echo "<td><a href='admindashboard.php?info=updatesemester&sem_id=" . htmlspecialchars($res['sem_id']) . "' class='btn btn-warning btn-sm'>Update</a></td>";
        echo "<td><a href='javascript:void(0);' onclick='deleteData(" . htmlspecialchars($res['sem_id']) . ")' class='btn btn-danger btn-sm'>Delete</a></td>";
        echo "</tr>";
    }

echo "</tbody>";
echo "</table>";
?>
