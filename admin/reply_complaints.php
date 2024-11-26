<?php
session_start();
include('../config.php');

// Check if the admin session is set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == "") {
    header("Location: login.php");
    exit;
}

// Handle complaint reply submission
if (isset($_POST['submit_reply'])) {
    $complaint_id = $_POST['complaint_id'];
    $reply = mysqli_real_escape_string($con, $_POST['reply']);
    $date_answered = date('Y-m-d H:i:s'); // Current timestamp
    
    // Update the complaint with the admin's reply and set date_answered
    $query = "UPDATE complaints SET answer_reply='$reply', date_answered='$date_answered' WHERE complaint_id='$complaint_id'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Reply added successfully!'); window.location.href='?info=complaints';</script>";
    } else {
        echo "<script>alert('Error adding reply!');</script>";
    }
}

// Fetch all unresolved complaints
$query = "SELECT * FROM complaints WHERE answer_reply IS NULL";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Complaints</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .complaint-card {
            margin-bottom: 20px;
        }

        .complaint-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .complaint-card .card-body {
            background-color: #e9ecef;
        }

        .btn-reply {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Manage Complaints</h3>
        <hr>
        
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="card complaint-card">
                    <div class="card-header">
                        Complaint from: <?php echo $row['complaint_by']; ?> (<?php echo date('F j, Y, g:i a', strtotime($row['date_created'])); ?>)
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Complaint Description:</h5>
                        <p><?php echo nl2br($row['complaint_description']); ?></p>

                        <!-- Form to add a reply -->
                        <form method="POST" action="">
                            <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                            <div class="mb-3">
                                <label for="reply" class="form-label">Your Reply</label>
                                <textarea class="form-control" name="reply" rows="4" required></textarea>
                            </div>
                            <button type="submit" name="submit_reply" class="btn btn-reply">Submit Reply</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center">No pending complaints.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
