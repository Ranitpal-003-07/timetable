<?php 
session_start();
include('../config.php');

// Check if session variables for teacher_id and name are set
if(empty($_SESSION['teacher_id']) || empty($_SESSION['name'])) {
    header('location:index.php'); // Redirect to login page if not set
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 1rem;
        }

        .navbar .logout {
            color: #fff;
            text-decoration: none;
        }

        .navbar .logout:hover {
            text-decoration: underline;
        }

        .side-nav {
            background: linear-gradient(135deg, #2d3e50, #1e293b);
            color: #cbd5e1;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1rem;
        }

        .side-nav a {
            color: #cbd5e1;
            display: block;
            margin: 0.8rem 0;
            padding: 0.5rem 1rem;
            border-radius: 0.3rem;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        .side-nav a:hover {
            background-color: #4b5563;
            color: #fff;
        }

        .side-nav .profile img {
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .side-nav .profile h5 {
            margin: 0;
            color: #fff;
            font-size: 1.2rem;
        }

        #page-wrapper {
            margin-left: 250px;
            padding: 2rem;
        }

        .content {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="side-nav">
        <div class="profile text-center">
            <img src="image/profile.jpg" alt="Profile Picture" width="100" height="100">
            <h5><?php echo $_SESSION['name']; ?></h5>
        </div>
        <a href="staffdashboard.php?info=timeschedule"><i class="fa fa-calendar-alt me-2"></i> Time Schedule</a>
        <a href="staffdashboard.php?info=updateprofile"><i class="fa fa-user-edit me-2"></i> Update Profile</a>
        <a href="staffdashboard.php?info=updatepassword"><i class="fa fa-lock me-2"></i> Update Password</a>
    </div>

    <!-- Main Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <span class="navbar-text">Welcome, <?php echo $_SESSION['name']; ?></span>
                    <a href="logout.php" class="logout"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>

            <div class="content mt-4">
                <?php 
                @$info = $_REQUEST['info'];
                if ($info != "") {
                    if ($info == "updatepassword") {
                        include('updatepassword.php');
                    } elseif ($info == "updateprofile") {
                        include('updateprofile.php');
                    } elseif ($info == "timeschedule") {
                        include('timeschedule.php');
                    }
                } else {
                    echo "<h2 class='text-center'>Welcome to the Staff Dashboard</h2>";
                    echo "<p class='text-center'>Use the sidebar to navigate between options.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
