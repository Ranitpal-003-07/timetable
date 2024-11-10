<?php 
include('../config.php');
$stu_id = $_REQUEST['stu_id'];
$email = $_SESSION['e_id']; // Current session email
$q = mysqli_query($con, "SELECT * FROM student WHERE stu_id='" . $_SESSION['stu_id'] . "'");
$res = mysqli_fetch_array($q);
extract($_POST);

if (isset($update)) {
    // Remove old image
    $oldimg = $_GET['img'];
    unlink("image/$email/$oldimg");

    // Get the new image file name
    $image = $_FILES['pic']['name'];	

    // Update student record in the database
    mysqli_query($con, "UPDATE student SET name='$name', eid='$eid', password='$p', mob='$mobile', address='$address', department_id='$course', sem_id='$semester', dob='$dob', pic='$image', gender='$gen', status='$status' WHERE stu_id='" . $_SESSION['stu_id'] . "'");

    // Create directory for the student if it doesn't exist
    mkdir("../student/image/$eid");

    // Move the uploaded image to the directory
    move_uploaded_file($_FILES['pic']['tmp_name'], "../student/image/$eid/" . $_FILES['pic']['name']);

    $err = "Records updated";
}
?>

<script>
function showSemester(str)
{
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "updatestudent_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<div class="row">
    <div class="col-sm-8">
        <h2><font color="#FFFFFF">Update Student Profile</font></h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" class="table">
                <tr>
                    <td colspan="2"><?php echo @$err; ?></td>
                </tr>

                <tr>
                    <th width="237" scope="row"><font color="#FFFFFF" size="+2">Department Name</font></th>
                    <td width="213">
                        <select name="course" onChange="showSemester(this.value)" class="form-control">
                            <?php 
                            $cou = mysqli_query($con, "SELECT * FROM department");
                            while ($c = mysqli_fetch_array($cou)) {
                                $c_id = $c[0];
                            ?>
                                <option value='<?php echo $c_id; ?>' <?php if ($c_id == $res['department_id']) { echo "selected"; } ?>>
                                    <?php echo $c[1]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row"><font color="#FFFFFF" size="+2">Semester Name</font></th>
                    <td width="213">
                        <select name="semester" id="semester" class="form-control">
                            <?php 
                            $sem = mysqli_query($con, "SELECT * FROM semester WHERE department_id='" . $res['department_id'] . "'");
                            while ($s = mysqli_fetch_array($sem)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php if ($s_id == $res['sem_id']) { echo "selected"; } ?>>
                                    <?php echo $s[1]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row"><font color="#FFFFFF" size="+2">Student Name</font></th>
                    <td width="213"><input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?php echo $res['name']; ?>"/></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Email</font></th>
                    <td><input type="email" name="eid" class="form-control" placeholder="Enter your email" value="<?php echo $res['eid']; ?>" /></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Password</font></th>
                    <td><input type="password" name="p" class="form-control" placeholder="Enter your password" value="<?php echo $res['password']; ?>" /></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Mobile</font></th>
                    <td><input type="number" name="mobile" class="form-control" placeholder="Enter your mobile" value="<?php echo $res['mob']; ?>"/></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Address</font></th>
                    <td><input type="text" name="address" class="form-control" placeholder="Enter your address" value="<?php echo $res['address']; ?>" /></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your D.O.B</font></th>
                    <td><input type="date" name="dob" class="form-control" placeholder="Enter your D.O.B" value="<?php echo $res['dob']; ?>"/></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Pic</font></th>
                    <td><input type="file" name="pic" class="form-control" placeholder="Enter your pic" value="<?php echo $res['pic']; ?>"/></td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Enter Your Gender</font></th>
                    <td><font color="#FFFFFF">Male</font>
                        <input type="radio" value="m" id="gen" name="gen" <?php if ($res['gender'] == "m") { echo "checked"; } ?> />
                        <font color="#FFFFFF">Female</font>
                        <input type="radio" value="f" id="gen" name="gen" <?php if ($res['gender'] == "f") { echo "checked"; } ?> />
                    </td>
                </tr>

                <tr>
                    <th scope="row"><font color="#FFFFFF" size="+2">Status</font></th>
                    <td><input type="text" name="status" class="form-control" placeholder="Enter your status" value="<?php echo $res['status']; ?>"/></td>
                </tr>

                <tr>
                    <th colspan="2" scope="row" align="center">
                        <input type="submit" value="Update Records" name="update" class="btn btn-success"/>
                    </th>
                </tr>
            </table>
        </form>
    </div>
</div>
