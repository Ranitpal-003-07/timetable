<?php 
include('../config.php');

// Fetching the department_id from the request
$department_id = $_REQUEST['department_id'];

// Query to fetch the department details based on department_id
$q = mysqli_query($con, "SELECT * FROM department WHERE department_id = '$department_id'");
$res = mysqli_fetch_assoc($q);

// Extract POST data when form is submitted
extract($_POST);

// If the update button is clicked
if (isset($update)) {
    // Query to update the department name in the database
    mysqli_query($con, "UPDATE department SET department_name = '$c' WHERE department_id = '$department_id'");
    
    // Display a confirmation message
    $err = "Records updated";
}
?>

<div class="row">
    <div class="col-md-5">
        <h2>Update Course</h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="5" cellpadding="5" class="table">
                <tr>
                    <td colspan="2"><?php echo @$err; ?></td>
                </tr>
                
                <!-- Course Name input field -->
                <tr>
                    <th width="237" scope="row">Course Name</th>
                    <td width="213">
                        <input type="text" name="c" class="form-control" value="<?php echo $res['department_name']; ?>" />
                    </td>
                </tr>
                
                <!-- Submit button to update records -->
                <tr>
                    <th colspan="2" scope="row" align="center">
                        <input type="submit" value="Update Records" name="update" class="btn btn-success" />
                    </th>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>
