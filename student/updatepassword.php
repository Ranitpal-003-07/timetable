<?php
include('../config.php');
$q = mysqli_query($con, "SELECT * FROM student WHERE stu_id='" . $_SESSION['stu_id'] . "'");
$res = mysqli_fetch_assoc($q);
$opass = $res['password']; // Existing password from the database
extract($_POST);

if (isset($update)) {
    if (empty($np) || empty($op) || empty($cp)) {
        $err = "<div class='alert alert-danger'>Please fill in all fields.</div>";
    } else {
        if ($op == $opass) { // Old password matches
            if ($np == $cp) { // New password matches confirm password
                mysqli_query($con, "UPDATE student SET password='$np' WHERE stu_id='" . $_SESSION['stu_id'] . "'");
                $err = "<div class='alert alert-success'>Password successfully updated.</div>";
            } else {
                $err = "<div class='alert alert-danger'>New password and Confirm password do not match.</div>";
            }
        } else {
            $err = "<div class='alert alert-danger'>Old password does not match our records.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        .card h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            color: #fff;
        }

        .form-control:focus {
            box-shadow: 0 0 10px #00f0ff;
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff9900, #ff6600);
            border: none;
            font-weight: bold;
            border-radius: 50px;
            box-shadow: 0px 4px 10px rgba(255, 153, 0, 0.5);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff6600, #ff9900);
        }

        .alert {
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2><i class="fas fa-key"></i> Update Password</h2>

        <!-- Display error or success messages -->
        <?php if (isset($err)) echo $err; ?>

        <form method="POST">
            <!-- Old Password -->
            <div class="mb-3">
                <label for="op" class="form-label text-white">Old Password</label>
                <input type="password" name="op" class="form-control" placeholder="Enter Old Password" required>
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="np" class="form-label text-white">New Password</label>
                <input type="password" name="np" class="form-control" placeholder="Enter New Password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="cp" class="form-label text-white">Confirm Password</label>
                <input type="password" name="cp" class="form-control" placeholder="Confirm New Password" required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" name="update" class="btn btn-primary px-4">Update Password</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
