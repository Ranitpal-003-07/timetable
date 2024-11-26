<?php
session_start();
include('../config.php');

// Check if the admin session is set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == "") {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $announcement_id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch the announcement data
    $query = "SELECT * FROM announcements WHERE id = '$announcement_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Announcement not found!'); window.location.href='manage_announcements.php';</script>";
        exit;
    }
}

if (isset($_POST['update_announcement'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Update the announcement in the database
    $query = "UPDATE announcements SET title='$title', description='$description' WHERE id='$announcement_id'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Announcement updated successfully!'); window.location.href='manage_announcements.php';</script>";
    } else {
        echo "<script>alert('Error updating announcement!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <h3>Edit Announcement</h3>

        <form method="POST" action="">
            <input type="hidden" name="announcement_id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" required><?php echo $row['description']; ?></textarea>
            </div>
            <button type="submit" name="update_announcement" class="btn btn-primary">Update Announcement</button>
        </form>

        <hr>
        <a href="manage_announcements.php" class="btn btn-secondary">Back to Announcements</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
