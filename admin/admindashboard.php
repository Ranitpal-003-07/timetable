<?php 
session_start();
include('../config.php');

// Check if the admin session is set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == "") {
    header("Location: login.php");
    exit;
} else {
    $que = mysqli_query($con, "SELECT * FROM admin WHERE user_name='" . $_SESSION['admin'] . "'");
    $res = mysqli_fetch_array($que);
    $_SESSION['user'] = $res;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="">

    <title>Time Table Admin Dashboard</title>

    <!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f0f2f5;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        .navbar {
            background-color: #212529 !important;
            padding: 1rem;
        }
        .navbar p {
            margin-bottom: 3rem; ;
            color: #FFFFFF;
            font-weight: 500;
        }
        .side-nav {
            background-color: #333;
            min-height: 100vh;
            width: 250px;
            padding-top: 1rem;
            padding-left: 0.5rem;
        }
        .side-nav a {
            color: #cfd2da;
            padding: 0.75rem 1rem;
            display: block;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 0.3rem;
        }
        .side-nav a:hover {
            background-color: #495057;
            color: #fff;
            text-decoration: none;
        }
        .content-wrapper {
            flex: 1;
            padding: 0rem;
        }
        .img-dashboard {
            margin-top: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            height: auto;
        }
        .admin-title {
            font-family: "Lucida Console", Monaco, monospace;
            color: #dc3545;
            font-size: 2.5rem;
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <nav class="side-nav navbar-dark">
            <a href="admindashboard.php?info=course"><i class="fa fa-fw fa-dashboard"></i> Department</a>
            <a href="admindashboard.php?info=semester"><i class="fa fa-fw fa-calendar"></i> Semester</a>
            <a href="admindashboard.php?info=subject"><i class="fa fa-fw fa-book"></i> Subject</a>
            <a href="admindashboard.php?info=student"><i class="fa fa-fw fa-user-graduate"></i> Student</a>
            <a href="admindashboard.php?info=teacher"><i class="fa fa-fw fa-chalkboard-teacher"></i> Teacher</a>
            <a href="admindashboard.php?info=add_timetable"><i class="fa fa-fw fa-calendar-plus"></i> Time Table</a>
        </nav>

        <!-- Main Content -->
        <div class="content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <span class="navbar-brand text-white">Hello Admin</span>
                    <div class="d-flex">
                        <a href="logout.php" class="btn btn-outline-light">Logout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <?php 
                            @$info = $_REQUEST['info'];
                            if ($info != "") {
                                if ($info == "course") {
                                    include('course.php');
                                } elseif ($info == "semester") {
                                    include('semester.php');
                                } elseif ($info == "subject") {
                                    include('subject.php');
                                } elseif ($info == "student") {
                                    include('student.php');
                                } elseif ($info == "teacher") {
                                    include('teacher.php');
                                } elseif ($info == "timetable") {
                                    include('timetable.php');
                                } elseif ($info == "add_course") {
                                    include('add_course.php');
                                } elseif ($info == "add_subject") {
                                    include('add_subject.php');
                                } elseif ($info == "add_semester") {
                                    include('add_semester.php');
                                } elseif ($info == "add_teacher") {
                                    include('add_teacher.php');
                                } elseif ($info == "add_student") {
                                    include('add_student.php');
                                } elseif ($info == "add_timetable") {
                                    include('add_timetable.php');
                                } elseif ($info == "updatecourse") {
                                    include('updatecourse.php');
                                } elseif ($info == "updatesemester") {
                                    include('updatesemester.php');
                                } elseif ($info == "updatesubject") {
                                    include('updatesubject.php');
                                } elseif ($info == "updatestudent") {
                                    include('updatestudent.php');
                                } elseif ($info == "updateteacher") {
                                    include('updateteacher.php');
                                } elseif ($info == "updatetimetable") {
                                    include('update_timetable.php');
                                }
                            } else {
                        ?>
                            <div class="admin-title">Admin Panel</div>
                            <img src="../img/online-practice-exams.jpg" class="img-fluid img-dashboard" alt="Admin Dashboard" width="500">
                        <?php } ?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
