<?php
include('../config.php');

// Fetch current teacher details
$q = mysqli_query($con, "SELECT * FROM teacher WHERE teacher_id = '".$_SESSION['teacher_id']."'");
$res = mysqli_fetch_assoc($q);

$err = '';
if (isset($_POST['update'])) {
    $query = "UPDATE teacher 
              SET name = '$n', eid = '$e', password = '$p', mob = '$m', address = '$a', department_id = '$dep_id', sem_id = '$semester' 
              WHERE teacher_id = '".$_SESSION['teacher_id']."'";

    if (mysqli_query($con, $query)) {
        $err = "<div class='alert alert-success'>Records updated successfully.</div>";
    } else {
        $err = "<div class='alert alert-danger'>Failed to update records. Please try again.</div>";
    }
}
?>

<style>
    /* Crazy UI Styling */
    body {
        background: lavenderblush;
        font-family: 'Arial', sans-serif;
        color: white;
    }

    .container {
        margin-top: 0px;
        background-color: rgba(0, 0, 0, 0.6);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(10px);
    }

    h2 {
        font-size: 2.5rem;
        text-align: center;
        color: #fff;
        font-weight: bold;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 30px;
    }

    .form-label {
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .form-select, .form-control {
        background-color: #333;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-size: 1rem;
        color: #fff;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        outline: none;
        box-shadow: 0 0 8px rgba(0, 255, 255, 0.8);
        background-color: #444;
    }

    .btn-primary {
        background: linear-gradient(45deg, #ff3366, #ff6600);
        border: none;
        padding: 12px 25px;
        font-size: 1.2rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        transition: all 0.4s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #ff6600, #ff3366);
        box-shadow: 0 8px 30px rgba(255, 102, 0, 0.7);
        transform: scale(1.05);
    }

    .alert {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #28a745;
        color: white;
    }

    .alert-danger {
        background-color: #dc3545;
        color: white;
    }

    .form-control::placeholder {
        color: #fff;
        opacity: 0.6;
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }

    .text-light {
        color: #fff !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Update Your Profile</h2>
            <?php echo $err; ?>
            <form method="POST">
                <!-- Department Selection -->
                <div class="mb-3">
                    <label for="courseid" class="form-label">Select Department</label>
                    <select name="dep_id" id="courseid" onchange="showSemester(this.value)" class="form-select">
                        <?php
                        $sub = mysqli_query($con, "SELECT * FROM department");
                        while ($s = mysqli_fetch_array($sub)) {
                            $s_id = $s[0];
                        ?>
                            <option value="<?php echo $s_id; ?>" <?php if ($s_id == $res['department_id']) { echo "selected"; } ?>>
                                <?php echo $s[1]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Semester Selection -->
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester Name</label>
                    <select name="semester" id="semester" class="form-select">
                        <?php
                        $sem = mysqli_query($con, "SELECT * FROM semester WHERE department_id = '".$res['department_id']."'");
                        while ($s = mysqli_fetch_array($sem)) {
                            $s_id = $s[0];
                        ?>
                            <option value="<?php echo $s_id; ?>" <?php if ($s_id == $res['sem_id']) { echo "selected"; } ?>>
                                <?php echo $s[1]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Teacher Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Teacher Name</label>
                    <input type="text" id="name" name="n" class="form-control" value="<?php echo $res['name']; ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="e" class="form-control" value="<?php echo $res['eid']; ?>" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="p" class="form-control" value="<?php echo $res['password']; ?>" required>
                </div>

                <!-- Mobile -->
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" id="mobile" name="m" class="form-control" value="<?php echo $res['mob']; ?>" required>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="a" class="form-control" value="<?php echo $res['address']; ?>" required>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" name="update" class="btn btn-primary">Update Records</button>
                </div>
            </form>
        </div>
    </div>
</div>
