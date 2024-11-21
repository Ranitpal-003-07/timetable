<?php 
session_start();
$email = $_SESSION['e_id'];
include('../config.php');

// Redirect to login if session variables are missing
if (empty($_SESSION['stu_id']) || empty($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>

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

        .navbar p {
            color: #fff;
            font-weight: 500;
            margin: 0;
        }

        .side-nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #8EC5FC;
            background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
            color: black;
            padding: 2rem 1rem;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
        }

        .side-nav img {
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .side-nav h5 {
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        .side-nav a {
            color: navy;
            display: block;
            margin: 0.8rem 0;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.3rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .side-nav a:hover {
            background-color: blueviolet;
            color: white;
            font-size: 1.1rem;
            font-weight: 800;
            text-decoration: none;
        }

        #page-wrapper {
            margin-left: 250px; /* Adjust according to sidebar width */
            padding: 2rem;
            flex: 1;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-text {
            font-size: 1.5rem;
            color: #2d3e50;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .side-nav {
                width: 200px;
            }

            #page-wrapper {
                margin-left: 200px;
            }
        }

        @media (max-width: 576px) {
            .side-nav {
                width: 100%;
                position: static;
                height: auto;
            }

            #page-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="side-nav">
            <?php
            $arr = scandir("image/$email");
            $img = !empty($arr[2]) ? $arr[2] : "pp.jpeg";
            ?>
            <div class="text-center">
                <img src="image/<?php echo $img; ?>" width="100" height="100" alt="Profile Picture">
                <h5><?php echo $_SESSION['name']; ?></h5>
            </div>
            <a href="studentdashboard.php?info=timeschedule"><i class="fa fa-calendar-alt me-2"></i>Time Schedule</a>
            <a href="studentdashboard.php?info=updateprofile&img=<?php echo $img; ?>"><i class="fa fa-user-edit me-2"></i>Update Profile</a>
            <a href="studentdashboard.php?info=updatepassword"><i class="fa fa-lock me-2"></i>Update Password</a>
        </div>

        <!-- Main Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <p class="welcome-text">Welcome, <strong><?php echo $_SESSION['name']; ?></strong>!</p>
                    </div>
                    <a href="logout.php" class="btn btn-primary"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                </div>

                <!-- Dynamic Content -->
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
                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3">
                                <img src="img/5.jpg" class="img-fluid" alt="Schedule">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3">
                                <img src="img/4.jpg" class="img-fluid" alt="Updates">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
