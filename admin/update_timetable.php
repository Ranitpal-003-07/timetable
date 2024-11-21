<?php 
include('../config.php');

// Fetching the timeschedule_id from the URL parameter
$timeschedule_id = $_REQUEST['timeschedule_id'];

// Query to get the existing timetable data
$q = mysqli_query($con, "SELECT * FROM timeschedule WHERE timeschedule_id = '$timeschedule_id'");
$res = mysqli_fetch_array($q);

extract($_POST);

// If the form is submitted with the 'update' button
if (isset($update)) {
    // Update the timetable record in the database
    mysqli_query($con, "UPDATE timeschedule SET department_name = '$course', semester_name = '$s', subject_name = '$subname', time = '$time', date = '$date', teacher_id = '$teacher' WHERE timeschedule_id = '$timeschedule_id'");

    // Confirmation message
    echo "Records updated";
}
?>

<script>
// Function to load the semester options dynamically based on the department
function showSemester(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    // Use AJAX to load semester data
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest(); // For modern browsers
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // For older IE versions
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText; // Populate the semester select box
        }
    }

    xmlhttp.open("GET", "updatetimetable_ajax.php?id=" + str, true);
    xmlhttp.send();
}

// Function to load the subject options dynamically based on the selected semester
function showSubject(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    // Use AJAX to load subject data
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest(); // For modern browsers
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // For older IE versions
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("subject").innerHTML = xmlhttp.responseText; // Populate the subject select box
        }
    }

    xmlhttp.open("GET", "subject_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<div class="row">
    <div class="col-sm-8">
        <h2>Update Time Table</h2>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" class="table">
                <tr>
                    <td colspan="2"><?php echo @$err; ?></td>
                </tr>
                <!-- Department selection -->
                <tr>
                    <th width="237" scope="row">Department Name</th>
                    <td width="213">
                        <select name="course" id="courseid" onChange="showSemester(this.value)" class="form-control">
                            <?php
                            $cou = mysqli_query($con, "SELECT * FROM department");
                            while ($c = mysqli_fetch_array($cou)) {
                                $c_id = $c[0];
                            ?>
                                <option value='<?php echo $c_id; ?>' <?php if ($c_id == $res['department_name']) { echo "selected"; } ?>>
                                    <?php echo $c[1]; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Semester selection -->
                <tr>
                    <th width="237" scope="row">Semester Name</th>
                    <td width="213">
                        <select name="s" id="semester" onChange="showSubject(this.value)" class="form-control">
                            <?php
                            $sem = mysqli_query($con, "SELECT * FROM semester WHERE department_id = '" . $res['department_name'] . "'");
                            while ($s = mysqli_fetch_array($sem)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php if ($s_id == $res['semester_name']) { echo "selected"; } ?>>
                                    <?php echo $s[1]; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Subject selection -->
                <tr>
                    <th width="237" scope="row">Subject Name</th>
                    <td width="213">
                        <select name="subname" id="subject" class="form-control">
                            <?php
                            $sem = mysqli_query($con, "SELECT * FROM subject WHERE sem_id = '" . $res['semester_name'] . "'");
                            while ($s = mysqli_fetch_array($sem)) {
                                $s_id = $s[0];
                            ?>
                                <option value='<?php echo $s_id; ?>' <?php if ($s_id == $res['subject_name']) { echo "selected"; } ?>>
                                    <?php echo $s[1]; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Teacher selection -->
                <tr>
                    <th width="237" scope="row">Teacher</th>
                    <td width="213">
                        <select name="teacher" id="teacherid" class="form-control">
                            <?php
                            $t = mysqli_query($con, "SELECT * FROM teacher");
                            while ($s = mysqli_fetch_array($t)) {
                                $t_id = $s[0];
                                echo "<option value='$t_id' " . ($t_id == $res['teacher_id'] ? "selected" : "") . ">" . $s[1] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Time input -->
                <tr>
                    <th width="237" scope="row">Enter Time</th>
                    <td width="213"><input type="time" name="time" class="form-control" value="<?php echo $res['time']; ?>" /></td>
                </tr>

                <!-- Date input -->
                <tr>
                    <th width="237" scope="row">Date</th>
                    <td width="213"><input type="date" name="date" class="form-control" value="<?php echo $res['date']; ?>" /></td>
                </tr>

                <!-- Submit button -->
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