<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}

    if (isset($_POST['add_submit'])) {

        $bulding_id = $_POST['bulding_id'];
        $visitor_name = $_POST['visitor_name'];
        $phone = $_POST['phone'];
        $purpose = $_POST['purpose'];
        $vehicle_number = $_POST['vehicle_number'];
        $time_in = $_POST['time_in'];
        $date = date('Y-m-d H:i:s');
      
        $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      
        if (move_uploaded_file($_FILES['image']['tmp_name'], "visitor/" . $imagePath)) {
            
            
            $insertQuery = "INSERT INTO visitors (bulding_id, visitor_name, phone, purpose, vehicle_number, time_in, image, status) 
            VALUES ('$bulding_id', '$visitor_name', '$phone', '$purpose', '$vehicle_number', '$time_in', '$imagePath', 'Active')";
            
      
            if (mysqli_query($conn, $insertQuery)) {
                echo "<script>alert('Your Request sent successfully..!'); window.location.href = 'adding-visitor.php';</script>";
            } else {
                // Error alert
                echo "<script>alert('Ooops, Unable to submit Request..!');</script>";
             }
        } else {
            echo "<script>alert('Unable to upload image on server.');</script>";
        }   
      }

if (isset($_POST['update'])) {

    $id = addslashes(trim($_POST['id']));
    $bulding_id = addslashes(trim($_POST['bulding_id']));
    $visitor_name = addslashes(trim($_POST['visitor_name']));
    $phone = addslashes(trim($_POST['phone']));
    $purpose = addslashes(trim($_POST['purpose']));
    $vehicle_number = $_POST['vehicle_number'];
    $time_in = $_POST['time_in'];

    $update = "UPDATE visitors SET bulding_id = '$bulding_id', visitor_name = '$visitor_name', phone = '$phone', purpose = '$purpose', vehicle_number = '$vehicle_number', time_in = '$time_in' WHERE id = '$id'";

    if (mysqli_query($conn, $update)) {

        echo "<script>alert('visitors Updated successfully');location.href='adding-visitor.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-visitor.php'</script>";
    }
    
}

if (isset($_POST['delete_submit'])) {

    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "DELETE from visitors WHERE id = '$_POST[delete_id]'")) {

        echo "<script>alert('visitors deleted successfully');location.href='adding-visitor.php'</script>";
    } else {

        echo "<script>alert('Unable to process your request!');location.href='adding-visitor.php'</script>";
    }
}
?>

<?php
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'include/header-link.php';?>
  <body>
  <div class="site-wrap">

    <div class="site-navbar mt-4">
    <?php require_once 'include/header.php';?>
      </div>
    </div>

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');"
    data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
          <h1 class="text-white">Visitor</h1>
          <p>Step into comfort</p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="service_detail text-center">
                <h2 style="font-weight: bold;">Add Visitor</h2>

                </div>
                <div class="input-group mt-4 justify-content-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                        <i class="bi bi-plus-square-fill me-2"></i> Add Visitor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <style>
            .container-fluid{
                 width: 80%;
            }
        </style>
        <div class="row py-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Building</th>
                        <th scope="col">Visitor Name</th>
                        <th scope="col">phone</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Vehicle Number</th>
                        <th scope="col">Time In</th>
                        <th scope="col">image</th>
                        <!-- <th scope="col">Status</th> -->
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT visitors.*, building.name AS building_name FROM visitors LEFT JOIN building ON visitors.bulding_id = building.id";

                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['building_name']}</td>";
                            echo "<td>{$row['visitor_name']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>{$row['purpose']}</td>";
                            echo "<td>{$row['vehicle_number']}</td>";
                            echo "<td>" . date('h:i A', strtotime($row['time_in'])) . "</td>";
                            echo "<td><img src='visitor/{$row['image']}' alt='Visitor image' style='max-width: 80px; max-height: 80px;'></td>";
                            // echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input autocomplete='off' type='hidden' name='delete_id' value='{$row['id']}'/>";
                            echo "<button type='submit' name='delete_submit' onClick='return confirm(\"Are you sure you want to delete?\")' class='btn btn-danger shadow btn-xs sharp'><i class='fas fa-trash'></i></button>";
                            echo "<button type='button' data-toggle='modal' data-target='#update{$row['id']}' class='btn btn-primary shadow btn-xs sharp'><i class='fas fa-pencil-alt'></i></button>";
                            echo "</form>";
                            
                            echo "</td>";
                            echo "</tr>";
                            $i++;

                    ?>
                   <div class="modal fade" id="update<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="updateLabel">Update Visitor Details</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="bulding_id" class="col-sm-3 col-form-label">Building Name</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="bulding_id" name="bulding_id" required>
                                                    <option value="">Select Building Name</option>
                                                    <?php
                                                    $res2 = mysqli_query($conn, "SELECT id, name FROM building WHERE status ='Active'");
                                                    if (mysqli_num_rows($res2) > 0) {
                                                        while ($building_row = mysqli_fetch_assoc($res2)) {
                                                            // Check if the building ID matches the one from the database, then select it
                                                            $selected = ($building_row['id'] == $row['bulding_id']) ? 'selected' : '';
                                                            echo "<option value='{$building_row['id']}' $selected>{$building_row['name']}</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="visitor_name" class="col-sm-3 col-form-label">Visitor Name<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="visitor_name" maxlength="100" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." name="visitor_name" value="<?php echo htmlspecialchars($row['visitor_name']); ?>" placeholder="Visitor Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label">Phone<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="phone" maxlength="100" pattern="\d{10}" title="The contact number should be exactly 10 digits." name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="purpose" class="col-sm-3 col-form-label">Purpose<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="purpose" maxlength="100" name="purpose" value="<?php echo htmlspecialchars($row['purpose']); ?>" placeholder="Purpose">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_number" class="col-sm-3 col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="vehicle_number" maxlength="100" name="vehicle_number" value="<?php echo htmlspecialchars($row['vehicle_number']); ?>" placeholder="Vehicle Number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="time_in" class="col-sm-3 col-form-label">Time In<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="time" class="form-control" id="time_in" name="time_in" value="<?php echo htmlspecialchars($row['time_in']); ?>" placeholder="Time In">
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="update" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php

                    }
                }
                ?>
            </tbody>
            </table>
        </div>

        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="addLabel">Add Visitor Details</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="building_name" class="col-sm-3 col-form-label">Building Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="bulding_id" name="bulding_id" required>
                                        <option value="">Select Building Name</option>
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

                                        <div class="form-group row">
                                            <label for="visitor_name" class="col-sm-3 col-form-label">Visitor Name<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="visitor_name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." maxlength="100" name="visitor_name" placeholder="Visitor Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label">Phone<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="phone" pattern="\d{10}" title="The contact number should be exactly 10 digits." maxlength="100" name="phone" placeholder="Phone" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="purpose" class="col-sm-3 col-form-label">Purpose<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="purpose" maxlength="100" name="purpose" placeholder="Purpose" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_number" class="col-sm-3 col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="vehicle_number" maxlength="100" name="vehicle_number" placeholder="Vehicle Number" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
    <label for="time_in" class="col-sm-3 col-form-label">Time In<span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <input type="time" class="form-control" id="time_in" name="time_in" placeholder="Time In" required>
    </div>
</div>

                                        <div class="form-group row">
                                        <label for="image" class="col-sm-3 col-form-label">Image<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                        </div>
                                    </div>
                                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="add_submit" class="btn btn-primary">Submit</button>
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
    $(document).ready(function () {
        // Initialize DateTimePicker with options
        $('#time_in').datetimepicker({
            format: 'LT', // 12-hour format
            stepping: 30, // 30-minute intervals
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        });
    });
</script>

  </body>
</html>