<?php 
include('../config.php');
include("timetablegen.php");
extract($_POST);

// Set the 'generated' status in the URL if 'generate' or 'regenerate' is triggered
if (isset($generate) || isset($regenerate)) {
  $_GET['generated'] = "true";
} else {
  $_GET['generated'] = "";
}
?>

<script>
function showSubject(str) {
    if (str === "") {
        document.getElementById("subject").innerHTML = "";
        return;
    }
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("subject").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "subject_ajax.php?id=" + str, true);
    xmlhttp.send();
}

function showSemester(str) {
    if (str === "") {
        document.getElementById("semester").innerHTML = "";
        return;
    }
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("semester").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "semester_ajax.php?id=" + str, true);
    xmlhttp.send();
}
</script>

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="text-center mb-4">Generate Time Table</h2>
            <form method="POST" enctype="multipart/form-data">
                <table class="table table-striped">
                    <tr>
                        <td colspan="2"><?php echo @$err; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Select Department</th>
                        <td>
                            <select name="courseid" class="form-control" onchange="showSemester(this.value)" id="courseid">
                                <option disabled selected>Select Department</option>
                                <?php 
                                $dep = mysqli_query($con, "SELECT * FROM department");
                                while($dp = mysqli_fetch_array($dep)) {
                                    $dp_id = $dp[0];
                                    echo "<option value='$dp_id'>" . $dp[1] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">Select Semester</th>
                        <td>
                            <select name="s" id="semester" onchange="showSubject(this.value)" class="form-control">
                                <option disabled selected>Select Semester</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-primary" name="generate">Generate Time Table</button>
                        </td>
                    </tr>
                    <?php if ($_GET['generated']) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-success" name="regenerate">Regenerate</button>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>

    <div>
        <?php 
        if ($_GET['generated']) {
            $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $lunch = "LUNCH";

            // Retrieve and display department and semester names
            $query = "SELECT * FROM department WHERE department_id = '$courseid'";
            $que = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($que);
            $branch = $row['department_name'];

            $query = "SELECT * FROM semester WHERE sem_id = '$s'";
            $que = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($que);
            $semester = $row['semester_name'];

            if ($branch && $semester) {
                echo "<div class='mb-4'><h3>" . htmlspecialchars($branch) . " " . htmlspecialchars($semester) . " Semester</h3></div>";
            }

            $weekTimeTable = generate_time_table($con, $courseid, $s);

            if ($weekTimeTable) {
                echo "<table class='table table-bordered'>";
                echo "<thead><tr class='table-dark'>
                        <th>Days/Lecture</th>
                        <th>Lecture 1<br>09:00-10:00</th>
                        <th>Lecture 2<br>10:00-11:00</th>
                        <th>Lecture 3<br>11:00-12:00</th>
                        <th>Lecture 4<br>12:00-01:00</th>
                        <th>Break</th>
                        <th>Lecture 5<br>02:30-03:30</th>
                        <th>Lecture 6<br>03:30-04:30</th>
                    </tr></thead>";

                for ($i = 0; $i < 5; $i++) {
                    echo "<tr>";
                    echo "<th>" . htmlspecialchars($weekDays[$i]) . "</th>";
                    for ($j = 0; $j < 6; $j++) {
                        if (is_array($weekTimeTable[$i][$j]) && $weekTimeTable[$i][$j]['type'] === 'Lab') {
                            echo "<td colspan=2 class='text-center'>" . htmlspecialchars($weekTimeTable[$i][$j]['subject_name']) . "</td>";
                            $j++;
                        } else {
                            echo "<td class='text-center'>" . (is_array($weekTimeTable[$i][$j]) ? htmlspecialchars($weekTimeTable[$i][$j]['subject_name']) : "Empty") . "</td>";
                        }
                        if ($j === 3) {
                            echo "<td class='text-center'><b>" . $lunch . "</b></td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='alert alert-warning'>Not enough data for selected Course and Semester.</div>";
            }
        }
        ?>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 900px;
        margin: 0 auto;
    }
    .table th, .table td {
        text-align: center;
        padding: 15px;
    }
    .btn {
        padding: 10px 20px;
        font-size: 16px;
    }
    .table-bordered {
        border: 2px solid #ddd;
    }
    .table-dark {
        background-color: #343a40;
        color: #fff;
    }
    .alert {
        font-size: 18px;
    }
</style>
