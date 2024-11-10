<?php 
include('../config.php');
extract($_POST);
if(isset($save)) {
    $que = mysqli_query($con, "SELECT * FROM subject WHERE subject_name='$subname'");
    $row = mysqli_num_rows($que);
    if ($row) {
        $err = "<div class='alert alert-danger'>This Subject already exists</div>";
    } else {
        mysqli_query($con, "INSERT INTO subject VALUES (NULL, '$subname', '$s', '$courseid', '$t', '$lpw', '$type')");
        $err = "<div class='alert alert-success'>Congratulations! Your Data has been Saved!!!</div>";
    }
}
?>

<script>
function showOpts(str){
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

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Add Subject</h2>
            <?php echo @$err; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="courseid" class="form-label">Select Department</label>
                    <select name="courseid" id="courseid" onchange="showOpts(this.value)" class="form-select">
                        <option disabled selected>Select Department</option>
                        <?php
                        $sub = mysqli_query($con, "SELECT * FROM department");
                        while ($s = mysqli_fetch_array($sub)) {
                            $s_id = $s[0];
                            echo "<option value='$s_id'>" . $s[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="semester" class="form-label">Select Semester</label>
                    <select name="s" id="semester" class="form-select">
                        <option disabled selected>Select Semester</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="teacher" class="form-label">Select Teacher</label>
                    <select name="t" id="teacher" class="form-select">
                        <option disabled selected>Select Teacher</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subname" class="form-label">Subject Name</label>
                    <input type="text" name="subname" id="subname" class="form-control" placeholder="Enter Subject Name" />
                </div>

                <div class="mb-3">
                    <label for="lpw" class="form-label">Lecture/Week</label>
                    <input type="number" name="lpw" id="lpw" class="form-control" placeholder="Enter Lectures per Week" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="Theory" checked>
                            <label class="form-check-label" for="Theory">Theory</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="Lab">
                            <label class="form-check-label" for="Lab">Lab</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" name="save" class="btn btn-success">Add Subject</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
