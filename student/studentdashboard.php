<?php 
session_start();
$email = $_SESSION['e_id'];
include('../config.php');

// Check if the session variables are not set, then redirect to the login page
if (empty($_SESSION['stu_id']) || empty($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Time Table Student Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <p>
                    <span style="color:#FFF;">Hello, <?php echo $_SESSION['name']; ?></span>
                    <span style="margin-left:1200px;">
                        <a href="logout.php" class="glyphicon glyphicon-off" aria-hidden="true">
                            <font color="#FFFFFF">Logout</font>
                        </a>
                    </span>
                </p>
            </div>

            <!-- Sidebar Menu Items -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav" style="background-color:#000;">
                    <?php
                    // Check if the image folder exists for the user
                    $arr = scandir("image/$email");
                    $img = !empty($arr[2]) ? $arr[2] : "pp.jpeg";  // Default image if no custom image is found
                    ?>
                    <li>
                        <img src="image/<?php echo $img; ?>" width="170" height="100" alt="Profile pic not found" />
                    </li>
                    <li>
                        <a href="studentdashboard.php?info=timeschedule"><i class="fa fa-fw fa-dashboard"></i> Time Schedule</a>
                    </li>
                    <li>
                        <a href="studentdashboard.php?info=updateprofile&img=<?php echo $img; ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Update Profile</a>
                    </li>
                    <li>
                        <a href="studentdashboard.php?info=updatepassword"><i class="fa fa-fw fa-table"></i> Update Password</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12" style="background-color:#000;" align="center">
                        <?php 
                        // Check if info is set in the URL, then include corresponding content
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
                            <!-- Default content if no 'info' is passed -->
                            <img src="img/5.jpg" class="img-responsive" alt="Cinque Terre" width="500" height="500" style="margin-top: 10px; margin-left: 23px;">
                            <img src="img/4.jpg" class="img-responsive" alt="Cinque Terre" width="500" height="100" style="margin-left: 23px;">
                        <?php } ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
