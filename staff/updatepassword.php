<?php
include('../config.php');

// Fetch current password for the logged-in teacher
$q = mysqli_query($con, "SELECT * FROM teacher WHERE teacher_id = '".$_SESSION['teacher_id']."'");
$res = mysqli_fetch_assoc($q);
$opass = $res['password'];

$err = '';
if (isset($_POST['update'])) {
    $op = $_POST['op'] ?? '';
    $np = $_POST['np'] ?? '';
    $cp = $_POST['cp'] ?? '';

    if (empty($op) || empty($np) || empty($cp)) {
        $err = "<div class='alert alert-danger'>Please fill in all fields.</div>";
    } else {
        if ($op === $opass) {
            if ($np === $cp) {
                mysqli_query($con, "UPDATE teacher SET password = '$np' WHERE teacher_id = '".$_SESSION['teacher_id']."'");
                $err = "<div class='alert alert-success'>Password updated successfully.</div>";
            } else {
                $err = "<div class='alert alert-danger'>New password and confirm password do not match.</div>";
            }
        } else {
            $err = "<div class='alert alert-danger'>Old password is incorrect.</div>";
        }
    }
}
?>

<style>
    /* Crazy UI Styling */
    body {
        background: lavenderblush;
        font-family: 'Arial', sans-serif;
        color: white;
        overflow-x: hidden;
    }

    .container {
        margin-top: 10px;
        padding: 40px;
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
    }

    h2 {
        font-size: 2.5rem;
        text-align: center;
        color: #fff;
        font-weight: bold;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        margin-bottom: 30px;
    }

    .form-label {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .form-control {
        background-color: #222;
        border-radius: 10px;
        padding: 12px;
        font-size: 1.1rem;
        color: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 12px rgba(255, 0, 255, 0.8);
        background-color: #333;
    }

    .form-control::placeholder {
        color: #ddd;
        opacity: 0.8;
    }

    .btn-primary {
        background: linear-gradient(45deg, #ff6600, #ff3366);
        border: none;
        padding: 15px 25px;
        font-size: 1.2rem;
        text-transform: uppercase;
        border-radius: 30px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        transition: all 0.4s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #ff3366, #ff6600);
        transform: scale(1.05);
        box-shadow: 0 8px 30px rgba(255, 102, 0, 0.8);
    }

    .alert {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border-radius: 8px;
    }

    .alert-danger {
        background-color: #dc3545;
        color: white;
        padding: 10px;
        border-radius: 8px;
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }
</style>

<div class="container">
    <h2>Update Your Password</h2>
    <?php if (!empty($err)) echo $err; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="oldPassword" class="form-label">Old Password</label>
            <input type="password" id="oldPassword" name="op" class="form-control" placeholder="Enter your old password" required>
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" id="newPassword" name="np" class="form-control" placeholder="Enter your new password" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" id="confirmPassword" name="cp" class="form-control" placeholder="Confirm your new password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="update">Update Password</button>
    </form>
</div>
