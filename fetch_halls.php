<?php
require_once 'config/connection.php';

if (isset($_POST['building_id'])) {
    $building_id = $_POST['building_id'];
    $query = "SELECT id, hall_name FROM hall WHERE building_id = '$building_id'";
    $result = mysqli_query($conn, $query);
    $options = '<option value="">Select Hall</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id']}'>{$row['hall_name']}</option>";
    }
    echo $options;
}
?>
