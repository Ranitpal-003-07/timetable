<strong>
    <option value="" selected="selected" disabled="disabled">Select Semester</option>
    <?php 
    // Include the database connection file
    include('config.php');

    // Query the database to get the department details using the provided department ID
    $q = mysqli_query($con, "SELECT * FROM department WHERE department_id='" . $_GET['id'] . "'");

    // Loop through the results and display the department options
    while ($res = mysqli_fetch_assoc($q)) {
        echo "<option value='" . $res['department_id'] . "'>" . $res['department_name'] . "</option>";
    }
    ?>
</strong>
