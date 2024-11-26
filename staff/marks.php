<?php
include('../config.php');  // Include database connection

// Check if student_id and subject_id are passed for updating
if (isset($_GET['student_id']) && isset($_GET['subject_id'])) {
    $student_id = $_GET['student_id'];
    $subject_id = $_GET['subject_id'];

    // Fetch existing marks data to populate the form
    $result = mysqli_query($con, "SELECT * FROM student_marks WHERE student_id = '$student_id' AND subject_id = '$subject_id'");
    $marks_data = mysqli_fetch_assoc($result);

    $existing_marks = $marks_data['marks'];
} else {
    $student_id = '';
    $subject_id = '';
    $existing_marks = '';
}

// Handle form submission to add or update marks
if (isset($_POST['save_marks'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $marks = $_POST['marks'];
    $teacher_id = $_SESSION['teacher_id'];  // Assuming teacher's ID is stored in session

    // Check if marks already exist for the student in the selected subject
    $check_query = mysqli_query($con, "SELECT * FROM student_marks WHERE student_id = '$student_id' AND subject_id = '$subject_id'");

    if (mysqli_num_rows($check_query) > 0) {
        // Update the existing marks record
        $update_query = mysqli_query($con, "UPDATE student_marks SET marks = '$marks', updated_by = '$teacher_id' WHERE student_id = '$student_id' AND subject_id = '$subject_id'");

        if ($update_query) {
            $err = "<div class='alert alert-success'>Marks have been updated successfully!</div>";
        } else {
            $err = "<div class='alert alert-danger'>Failed to update marks. Please try again.</div>";
        }
    } else {
        // Insert new marks
        $insert_query = mysqli_query($con, "INSERT INTO student_marks (student_id, subject_id, marks, updated_by) 
                                            VALUES ('$student_id', '$subject_id', '$marks', '$teacher_id')");
        if ($insert_query) {
            $err = "<div class='alert alert-success'>Marks have been added successfully!</div>";
        } else {
            $err = "<div class='alert alert-danger'>Failed to add marks. Please try again.</div>";
        }
    }
}

// Displaying data with a table
echo "<div class='container mt-5'>";
echo "<h3 class='text-center mb-4' style='color: black;'>Student Marks List</h3>";  // Heading in black color

// Add or Update Marks Form
echo "<div class='mb-3'>
        <h5>" . (isset($marks_data) ? "Update" : "Add") . " Marks</h5>
        <form method='POST' class='mb-4'>
            <div class='mb-3'>
                <label for='student_id' class='form-label'>Student ID</label>
                <input type='text' name='student_id' id='student_id' class='form-control' placeholder='Enter Student ID' value='$student_id' required />
            </div>
            <div class='mb-3'>
                <label for='subject_id' class='form-label'>Select Subject</label>
                <select name='subject_id' id='subject_id' class='form-select' required>
                    <option disabled selected>Select Subject</option>";
                    
// Fetch subjects to populate the dropdown
$subject_query = mysqli_query($con, "SELECT * FROM subject");
while ($subject = mysqli_fetch_array($subject_query)) {
    echo "<option value='" . $subject['subject_id'] . "'" . ($subject['subject_id'] == $subject_id ? ' selected' : '') . ">" . $subject['subject_name'] . "</option>";
}

echo "  </select>
            </div>
            <div class='mb-3'>
                <label for='marks' class='form-label'>Marks</label>
                <input type='number' name='marks' id='marks' class='form-control' placeholder='Enter Marks' value='$existing_marks' required />
            </div>
            <button type='submit' name='save_marks' class='btn btn-success'>" . (isset($marks_data) ? "Update Marks" : "Add Marks") . "</button>
        </form>
        " . @$err . "
      </div>";

// Display Add New Marks Button


// Marks Table
echo "<table class='table table-striped table-bordered table-hover'>";

// Table Header with black background
echo "<thead style='background-color: black; color: white;'> 
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Subject Name</th>
            <th>Marks</th>
            <th>Delete</th>
        </tr>
      </thead>";

echo "<tbody>";

// Fetching student marks data with JOIN to get student name and subject name
$que = mysqli_query($con, "
    SELECT sm.student_id, s.name AS student_name, sub.subject_name, sm.marks
    FROM student_marks sm
    JOIN student s ON sm.student_id = s.stu_id
    JOIN subject sub ON sm.subject_id = sub.subject_id
");

while ($res = mysqli_fetch_array($que)) {
    echo "<tr>";
    echo "<td>" . $res['student_id'] . "</td>";
    echo "<td>" . $res['student_name'] . "</td>";
    echo "<td>" . $res['subject_name'] . "</td>";
    echo "<td>" . $res['marks'] . "</td>";

    // Delete Button
    echo "<td><button class='btn btn-danger btn-sm' onclick='deleteMarks(" . $res['student_id'] . ", " . $res['subject_id'] . ")'>
              <i class='fas fa-trash'></i> Delete
          </button></td>";

    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
?>

<script>
// Function to confirm and handle deletion
function deleteMarks(student_id, subject_id) {
    if (confirm("Do you want to delete this student's marks?")) {
        // Send the delete request to the PHP file using fetch
        fetch("deletemarks.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "student_id=" + student_id + "&subject_id=" + subject_id  // Pass the student_id and subject_id to the PHP script
        })
        .then(response => response.text())  // Get the response from PHP
        .then(data => {
            // If the PHP response is "success", reload the page
            if (data === "success") {
                alert("Marks deleted successfully!");
                location.reload();  // Reload the page to reflect changes
            } else {
                alert("Failed to delete marks. Please try again.");
            }
        })
        .catch(error => {
            alert("Error occurred: " + error);
        });
    }
}
</script>

<!-- Add Bootstrap and FontAwesome for Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
