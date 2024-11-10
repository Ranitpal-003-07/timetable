<?php

function generate_time_table($con, $courseid, $s, $debug = false) {
    // Sanitize inputs
    $courseid = mysqli_real_escape_string($con, $courseid);
    $s = mysqli_real_escape_string($con, $s);

    // Query to fetch subjects
    $query = "SELECT * FROM subject WHERE department_id = $courseid AND sem_id = $s";
    $que = mysqli_query($con, $query);
    
    if (!$que) {
        echo "<p>Error executing query: " . mysqli_error($con) . "</p>";
        return false;
    }

    $rows = mysqli_num_rows($que);
    
    if ($rows == 0) {
        echo "<p>No subjects found for this course and semester.</p>";
        return false;
    }

    $subjects = [];
    while ($row = mysqli_fetch_assoc($que)) {
        $subjects[] = $row;
    }

    // Debug: Display subjects fetched from the database
    if ($debug) {
        echo "<pre>";
        print_r($subjects);
        echo "</pre>";
    }
    
    $weekTimeTable = [];

    // Loop through each day (Monday to Friday)
    for ($i = 0; $i < 5; $i++) {
        $dayTimeTable = [];
        shuffle($subjects); // Shuffle subjects for variety

        $pointer = 0;
        // Loop through each period in a day (6 periods)
        for ($j = 0; $j < 6; $j++) {
            $attempts = 0;
            // Check if the subject has lectures left
            while ($subjects[$pointer]['lecture_per_week'] <= 0 && $attempts < count($subjects)) {
                $pointer = ($pointer === count($subjects) - 1) ? 0 : $pointer + 1;
                $attempts++;
            }

            if ($attempts === count($subjects)) {
                // If no subject can be assigned, add "Empty" slot
                $dayTimeTable[] = "Empty";
                continue;
            }

            // For Labs: handle double periods (colspan for labs)
            if ($subjects[$pointer]['type'] === "Lab" && in_array($j, [1, 2, 4])) {
                // Check if there are still enough periods left for a double period
                if ($j < 5) {
                    $dayTimeTable[] = $subjects[$pointer];
                    $dayTimeTable[] = $subjects[$pointer];
                    $subjects[$pointer]['lecture_per_week']--;
                    $pointer = ($pointer === count($subjects) - 1) ? 0 : $pointer + 1;
                    $j++; // Skip next period as lab takes two periods
                } else {
                    $dayTimeTable[] = "Empty"; // If no double period can be assigned
                }
            } 
            // For Theory subjects: assign a single period
            else if ($subjects[$pointer]['type'] === "Theory") {
                $dayTimeTable[] = $subjects[$pointer];
                $subjects[$pointer]['lecture_per_week']--;
                $pointer = ($pointer === count($subjects) - 1) ? 0 : $pointer + 1;
            } else {
                $dayTimeTable[] = "Empty";
            }
        }
        $weekTimeTable[] = $dayTimeTable;
    }

    // Debug: Output the timetable in an HTML table format for debugging
    if ($debug) {
        echo "<h3>Generated TimeTable:</h3><table class='table table-bordered table-striped'>";
        echo "<thead><tr><th>Days / Lecture</th><th>Lecture 1</th><th>Lecture 2</th><th>Lecture 3</th><th>Lecture 4</th><th>Lecture 5</th><th>Lecture 6</th></tr></thead><tbody>";
        
        $weekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        
        for ($i = 0; $i < 5; $i++) {
            echo "<tr><td>" . $weekDays[$i] . "</td>";
            for ($j = 0; $j < 6; $j++) {
                $cell = $weekTimeTable[$i][$j];
                if (is_array($cell) && $cell['type'] === 'Lab') {
                    echo "<td colspan='2'>" . $cell['subject_name'] . "</td>";
                    $j++; // Skip next period for the lab
                } else {
                    echo "<td>" . (is_array($cell) ? $cell['subject_name'] : $cell) . "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    }

    return $weekTimeTable;
}
?>
