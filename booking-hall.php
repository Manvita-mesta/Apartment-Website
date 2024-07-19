<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit;
}

if (isset($_POST['add_submit'])) {

    $user_id = addslashes(trim($_POST['user_id']));
    $building_id = addslashes(trim($_POST['building_id']));
    $hall_id = addslashes(trim($_POST['hall_id']));
    $from_date = addslashes(trim($_POST['from_date']));
    $to_date = addslashes(trim($_POST['to_date']));
    $booking_type = 'Hall';

    $checkQuery = "SELECT * FROM booking WHERE building_id = '$building_id' AND hall_id='$hall_id' AND (('$from_date' BETWEEN from_date AND to_date) OR ('$to_date' BETWEEN from_date AND to_date) OR (from_date BETWEEN '$from_date' AND '$to_date') OR (to_date BETWEEN '$from_date' AND '$to_date'))";

    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('The selected dates are already booked for this hall. Please choose different dates.');location.href='booking-hall.php'</script>";
    } else {
        $insertQuery = "INSERT INTO booking (user_id, building_id, hall_id, from_date, to_date, booking_type, booking_date) VALUES ('$user_id', '$building_id', '$hall_id', '$from_date', '$to_date', '$booking_type', NOW())";

        if (mysqli_query($conn, $insertQuery)) {
            $updateQuery = "UPDATE hall SET status = 'Owned' WHERE id = '$hall_id'";
            mysqli_query($conn, $updateQuery);

            echo "<script>alert('Booked Hall successfully');location.href='booking-hall.php'</script>";
        } else {
            echo "<script>alert('Unable to process your request!');location.href='booking-hall.php'</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once 'include/header-link.php';?>
<body>
<div class="site-wrap">

    <div class="site-navbar mt-4">
        <?php require_once 'include/header.php';?>
    </div>

    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div> 
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');"
         data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
                    <h1 class="text-white">Booking Hall</h1>
                    <p>Enter our hall where every event becomes extraordinary</p>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section border-bottom">
        <div class="container">
            <h2 style="font-weight: bold; text-align: center;">Booking Hall</h2><br>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-7 mb-5">
                    <form action="" method="POST" class="booking-flat-form">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="user_id">User</label>
                                <select id="user_id" name="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    <?php
                                    $res2 = mysqli_query($conn, "SELECT id, name FROM user WHERE type ='User'");
                                    if (mysqli_num_rows($res2) > 0) {
                                        while ($row = mysqli_fetch_assoc($res2)) {
                                            echo "<option value='$row[id]'>$row[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="building_id">Building</label>
                                <select id="building_id" name="building_id" class="form-control" required>
                                    <option value="">Select Building</option>
                                    <?php
                                    $res2 = mysqli_query($conn, "SELECT id, name FROM building WHERE status ='Active'");
                                    if (mysqli_num_rows($res2) > 0) {
                                        while ($row = mysqli_fetch_assoc($res2)) {
                                            echo "<option value='$row[id]'>$row[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
    <div class="col-md-12">
        <label class="font-weight-bold" for="hall_id">Hall</label>
        <select id="hall_id" name="hall_id" class="form-control" required>
            <option value="">Select Hall</option>
        </select>
    </div>
</div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="from_date">From Date</label>
                                <input type="date" id="from_date" name="from_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="to_date">To Date</label>
                                <input type="date" id="to_date" name="to_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="submit" value="Submit" name="add_submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'include/footer.php';?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Include Bootstrap DateTimePicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <!-- Include Bootstrap DateTimePicker JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#building_id').change(function() {
            var building_id = $(this).val();
            if (building_id !== '') {
                $.ajax({
                    url: 'fetch_halls.php', // Update the URL according to your file structure
                    type: 'POST',
                    data: { building_id: building_id },
                    success: function(response) {
                        $('#hall_id').html(response);
                    }
                });
            } else {
                $('#hall_id').html('<option value="">Select Hall</option>');
            }
        });
    });
</script>


</body>
</html>
