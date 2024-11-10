<?php 
include('../config.php');

$teacher_id = $_REQUEST['teacher_id'];

// Use prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);  // 'i' is for integer
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

extract($_POST);

if (isset($update)) {
    // Use prepared statement for updating data
    $stmt = $con->prepare("UPDATE teacher SET name = ?, eid = ?, password = ?, mob = ?, address = ?, department_id = ? WHERE teacher_id = ?");
    $stmt->bind_param("ssssiii", $n, $e, $p, $m, $a, $dep_id, $teacher_id);  // Binding parameters
    
    if ($stmt->execute()) {
        $err = "Records updated";
    } else {
        $err = "Error updating records";
    }

    $stmt->close();
}
?>

<div class="row">
    <div class="col-md-5">
        <h2>Update Teacher</h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="5" cellpadding="5" class="table">
                <tr>
                    <td colspan="2"><?php echo htmlspecialchars(@$err); ?></td>
                </tr>

                <tr>
                    <th width="237" scope="row">Select Department</th>
                    <td width="213">
                        <select name="dep_id" id="courseid" onchange="showSemester(this.value)" class="form-control">
                            <?php
                            $sub = mysqli_query($con, "SELECT * FROM department");
                            while ($s = mysqli_fetch_array($sub)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php echo ($s_id == $res['department_id']) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($s[1]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Teacher Name</th>
                    <td width="213">
                        <input type="text" name="n" class="form-control" value="<?php echo htmlspecialchars($res['name']); ?>" />
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Email</th>
                    <td width="213">
                        <input type="text" name="e" class="form-control" value="<?php echo htmlspecialchars($res['eid']); ?>" />
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Password</th>
                    <td width="213">
                        <input type="text" name="p" class="form-control" value="<?php echo htmlspecialchars($res['password']); ?>" />
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Mobile</th>
                    <td width="213">
                        <input type="text" name="m" class="form-control" value="<?php echo htmlspecialchars($res['mob']); ?>" />
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Address</th>
                    <td width="213">
                        <input type="text" name="a" class="form-control" value="<?php echo htmlspecialchars($res['address']); ?>" />
                    </td>
                </tr>

                <tr>
                    <th colspan="2" scope="row" align="center">
                        <input type="submit" value="Update Records" name="update" class="btn btn-success" />
                    </th>
                </tr>
            </table>
        </form>
    </div>
</div>
