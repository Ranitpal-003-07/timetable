<?php 
session_start();
include('../config.php'); // Include your database connection file

// Query to fetch announcements from the database
$query = "SELECT title, description, date FROM announcements ORDER BY date DESC";

// Execute the query
$result = mysqli_query($con, $query);

// Check if there are any announcements
if (mysqli_num_rows($result) > 0) {
    echo "<h3>Latest Announcements</h3>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Title</th><th>Description</th><th>Date</th></tr></thead>";
    echo "<tbody>";

    // Loop through the announcements and display them
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . date('d-m-Y H:i:s', strtotime($row['date'])) . "</td>"; // Format the date
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No announcements available.</p>";
}
?>
