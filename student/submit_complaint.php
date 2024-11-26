<?php 
session_start();
include('../config.php');

// Redirect to login if session variables are missing
if (empty($_SESSION['stu_id']) || empty($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}

// Handle complaint submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch form data
    $complaint_description = mysqli_real_escape_string($con, $_POST['complaint_description']);
    $complaint_by = $_SESSION['name']; // Store the name of the user who submitted the complaint

    // Insert the complaint into the database
    $query = "INSERT INTO complaints (complaint_description, complaint_by) 
              VALUES ('$complaint_description', '$complaint_by')";
    
    if (mysqli_query($con, $query)) {
        $message = "Complaint submitted successfully!";
    } else {
        $message = "Error: " . mysqli_error($con);
    }
}

// Fetch complaints from the database
$query = "SELECT * FROM complaints ORDER BY date_created DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submit Complaint</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Submit a Complaint</h2>

        <?php if (isset($message)) { ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <!-- Complaint Submission Form -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="complaint_description" class="form-label">Complaint Description</label>
                <textarea id="complaint_description" name="complaint_description" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Complaint</button>
        </form>

        <h3 class="mt-5">Submitted Complaints</h3>
        <!-- Display Complaints Table -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Complaint Description</th>
                    <th>Complaint By</th>
                    <th>Submitted On</th>
                    <th>Answer/Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['complaint_id'] . "</td>
                                <td>" . $row['complaint_description'] . "</td>
                                <td>" . $row['complaint_by'] . "</td>
                                <td>" . $row['date_created'] . "</td>
                                <td>" . ($row['answer_reply'] ? $row['answer_reply'] : 'Not answered yet') . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No complaints submitted yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
