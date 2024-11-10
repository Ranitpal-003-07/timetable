<?php 
include('../config.php');

$subject_id = $_REQUEST['subject_id'];

// Use prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM subject WHERE subject_id = ?");
$stmt->bind_param("i", $subject_id);  // 'i' is for integer
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

extract($_POST);

if (isset($update)) {  
    // Use prepared statement for updating data
    $stmt = $con->prepare("UPDATE subject SET subject_name = ?, sem_id = ?, department_id = ?, teacher_id = ?, lecture_per_week = ?, type = ? WHERE subject_id = ?");
    $stmt->bind_param("siisis", $subname, $s, $course, $t, $lpw, $type, $subject_id);  // Binding parameters
    
    if ($stmt->execute()) {
        echo "Records updated";
    } else {
        echo "Error updating records";
    }
    
    $stmt->close();
}
?>

<script>
function showOpts(str) {
    showSemester(str);
    showTeacher(str);
}

function showSemester(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "semester_ajax.php?id=" + str, true);
    xmlhttp.send();
}

function showTeacher(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() {
        if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
            document.getElementById("teacher").innerHTML = xmlhttp2.responseText;
        }
    };
    xmlhttp2.open("GET", "teacher_ajax.php?id=" + str, true);
    xmlhttp2.send();
}
</script>

<div class="row">
    <div class="col-sm-8">
        <h2>Update Subject</h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" class="table">
                <tr>
                    <td colspan="2"><?php echo htmlspecialchars(@$err); ?></td>
                </tr>
                <tr>
                    <th width="237" scope="row">Department Name</th>
                    <td width="213">
                        <select name="course" id="courseid" onChange="showOpts(this.value)" class="form-control">
                            <?php
                            $cou = mysqli_query($con, "SELECT * FROM department");
                            while ($c = mysqli_fetch_array($cou)) {
                                $c_id = $c[0];
                            ?>
                                <option value='<?php echo $c_id; ?>' <?php echo ($c_id == $res['department_id']) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($c[1]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="237" scope="row">Semester Name</th>
                    <td width="213">
                        <select name="s" id="semester" class="form-control">
                            <?php
                            $sem = mysqli_query($con, "SELECT * FROM semester WHERE department_id='" . $res['department_id'] . "'");
                            while ($s = mysqli_fetch_array($sem)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php echo ($s_id == $res['sem_id']) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($s[1]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Select Teacher</th>
                    <td width="213">
                        <select name="t" id="teacher" class="form-control">
                            <option disabled selected>Select Teacher</option>
                            <?php
                            $sub = mysqli_query($con, "SELECT * FROM teacher WHERE department_id='" . $res['department_id'] . "'");
                            while ($s = mysqli_fetch_array($sub)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php echo ($s_id == $res['teacher_id']) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($s[1]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="237" scope="row">Subject Name</th>
                    <td width="213">
                        <input type="text" name="subname" class="form-control" value="<?php echo htmlspecialchars($res['subject_name']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th width="237" scope="row">Lecture/Week</th>
                    <td width="213">
                        <input type="number" name="lpw" value="<?php echo htmlspecialchars($res['lecture_per_week']); ?>" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <th width="237" scope="row">Type</th>
                    <td width="213">
                        <input class="form-check-input" type="radio" name="type" value="Theory" <?php echo ($res['type'] === "Theory") ? "checked" : ""; ?> />
                        <label class="form-check-label" for="Theory">Theory</label>
                        <input class="form-check-input" type="radio" name="type" value="Lab" <?php echo ($res['type'] === "Lab") ? "checked" : ""; ?> />
                        <label class="form-check-label" for="Lab">Lab</label>
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
