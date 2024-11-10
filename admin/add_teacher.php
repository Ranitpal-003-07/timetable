<?php 
include('../config.php');
extract($_POST);
if(isset($save)) {
    $que = mysqli_query($con, "SELECT * FROM teacher WHERE eid='$e'");        
    $row = mysqli_num_rows($que);
    if ($row) {
        $err = "<div class='alert alert-danger'>This teacher already exists</div>";
    } else {
        mysqli_query($con, "INSERT INTO teacher VALUES (NULL, '$n', '$e', '$p', $m, '$a', '$courseid')");
        $err = "<div class='alert alert-success'>Congratulations! Your Data has been Saved!!!</div>";
    }
}
?>

<script>
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

function showCourse(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("department").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "course_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Add Teacher</h2>
            <?php echo @$err; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="courseid" class="form-label">Select Department</label>
                    <select name="courseid" id="courseid" onchange="showSemester(this.value)" class="form-select">
                        <option disabled selected>Select Department</option>
                        <?php
                        $t = mysqli_query($con, "SELECT * FROM department");
                        while ($s = mysqli_fetch_array($t)) {
                            $t_id = $s[0];
                            echo "<option value='$t_id'>" . $s[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="n" class="form-label">Teacher Name</label>
                    <input type="text" name="n" id="n" class="form-control" placeholder="Enter Teacher's Name" required />
                </div>

                <div class="mb-3">
                    <label for="e" class="form-label">Enter Your Email</label>
                    <input type="email" name="e" id="e" class="form-control" placeholder="Enter Your Email" required />
                </div>

                <div class="mb-3">
                    <label for="p" class="form-label">Enter Your Password</label>
                    <input type="password" name="p" id="p" class="form-control" placeholder="Enter Your Password" required />
                </div>

                <div class="mb-3">
                    <label for="m" class="form-label">Enter Your Mobile</label>
                    <input type="number" name="m" id="m" class="form-control" placeholder="Enter Your Mobile" required />
                </div>

                <div class="mb-3">
                    <label for="a" class="form-label">Enter Your Address</label>
                    <input type="text" name="a" id="a" class="form-control" placeholder="Enter Your Address" required />
                </div>

                <div class="text-center">
                    <button type="submit" name="save" class="btn btn-success">Add Teacher</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
