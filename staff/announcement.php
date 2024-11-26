<?php
// Handle announcement submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcement_title = mysqli_real_escape_string($con, $_POST['announcement_title']);
    $announcement_description = mysqli_real_escape_string($con, $_POST['announcement_description']);
    $date_created = date("Y-m-d H:i:s");

    // Insert the announcement into the database
    $query = "INSERT INTO announcements (title, description, date) 
              VALUES ('$announcement_title', '$announcement_description', '$date_created')";

    if (mysqli_query($con, $query)) {
        $message = "Announcement added successfully!";
    } else {
        $message = "Error: " . mysqli_error($con);
    }
}

// Fetch existing announcements
$query = "SELECT * FROM announcements ORDER BY date DESC";
$result = mysqli_query($con, $query);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container">
    <h2>Add New Announcement</h2>

    <!-- Display message if any -->
    <?php if (isset($message)) { ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- Announcement Form -->
    <form action="" method="POST">
        <div class="mb-3">
            <label for="announcement_title" class="form-label">Title</label>
            <input type="text" id="announcement_title" name="announcement_title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="announcement_description" class="form-label">Description</label>
            <textarea id="announcement_description" name="announcement_description" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Announcement</button>
    </form>

    <hr>

    <!-- Display Announcements -->
    <h3>All Announcements</h3>
    <?php if (count($announcements) > 0) { ?>
        <ul class="list-group">
            <?php foreach ($announcements as $announcement) { ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($announcement['title']); ?></h5>
                    <p><?php echo nl2br(htmlspecialchars($announcement['description'])); ?></p>
                    <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($announcement['date'])); ?></small>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No announcements found.</p>
    <?php } ?>
</div>
