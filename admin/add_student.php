<?php 
include('../config.php');

extract($_POST);
if(isset($save)) {
    $que = mysqli_query($con, "SELECT * FROM student WHERE eid = '$eid' AND mob = '$mobile'");
    $row = mysqli_num_rows($que);
    if($row) {
        $err = "<div class='alert alert-danger'>This student already exists.</div>";
    } else {
        $image = $_FILES['pic']['name'];
        
        // Insert student data into the database
        mysqli_query($con, "INSERT INTO student VALUES (null, '$stname', '$eid', '$p', '$mobile', '$address', '$courseid', '$s', '$dob', '$image', '$gen', '$status', NOW())");

        // Create a directory and move the uploaded file
        mkdir("../student/image/$eid");
        move_uploaded_file($_FILES['pic']['tmp_name'], "../student/image/$eid/" . $_FILES['pic']['name']);
        
        $err = "<div class='alert alert-success'>Congrats! Your data has been saved.</div>";
    }
}
?>

<script>
function showSemester(str) {
    if (str == "") {
        document.getElementById("semester").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "semester_ajax.php?id=" + str, true);
    xmlhttp.send();
}

function showCourse(str) {
    if (str == "") {
        document.getElementById("department").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("department").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "course_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<!-- Form -->
<div class="container mt-4">
    <h2 class="text-center mb-4">Add Student</h2>

    <!-- Error message -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php echo @$err; ?>
        </div>
    </div>

    <!-- Student Form -->
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group mb-3">
                    <label for="courseid" class="form-label">Select Department</label>
                    <select name="courseid" id="courseid" class="form-control" onchange="showSemester(this.value)">
                        <option disabled selected>Select Department</option>
                        <?php 
                        $dep = mysqli_query($con, "SELECT * FROM department");
                        while($dp = mysqli_fetch_array($dep)) {
                            echo "<option value='$dp[0]'>$dp[1]</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="semester" class="form-label">Select Semester</label>
                    <select name="s" id="semester" class="form-control">
                        <option disabled selected>Select Semester</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="stname" class="form-label">Student Name</label>
                    <input type="text" name="stname" id="stname" class="form-control" placeholder="Enter your name" required />
                </div>

                <div class="form-group mb-3">
                    <label for="eid" class="form-label">Email</label>
                    <input type="email" name="eid" id="eid" class="form-control" placeholder="Enter your email" required />
                </div>

                <div class="form-group mb-3">
                    <label for="p" class="form-label">Password</label>
                    <input type="password" name="p" id="p" class="form-control" placeholder="Enter your password" required />
                </div>

                <div class="form-group mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Enter your mobile number" required />
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" required />
                </div>

                <div class="form-group mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control" required />
                </div>

                <div class="form-group mb-3">
                    <label for="pic" class="form-label">Upload Your Picture</label>
                    <input type="file" name="pic" id="pic" class="form-control" />
                </div>

                <div class="form-group mb-3">
                    <label for="gen" class="form-label">Gender</label><br />
                    Male <input type="radio" value="m" name="gen" /> 
                    Female <input type="radio" value="f" name="gen" />
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" selected disabled>Select Status</option>
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
                </div>

                <div class="form-group text-center">
                    <button type="submit" name="save" class="btn btn-success">Add Student</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap JS and jQuery (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
