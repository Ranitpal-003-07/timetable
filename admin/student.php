<?php
include('../config.php');

// Fetch student data using prepared statements
$stmt = $con->prepare("SELECT * FROM student");
$stmt->execute();
$students = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>

    <!-- Bootstrap CSS (for modern UI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function deleteData(id) {
            if (confirm("Are you sure you want to delete this student?")) {
                // AJAX call to delete the student without reloading the page
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "deletestudent.php?stu_id=" + id, true);
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        // Reload the page after successful deletion
                        alert("Student deleted successfully!");
                        location.reload();
                    } else {
                        alert("Failed to delete student.");
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Students</h1>

        <!-- Add New Student Button -->
        <div class="text-end mb-3">
            <a href="admindashboard.php?info=add_student" class="btn btn-primary">Add New Student</a>
        </div>

        <!-- Student Table -->
        <table class="table table-bordered table-hover">
            <thead class="table-danger">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>EID</th>
                    <th>Password</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>D.O.B</th>
                    <th>Profile Picture</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($res = $students->fetch_assoc()) {
                    // Fetch department and semester names using prepared statements
                    $deptStmt = $con->prepare("SELECT department_name FROM department WHERE department_id = ?");
                    $deptStmt->bind_param("i", $res['department_id']);
                    $deptStmt->execute();
                    $deptResult = $deptStmt->get_result();
                    $department = $deptResult->fetch_assoc();

                    $semStmt = $con->prepare("SELECT semester_name FROM semester WHERE sem_id = ?");
                    $semStmt->bind_param("i", $res['sem_id']);
                    $semStmt->execute();
                    $semResult = $semStmt->get_result();
                    $semester = $semResult->fetch_assoc();
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($res['stu_id']); ?></td>
                        <td><?php echo htmlspecialchars($res['name']); ?></td>
                        <td><?php echo htmlspecialchars($res['eid']); ?></td>
                        <td><?php echo htmlspecialchars($res['password']); ?></td>
                        <td><?php echo htmlspecialchars($res['mob']); ?></td>
                        <td><?php echo htmlspecialchars($res['address']); ?></td>
                        <td><?php echo htmlspecialchars($department['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($semester['semester_name']); ?></td>
                        <td><?php echo htmlspecialchars($res['dob']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($res['pic']); ?>" alt="Student Pic" class="img-fluid" style="max-width: 100px;"></td>
                        <td><?php echo htmlspecialchars($res['gender']); ?></td>
                        <td><?php echo htmlspecialchars($res['status']); ?></td>
                        <td>
                            <a href="admindashboard.php?info=updatestudent&stu_id=<?php echo htmlspecialchars($res['stu_id']); ?>" class="btn btn-warning btn-sm">Update</a>
                        </td>
                        <td>
                            <button onclick="deleteData('<?php echo htmlspecialchars($res['stu_id']); ?>')" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (for modal and other components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
