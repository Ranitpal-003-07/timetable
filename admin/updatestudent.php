<?php 
include('../config.php');

$stu_id = $_REQUEST['stu_id'];

// Using prepared statement to safely fetch student data
$stmt = $con->prepare("SELECT * FROM student WHERE stu_id = ?");
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (isset($_POST['update'])) {  
    $oldimg = $_GET['img'];
    
    // Check if the old image exists and delete it
    $old_image_path = "../student/image/$res[eid]/$oldimg";
    if (file_exists($old_image_path)) {
        unlink($old_image_path);
    }

    $image = $_FILES['pic']['name'];
    $target_dir = "../student/image/$res[eid]/";

    // Check if directory exists, create if not
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded image to the target directory
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['pic']['tmp_name'], $target_file);

    // Prepare data for the update query
    $name = $_POST['name'];
    $eid = $_POST['eid'];
    $p = $_POST['p'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $dob = $_POST['dob'];
    $gen = $_POST['gen'];
    $status = $_POST['status'];

    // Update the student record using a prepared statement
    $update_stmt = $con->prepare("UPDATE student SET name = ?, eid = ?, password = ?, mob = ?, address = ?, department_id = ?, sem_id = ?, dob = ?, pic = ?, gender = ?, status = ? WHERE stu_id = ?");
    $update_stmt->bind_param("sssssssssssi", $name, $eid, $p, $mobile, $address, $course, $semester, $dob, $image, $gen, $status, $_SESSION['stu_id']);
    $update_stmt->execute();
    $update_stmt->close();

    $err = "Records updated";
}
?>

<script>
function showSemester(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "updatestudent_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<div class="row">
    <div class="col-sm-8">
        <h2>Update Student</h2>
        <form method="POST" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td colspan="2"><?php echo @$err; ?></td>
                </tr>
                <tr>
                    <th scope="row">Department Name</th>
                    <td>
                        <select name="course" onChange="showSemester(this.value)" class="form-control">
                            <?php 
                            $cou = mysqli_query($con, "SELECT * FROM department");
                            while ($c = mysqli_fetch_array($cou)) {
                                $c_id = $c[0];
                                ?>
                                <option value='<?php echo $c_id; ?>' <?php if($c_id == $res['department_id']) echo "selected"; ?>>
                                    <?php echo htmlspecialchars($c[1]); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">Semester Name</th>
                    <td>
                        <select name="semester" id="semester" class="form-control">
                            <?php    
                            $sem = mysqli_query($con, "SELECT * FROM semester WHERE department_id='".$res['department_id']."'");
                            while ($s = mysqli_fetch_array($sem)) {
                                $s_id = $s[0];
                                ?>
                                <option value='<?php echo $s_id; ?>' <?php if ($s_id == $res['sem_id']) echo "selected"; ?>>
                                    <?php echo htmlspecialchars($s[1]); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">Student Name</th>
                    <td><input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?php echo htmlspecialchars($res['name']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your Email</th>
                    <td><input type="email" name="eid" class="form-control" placeholder="Enter your email" value="<?php echo htmlspecialchars($res['eid']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your Password</th>
                    <td><input type="password" name="p" class="form-control" placeholder="Enter your password" value="<?php echo htmlspecialchars($res['password']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your Mobile</th>
                    <td><input type="number" name="mobile" class="form-control" placeholder="Enter your mobile" value="<?php echo htmlspecialchars($res['mob']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your Address</th>
                    <td><input type="text" name="address" class="form-control" placeholder="Enter your address" value="<?php echo htmlspecialchars($res['address']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your D.O.B</th>
                    <td><input type="date" name="dob" class="form-control" placeholder="Enter your D.O.B" value="<?php echo htmlspecialchars($res['dob']); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row">Upload Your Pic</th>
                    <td><input type="file" name="pic" class="form-control" placeholder="Upload your pic" /></td>
                </tr>

                <tr>
                    <th scope="row">Enter Your Gender</th>
                    <td>
                        <input type="radio" value="m" name="gen" <?php if ($res['gender'] == "m") echo "checked"; ?> /> Male
                        <input type="radio" value="f" name="gen" <?php if ($res['gender'] == "f") echo "checked"; ?> /> Female
                    </td>
                </tr>

                <tr>
                    <th scope="row">Status</th>
                    <td><input type="text" name="status" class="form-control" placeholder="Enter your status" value="<?php echo htmlspecialchars($res['status']); ?>" /></td>
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
