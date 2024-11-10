<?php 
include('../config.php');
extract($_POST);

if(isset($save)) {
    // Check if the semester already exists for the selected department
    $que = mysqli_query($con, "SELECT * FROM semester WHERE semester_name = '$s' AND department_id = '$c'");
    $row = mysqli_num_rows($que);
    
    if($row) {
        $err = "<div class='alert alert-danger'>This semester already exists in the selected department.</div>";
    } else {
        // Insert the new semester into the database
        mysqli_query($con, "INSERT INTO semester VALUES (null, '$s', '$c')");
        $err = "<div class='alert alert-success'>Congrats! Your data has been saved.</div>";
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Add Semester</h2>

    <!-- Error message if any -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php echo @$err; ?>
        </div>
    </div>

    <!-- Add Semester Form -->
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="department" class="form-label">Select Department</label>
                    <select name="c" id="department" class="form-control">
                        <?php 
                        $dep = mysqli_query($con, "SELECT * FROM department");
                        while($dp = mysqli_fetch_array($dep)) {
                            $dp_id = $dp[0];
                            echo "<option value='$dp_id'>" . $dp[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="semester" class="form-label">Semester Name</label>
                    <input type="text" name="s" id="semester" class="form-control" required />
                </div>

                <div class="form-group text-center mb-3">
                    <button type="submit" name="save" class="btn btn-success">Add Semester</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
