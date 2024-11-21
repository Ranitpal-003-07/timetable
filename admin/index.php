<?php 
session_start();

// Check if the user has logged out successfully
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);  // Remove the message after displaying it
} else {
    $logout_message = '';
}

require('../config.php');

// Error message initialization
$err = "";

// Check if the form is submitted
if (isset($_POST['save'])) {
    $e = $_POST['e'];
    $p = $_POST['p'];

    if (empty($e) || empty($p)) {
        $err = "<div class='alert alert-danger'>Please fill in all the fields.</div>";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($con, "SELECT * FROM admin WHERE user_name = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $e, $p);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $r = mysqli_num_rows($result);

        if ($r > 0) {
            $_SESSION['admin'] = $e;
            header('Location: admindashboard.php');
            exit();
        } else {
            $err = "<div class='alert alert-danger'>Invalid login details.</div>";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJx3K6j6oO47nzvAzvii6lsbBz9F91JyygdU9IHgFWjQzj2yRpnBCfQPTFw" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #6c5ce7, #00b894);
            font-family: 'Arial', sans-serif;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-signin-heading {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }

        .form-label {
            color: black;
            font-weight: 600;
        }

        .form-control {
            border-radius: 30px;
            border: 1px solid #ddd;
            box-shadow: none;
            transition: border-color 0.3s ease;
            padding: 10px 15px; /* Reduced padding to make the input field smaller */
            font-size: 1rem; /* Reduced font size for smaller text */
            width: 70%;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 5px rgba(108, 92, 231, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* Add margin to the bottom of the password field or login button */
        .form-group:last-of-type {
            margin-bottom: 20px; /* Adjust this value to control the space */
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            background-color: #6c5ce7;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-top: 20px; 
        }

        .btn:hover {
            background-color: #00b894;
            cursor: pointer;
            color: white;
            font-weight: 900;
        }

        .alert {
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: green; /* Change text color to green */
            border-color: #c3e6cb;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2 class="form-signin-heading">Admin Login</h2>

        <!-- Display logout message if available -->
        <?php if ($logout_message): ?>
            <div class="alert alert-success">
                <?php echo $logout_message; ?>
            </div>
        <?php endif; ?>

        <?php echo $err; ?>

        <form method="POST">
            <div class="form-group">
                <label for="inputEmail" class="form-label">Username</label>
                <input type="text" class="form-control" id="inputEmail" placeholder="Enter your username" name="e" value="<?php echo htmlspecialchars($e ?? ''); ?>" required autofocus />
            </div>
            
            <div class="form-group">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword" placeholder="Enter your password" name="p" value="<?php echo htmlspecialchars($p ?? ''); ?>" required />
            </div>

            <button type="submit" name="save" class="btn">Login</button>

            <div class="forgot-password">
                <a href="#">Forgot your password?</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybNfEXcQd8UMpP7L5ITWzF7rcs1lO3/5Q95hpoDfrF4G5jJ7A" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-KyZXEJx3K6j6oO47nzvAzvii6lsbBz9F91JyygdU9IHgFWjQzj2yRpnBCfQPTFw" crossorigin="anonymous"></script>

</body>
</html>
