<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Time Table Generator</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    nav{
        background-color:beige;
    }
    nav li{
        font-size: 1rem;
        margin: .5rem 1rem ;
        font-weight: 800;
    }
    .header {
    background-color: burlywood;
    height: 100vh;
    color: white;
    padding-bottom: 5rem;
  }

  .container1 {
    background-color: rgba(0, 0, 0, 0.6); /* Black with 60% opacity */
    padding: 2rem;
    border-radius: 8px;
  }
  .about-section {
    background-color: burlywood;
    color: white;
    padding: 4rem 4rem;
  }

  .section-heading {
    color: #f8f9fa;
    font-weight: 700;
  }

  .primary {
    width: 800px;
    height: 3px;
    background-color: #f8f9fa;
    margin: 1.5rem auto;
  }
  .contact-section {
    background-color: burlywood;
    padding: 3rem 0;
  }
  .panel {
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 20px;
    border-radius: 8px;
  }
  .registration-section {
    padding: 3rem 0;
    background-color: olive;
  }
</style>


</head>
<body>
    
<!-- /.navbar -->

<nav class="navbar navbar-expand-lg" >
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contactus">Contact Us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./student/index.php">Student</a></li>
            <li><a class="dropdown-item" href="./staff/index.php">Staff</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./admin/index.php">Admin</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
  
<!-- /.navbar-end -->
   
<!-- /.slider -->

<header class="header d-flex align-items-center justify-content-center">
  <div class="container1 text-center">
    <div class="header-content">
      <h1 class="display-4 fw-bold">Timetable Generator</h1>
      <hr class="my-4 border-white">
      <a href="#about" class="btn btn-primary btn-lg">Find Out More</a>
    </div>
  </div>
</header>
<!--container-->

<section class="about-section about" id="about">
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <h2 class="section-heading">About Timetable Generator PHP MySQL</h2>
        <hr class="primary">
      </div>
    </div>

    <div class="row mb-5">
      <div class="col text-justify">
        <p>
          Most colleges have a number of different courses, each with several subjects. Due to limited faculties, each teaching multiple subjects, a timetable must be scheduled to avoid overlapping times. Our timetable generator uses a genetic algorithm, structuring schedules with a fitness score that reflects the efficiency of subject assignments. The timetable object comprises Classroom objects, each with weekly schedules subdivided by days and timeslots, each assigned a subject, faculty, and student group.
        </p>
        <p>
          For better flexibility, we use a composite design pattern, making it easy to add or remove scheduling constraints. If a conflict is detected between two schedules, the fitness score is incremented, indicating that adjustments are needed to avoid conflicts.
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="st-member text-center">
          <!-- Add any additional content here, such as an image or button -->
        </div>
      </div>
    </div>
  </div>
</section>
        
<!--contact-->

<section id="contactus" class="contact-section contactus">
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <h2 class="section-heading">Contact Us</h2>
        <hr class="primary">
      </div>
    </div>

    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <h2 class="section-heading">Let's Get In Touch</h2>
        <hr class="primary">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="panel">
          <?php 
          include('config.php');
          extract($_POST);
          if(isset($save)) {
            mysqli_query($con, "INSERT INTO contactus VALUES ('', '$name', '$e', '$s', '$m')");
            $err = "<font color='blue'>Congrats! Your data has been saved!</font>";
          }
          ?>

          <form method="POST">
            <div class="mb-3">
              <?php echo @$err; ?>
            </div>       
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Name" name="name" required />
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" name="e" required />
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Subject" name="s" required />
            </div>
            <div class="mb-3">
              <textarea class="form-control" placeholder="Message" style="resize: vertical; max-height: 400px;" name="m" required></textarea>
            </div>
            <div class="mb-3 text-center">
              <input type="submit" value="Save" name="save" class="btn btn-success" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!--registration-->

<section id="registration" class="registration-section">
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <h2 class="section-heading">Registration Form</h2>
        <hr class="primary">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="panel">
          <?php 
          include('config.php');
          extract($_POST);

          if(isset($save)) {
            // Check if student already exists
            $que = mysqli_query($con, "SELECT * FROM student WHERE eid='$eid' AND mob='$mobile'");
            $row = mysqli_num_rows($que);

            if($row) {
              $err = "<font color='red'>This user already exists</font>";
            } else {
              $image = $_FILES['pic']['name'];  
              mysqli_query($con, "INSERT INTO student VALUES ('', '$stname', '$eid', '$p', '$mobile', '$address', '$courseid', '$s', '$dob', '$image', '$gen', '$status', NOW())"); 

              // Create directory and move uploaded image
              mkdir("../student/image/$eid");
              move_uploaded_file($_FILES['pic']['tmp_name'], "../student/image/$eid/".$image);

              $err = "<font color='blue'>Congrats! Your data has been saved!</font>";
            }
          }
          ?>

          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <?php echo @$err; ?>
            </div>

            <div class="mb-3">
              <label for="courseid" class="form-label">Department</label>
              <select name="courseid" class="form-select" onchange="showSemester(this.value)" required>
                <option selected disabled>Select Department</option>
                <?php 
                $dep = mysqli_query($con, "SELECT * FROM department");
                while($dp = mysqli_fetch_array($dep)) {
                  echo "<option value='{$dp[0]}'>{$dp[1]}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="semester" class="form-label">Semester</label>
              <select name="s" id="semester" class="form-select" required>
                <option selected disabled>Select Semester</option>
              </select>
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Name" name="stname" required />
            </div>

            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" name="eid" required />
            </div>

            <div class="mb-3">
              <input type="password" class="form-control" placeholder="Password" name="p" required />
            </div>

            <div class="mb-3">
              <input type="number" class="form-control" placeholder="Mobile" name="mobile" required />
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Address" name="address" required />
            </div>

            <div class="mb-3">
              <input type="date" class="form-control" placeholder="D.O.B" name="dob" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Profile Picture</label>
              <input type="file" class="form-control" name="pic" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select" required>
                <option selected disabled>Select Status</option>
                <option>ON</option>
                <option>OFF</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Gender</label><br>
              <input type="radio" value="m" id="gen_m" name="gen" required /> Male
              <input type="radio" value="f" id="gen_f" name="gen" /> Female
            </div>

            <div class="mb-3">
              <input type="submit" value="Add Student" name="save" class="btn btn-success" />
              <input type="reset" value="Reset" class="btn btn-secondary" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function showSemester(courseId) {
    if (courseId === "") return;

    fetch(`semester_ajax.php?id=${courseId}`)
      .then(response => response.text())
      .then(data => document.getElementById("semester").innerHTML = data)
      .catch(error => console.error('Error fetching semester:', error));
  }
</script>

                         

    </body>
</html>