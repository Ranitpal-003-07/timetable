<strong>
    <option value="" selected="selected" disabled="disabled">Select Semester</option>
    <?php 
    include('config.php');

    $q = mysqli_query($con, "SELECT * FROM department WHERE department_id='" . $_GET['id'] . "'");

    while ($res = mysqli_fetch_assoc($q)) {
        echo "<option value='" . $res['department_id'] . "'>" . $res['department_name'] . "</option>";
    }
    ?>
</strong>
