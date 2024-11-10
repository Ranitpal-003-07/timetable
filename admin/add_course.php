<?php
include('../config.php');

// Initialize error message variable
$err = '';

if (isset($_POST['save'])) {
    // Sanitize and escape input to prevent SQL injection
    $department_name = mysqli_real_escape_string($con, $_POST['c']);

    // Check if department already exists
    $que = mysqli_query($con, "SELECT * FROM department WHERE department_name='$department_name'");
    $row = mysqli_num_rows($que);

    if ($row) {
        // Department already exists
        $err = "<div class='alert alert-danger' role='alert'>This department already exists.</div>";
    } else {
        // Insert new department
        $insert_query = mysqli_query($con, "INSERT INTO department (department_name) VALUES ('$department_name')");
        if ($insert_query) {
            // Success message
            $err = "<div class='alert alert-success' role='alert'>Congrats! Your data has been saved.</div>";
        } else {
            // Error in insertion
            $err = "<div class='alert alert-danger' role='alert'>An error occurred while saving data. Please try again.</div>";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Add Department</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="card p-4 shadow-sm">
                <!-- Display error or success message -->
                <?php echo $err; ?>

                <div class="mb-3">
                    <label for="department_name" class="form-label">Department Name</label>
                    <input type="text" name="c" id="department_name" class="form-control" required />
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" name="save" class="btn btn-success">Add Department</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS (for handling components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
