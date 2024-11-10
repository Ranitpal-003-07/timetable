<script>
    // Function to confirm and handle deletion
    function deleteData(id) {
        if (confirm("Do you want to delete this course?")) {
            window.location.href = "deletecourse.php?course_id=" + id;
        }
    }
</script>

<?php
include('../config.php');

// Displaying data with a table
echo "<div class='container mt-5'>";
echo "<h3 class='text-center mb-4' style='color: black;'>Department List</h3>";  // Heading in black color

// Add New Department Button
echo "<div class='mb-3 text-end'>
        <a href='admindashboard.php?info=add_course' class='btn btn-primary'>
            <i class='fas fa-plus'></i> Add New Department
        </a>
      </div>";

// Department Table
echo "<table class='table table-striped table-bordered table-hover'>";

// Table Header with black background
echo "<thead style='background-color: black; color: white;'> 
        <tr>
            <th>ID</th>
            <th>Department Name</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
      </thead>";

echo "<tbody>";

// Fetching department data from the database
$que = mysqli_query($con, "SELECT * FROM department");

while ($res = mysqli_fetch_array($que)) {
    echo "<tr>";
    echo "<td>" . $res['department_id'] . "</td>";
    echo "<td>" . $res['department_name'] . "</td>";

    // Update Button
    echo "<td><a href='admindashboard.php?info=updatecourse&department_id=" . $res['department_id'] . "' class='btn btn-warning btn-sm'>
              <i class='fas fa-edit'></i> Update
          </a></td>";

    // Delete Button
    echo "<td><button class='btn btn-danger btn-sm' onclick='deleteData(" . $res['department_id'] . ")'>
              <i class='fas fa-trash'></i> Delete
          </button></td>";

    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
?>

<!-- Add Bootstrap and FontAwesome for Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
