<?php 
include('../config.php');

// Fetch the semester ID from the request
$sem_id = $_REQUEST['sem_id'];

// Use prepared statements to fetch data securely
$stmt = $con->prepare("SELECT * FROM semester WHERE sem_id = ?");
$stmt->bind_param("i", $sem_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Extract POST variables
extract($_POST);

// If the form is submitted
if (isset($update)) {    
    // Use prepared statement for updating the semester
    $stmt = $con->prepare("UPDATE semester SET semester_name = ?, department_id = ? WHERE sem_id = ?");
    $stmt->bind_param("sii", $s, $dep_id, $sem_id);
    $stmt->execute();
    $stmt->close();
    
    // Display success message
    $err = "Records updated";
}
?>

<div class="row">
    <div class="col-md-5">
        <h2>Update Semester</h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="5" cellpadding="5" class="table">
                <tr>
                    <td colspan="2"><?php echo @$err; ?></td>
                </tr>

                <!-- Department selection -->
                <tr>
                    <th width="237" scope="row">Select Department</th>
                    <td width="213">
                        <select name="dep_id" id="courseid" onchange="showSemester(this.value)" class="form-control">
                            <?php
                            // Fetch departments using prepared statement
                            $stmt = $con->prepare("SELECT * FROM department");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($s = $result->fetch_assoc()) {
                                $s_id = $s['department_id'];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php if ($s_id == $res['department_id']) { echo "selected"; } ?>>
                                    <?php echo htmlspecialchars($s['department_name']); ?>
                                </option>
                            <?php  
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Semester Name -->
                <tr>
                    <th width="237" scope="row">Semester Name</th>
                    <td width="213"><input type="text" name="s" class="form-control" value="<?php echo htmlspecialchars($res['semester_name']); ?>"/></td>
                </tr>

                <!-- Submit Button -->
                <tr>
                    <th colspan="2" scope="row" align="center">
                        <input type="submit" value="Update Records" name="update" class="btn btn-success"/>
                    </th>
                </tr>
            </table>
        </form>
    </div>
</div>
