<?php
session_start();
include('../config.php');

// Check if the admin session is set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == "") {
    header("Location: login.php");
    exit;
}

// Add a new announcement
if (isset($_POST['submit_announcement'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $date = date('Y-m-d H:i:s'); // Current timestamp

    // Insert the new announcement into the database
    $query = "INSERT INTO announcements (title, description, date) VALUES ('$title', '$description', '$date')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Announcement added successfully!'); window.location.href='manage_announcements.php';</script>";
    } else {
        echo "<script>alert('Error adding announcement!');</script>";
    }
}

// Edit an existing announcement
if (isset($_POST['update_announcement'])) {
    $announcement_id = $_POST['announcement_id'];
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

// Delete an announcement
if (isset($_GET['delete_id'])) {
    $announcement_id = $_GET['delete_id'];

    // Delete the announcement from the database
    $query = "DELETE FROM announcements WHERE id='$announcement_id'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Announcement deleted successfully!'); window.location.href='manage_announcements.php';</script>";
    } else {
        echo "<script>alert('Error deleting announcement!');</script>";
    }
}

// Fetch all announcements
$query = "SELECT * FROM announcements ORDER BY date DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .announcement-card {
            margin-bottom: 20px;
        }

        .announcement-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .announcement-card .card-body {
            background-color: #e9ecef;
        }

        .btn-edit, .btn-delete {
            background-color: #007bff;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Manage Announcements</h3>
        <hr>

        <!-- Add Announcement Form -->
        <h4>Add New Announcement</h4>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_announcement" class="btn btn-success">Submit Announcement</button>
        </form>

        <hr>

        <!-- List All Announcements -->
        <h4>Existing Announcements</h4>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="card announcement-card">
                    <div class="card-header">
                        <?php echo $row['title']; ?> (<?php echo date('F j, Y, g:i a', strtotime($row['date'])); ?>)
                    </div>
                    <div class="card-body">
                        <p><?php echo nl2br($row['description']); ?></p>

                        <!-- Edit and Delete Buttons -->
                        <a href="edit_announcement.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
                        </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center">No announcements found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
