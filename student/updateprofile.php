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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Profile</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Nunito', sans-serif;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px;
        }

        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            width: 100%;
        }

        .glass-card h2 {
            text-align: center;
            color: #ffd700;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0px 3px 5px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 500;
            box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.2);
        }

        .form-control:focus {
            border-color: #ffd700;
            box-shadow: 0 0 10px #ffd700;
        }

        select.form-control {
            appearance: none;
            padding-right: 30px;
            background-image: url('https://img.icons8.com/ios/50/ffffff/expand-arrow.png');
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
        }

        .btn-success {
            background: linear-gradient(45deg, #ff9900, #ff6600);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 50px;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(255, 153, 0, 0.5);
        }

        .btn-success:hover {
            transform: scale(1.1);
            background: linear-gradient(45deg, #ff6600, #ff9900);
        }

        label {
            font-weight: bold;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="glass-card">
        <h2><i class="fas fa-user-edit"></i> Update Student Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="course">Department Name</label>
                <select name="course" id="course" onChange="showSemester(this.value)" class="form-control">
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
            </div>

            <div class="mb-3">
                <label for="semester">Semester Name</label>
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
            </div>

            <div class="mb-3">
                <label for="name">Student Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?php echo $res['name']; ?>" />
            </div>

            <div class="mb-3">
                <label for="eid">Email</label>
                <input type="email" name="eid" class="form-control" placeholder="Enter your email" value="<?php echo $res['eid']; ?>" />
            </div>

            <div class="mb-3">
                <label for="p">Password</label>
                <input type="password" name="p" class="form-control" placeholder="Enter your password" value="<?php echo $res['password']; ?>" />
            </div>

            <div class="mb-3">
                <label for="mobile">Mobile</label>
                <input type="number" name="mobile" class="form-control" placeholder="Enter your mobile" value="<?php echo $res['mob']; ?>" />
            </div>

            <div class="mb-3">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter your address" value="<?php echo $res['address']; ?>" />
            </div>

            <div class="mb-3">
                <label for="dob">D.O.B</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $res['dob']; ?>" />
            </div>

            <div class="mb-3">
                <label for="pic">Profile Picture</label>
                <input type="file" name="pic" class="form-control" />
            </div>

            <div class="mb-3">
                <label>Gender</label>
                <div>
                    <label>
                        <input type="radio" value="m" id="gen" name="gen" <?php if ($res['gender'] == "m") { echo "checked"; } ?> />
                        Male
                    </label>
                    <label class="ms-3">
                        <input type="radio" value="f" id="gen" name="gen" <?php if ($res['gender'] == "f") { echo "checked"; } ?> />
                        Female
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="status">Status</label>
                <input type="text" name="status" class="form-control" placeholder="Enter your status" value="<?php echo $res['status']; ?>" />
            </div>

            <div class="text-center">
                <button type="submit" name="update" class="btn btn-success">Update Records</button>
            </div>
        </form>
    </div>

    <script>
        function showSemester(str) {
            if (str == "") {
                document.getElementById("semester").innerHTML = "";
                return;
            }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function () {
                document.getElementById("semester").innerHTML = this.responseText;
            };
            xmlhttp.open("GET", "semester_ajax.php?q=" + str);
            xmlhttp.send();
        }
    </script>
</body>
</html>
