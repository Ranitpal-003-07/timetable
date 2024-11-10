<?php 
session_start();
require('../config.php');
extract($_POST);

if(isset($save)) {
    if(empty($e) || empty($p)) {
        $err = "<font color='red'>Please fill in all fields.</font>";
    } else {
        // Check login credentials
        $que = mysqli_query($con, "SELECT * FROM student WHERE eid='".$e."' AND password='".$p."'");
        $r = mysqli_num_rows($que);
        $res = mysqli_fetch_array($que);    

        if($r) {
            $_SESSION['name'] = $res['name'];
            $_SESSION['stu_id'] = $res['stu_id'];
            $_SESSION['e_id'] = $e;

            echo "<script>window.location='studentdashboard.php'</script>";
        } else {
            $err = "<font color='red'>Invalid login details.</font>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - Time Table Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-signin {
            display: flex;
            flex-direction: column;
        }
        .form-signin h1 {
            color: #337ab7;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-signin label {
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .form-signin input {
            padding: 12px;
            font-size: 1rem;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: all 0.3s;
        }
        .form-signin input:focus {
            border-color: #337ab7;
            outline: none;
        }
        .form-signin input[type="submit"] {
            background-color: #09f;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-signin input[type="submit"]:hover {
            background-color: #0066cc;
        }
        .form-signin .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-signin a {
            text-align: center;
            font-size: 1.2rem;
            color: #0066cc;
            text-decoration: none;
            margin-top: 20px;
        }
        .form-signin a:hover {
            color: #004d99;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form class="form-signin" method="POST">
            <h1>Student Login</h1>

            <?php if (isset($err)) { ?>
                <div class="error"><?php echo $err; ?></div>
            <?php } ?>

            <label for="inputEmail">Email</label>
            <input type="text" id="inputEmail" name="e" placeholder="Enter your email" value="<?php echo @$e;?>" required>

            <label for="inputPassword">Password</label>
            <input type="password" id="inputPassword" name="p" placeholder="Enter your password" required>

            <input type="submit" value="Login" name="save">

            <a href="../index.php">Back to Home</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
