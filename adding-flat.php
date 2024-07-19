<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}

if (isset($_POST['add_submit'])) {
    $building_id = $_POST['building_id'];
    $flat_number = 'FLAT' . $_POST['flat_number'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');
  
    $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  
    if (move_uploaded_file($_FILES['image']['tmp_name'], "flat/" . $imagePath)) {
        $insertQuery = "INSERT INTO flat (building_id, flat_number, description, image, status, date) 
        VALUES ('$building_id', '$flat_number', '$description', '$imagePath', 'Available', '$date')";
        
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Flat Added successfully..!'); window.location.href = 'adding-flat.php';</script>";
        } else {
            // Error alert
            echo "<script>alert('Ooops, Unable to submit Request..!');</script>";
         }
    } else {
        echo "<script>alert('Unable to upload image on server.');</script>";
    }   
}

// Update Flat
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $building_id = $_POST['building_id'];
    $flat_number = 'FLAT' . $_POST['flat_number'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update = "UPDATE flat SET building_id = '$building_id', flat_number = '$flat_number', description = '$description', status = '$status' WHERE id = '$id'";

    // Execute update query
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Flat Updated successfully');location.href='adding-flat.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-flat.php'</script>";
    }   
}

// Delete Flat
if (isset($_POST['delete_submit'])) {
    $flat_id = $_POST['delete_id'];

    // Delete flat
    $deleteQuery = "DELETE FROM flat WHERE id = '$flat_id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Flat deleted successfully');location.href='adding-flat.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-flat.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'include/header-link.php'; ?>
<body>
<div class="site-wrap">
    <div class="site-navbar mt-4">
        <?php require_once 'include/header.php'; ?>
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
                <h1 class="text-white">Flat</h1>
                <p>Discover the epitome of style and convienc.</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="service_detail text-center">
                    <h2 style="font-weight: bold;">Add Flat</h2>
                </div>
                <div class="input-group mt-4 justify-content-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                        <i class="bi bi-plus-square-fill me-2"></i> Add Flat
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <style>
            .container-fluid {
                width: 80%;
            }
        </style>
        <div class="row py-4">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Building</th>
                    <th scope="col">Flat Number</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT flat.*, building.name AS building_name FROM flat LEFT JOIN building ON flat.building_id = building.id";

                $res = mysqli_query($conn, $sql);

                if (mysqli_num_rows($res) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$row['building_name']}</td>";
                        echo "<td>{$row['flat_number']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td><img src='flat/{$row['image']}' alt='Flat image' style='max-width: 80px; max-height: 80px;'></td>";
                        echo "<td>" . date('d-M-Y', strtotime($row['date'])) . "</td>";
                        echo "<td>{$row['status']}</td>";
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
                                            <h3 class="modal-title fs-5" id="updateLabel">Update Flat Details</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="building_id" class="col-sm-3 col-form-label">Building Name</label>
                                                <div class="col-sm-9">
                                                    <select class="default-select form-control" id="building_id" name="building_id">
                                                        <option value="">Select Building Name</option>
                                                        <?php
                                                        $res1 = mysqli_query($conn, "SELECT id, name FROM building WHERE status ='Active'");
                                                        if (mysqli_num_rows($res1) > 0) {
                                                            while ($row1 = mysqli_fetch_assoc($res1)) {
                                                                $selected = $row['building_id'] == $row1['id'] ? "selected" : "";
                                                                echo "<option value='{$row1['id']}' $selected>{$row1['name']}</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="flat_number" class="col-sm-3 col-form-label">Flat Number<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="flat_number" maxlength="100" pattern="\d+" title="Please enter only numbers for the flat number." name="flat_number" value="<?php echo substr($row['flat_number'], 4); ?>" placeholder="Flat Number">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label">Description<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="description" maxlength="100" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" placeholder="Description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select class="default-select form-control" id="status" name="status">
                                                        <option value="">Choose Status</option>
                                                        <option value="Available" <?php echo $row['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                                                        <option value="Owned" <?php echo $row['status'] == 'Owned' ? 'selected' : ''; ?>>Owned</option>
                                                    </select>
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
                            <h3 class="modal-title fs-5" id="addLabel">Add Flat Details</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="building_name" class="col-sm-3 col-form-label">Building Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="building_id" name="building_id" required>
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
                                <label for="flat_number" class="col-sm-3 col-form-label">Flat Number<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="flat_number" maxlength="100" name="flat_number" placeholder="Flat Number" required pattern="\d+" title="Please enter only numbers for the flat number.">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="description" maxlength="100" name="description" placeholder="Description" required>
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

<?php require_once 'include/footer.php'; ?>
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
