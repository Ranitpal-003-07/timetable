<script>
    function deleteData(id) {
        if (confirm("Are you sure you want to delete this teacher?")) {
            window.location.href = "deleteteacher.php?teacher_id=" + id;
        }
    }
</script>

<?php 
include('../config.php');

// Fetch teacher data securely using prepared statements
$stmt = $con->prepare("SELECT * FROM teacher");
$stmt->execute();
$result = $stmt->get_result();

echo "<table class='table table-bordered table-hover'>";

// Add New Teacher Button
echo "<tr class='table-danger'><th colspan='11'><a href='admindashboard.php?info=add_teacher' class='btn btn-primary'>Add New Teacher</a></th></tr>";

// Table headers
echo "<tr><th>Teacher Id</th><th>Teacher Name</th><th>EID</th><th>Password</th><th>Mobile</th><th>Address</th><th>Department</th><th>Update</th><th>Delete</th></tr>";

while ($res = $result->fetch_assoc()) {
    // Fetch department name
    $deptStmt = $con->prepare("SELECT department_name FROM department WHERE department_id = ?");
    $deptStmt->bind_param("i", $res['department_id']);
    $deptStmt->execute();
    $deptResult = $deptStmt->get_result();
    $dept = $deptResult->fetch_assoc();

    // Table row for each teacher
    echo "<tr>";
    echo "<td>" . htmlspecialchars($res['teacher_id']) . "</td>";
    echo "<td>" . htmlspecialchars($res['name']) . "</td>";
    echo "<td>" . htmlspecialchars($res['eid']) . "</td>";
    echo "<td>" . htmlspecialchars($res['password']) . "</td>";
    echo "<td>" . htmlspecialchars($res['mob']) . "</td>";
    echo "<td>" . htmlspecialchars($res['address']) . "</td>";
    echo "<td>" . htmlspecialchars($dept['department_name']) . "</td>";

    // Update and Delete actions
    echo "<td><a href='admindashboard.php?info=updateteacher&teacher_id=" . $res['teacher_id'] . "' class='btn btn-warning btn-sm'>Update</a></td>";
    echo "<td><button onclick='deleteData(\"" . $res['teacher_id'] . "\")' class='btn btn-danger btn-sm'>Delete</button></td>";

    echo "</tr>";
}

echo "</table>";
?>
