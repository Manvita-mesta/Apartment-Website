<?php
require_once 'config/connection.php';

if (isset($_POST['building_id'])) {
    $building_id = $_POST['building_id'];
    $query = "SELECT id, flat_number FROM flat WHERE building_id = '$building_id'";
    $result = mysqli_query($conn, $query);
    $options = '<option value="">Select Flat Number</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id']}'>{$row['flat_number']}</option>";
    }
    echo $options;
}
?>
