<?php 
include('../config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            margin-bottom: 20px;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header {
            background: rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
        }

        .card-body {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card-body div {
            margin: 5px 0;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f7971e, #ffd200);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ffd200, #f7971e);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4" style="color: #444;">Your Timetable</h1>

        <?php
        // Fetch the user's semester ID
        $que4 = mysqli_query($con, "SELECT * FROM student WHERE eid = '" . $_SESSION['e_id'] . "'");
        $res4 = mysqli_fetch_array($que4);

        // Fetch the schedule based on the student's semester ID
        $que = mysqli_query($con, "SELECT * FROM timeschedule WHERE semester_name = '" . $res4['sem_id'] . "'");
        while ($res = mysqli_fetch_array($que)) {
            // Fetch related data
            $department = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM department WHERE department_id = '" . $res['department_name'] . "'"));
            $semester = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM semester WHERE sem_id = '" . $res4['sem_id'] . "'"));
            $subject = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM subject WHERE subject_id = '" . $res['subject_name'] . "'"));
            $teacher = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM teacher WHERE teacher_id = '" . $res['teacher_id'] . "'"));
        ?>
        
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt"></i> <?php echo $subject['subject_name']; ?>
                </div>
                <div class="card-body">
                    <div><strong>Department:</strong> <?php echo $department['department_name']; ?></div>
                    <div><strong>Semester:</strong> <?php echo $semester['semester_name']; ?></div>
                    <div><strong>Teacher:</strong> <?php echo $teacher['name']; ?></div>
                    <div><strong>Date:</strong> <?php echo $res['date']; ?></div>
                    <div><strong>Time:</strong> <?php echo $res['time']; ?></div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
