<?php

session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}
if (isset($_POST['add_submit'])) {

    $building_id = addslashes(trim($_POST['building_id']));
    $facility = addslashes(trim($_POST['facility']));
    $description = addslashes(trim($_POST['description']));
    $status = 'Active';
    
    $insertQuery = "INSERT INTO facility (building_id, facility, description, Status, date) VALUES ('$building_id', '$facility', '$description', '$status', NOW())";

    if (mysqli_query($conn, $insertQuery)) {

        echo "<script>alert('Facility Added successfully');location.href='adding-facility.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-facility.php'</script>";
    }
    
}

if (isset($_POST['update'])) {

    $id = addslashes(trim($_POST['id']));
    $building_id = addslashes(trim($_POST['building_id']));
    $facility = addslashes(trim($_POST['facility']));
    $description = addslashes(trim($_POST['description']));
    $status = addslashes(trim($_POST['status']));

    $update = "UPDATE facility SET building_id = '$building_id', facility = '$facility', description = '$description', status = '$status' WHERE id = '$id'";

    if (mysqli_query($conn, $update)) {

        echo "<script>alert('Facility Updated successfully');location.href='adding-facility.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-facility.php'</script>";
    }
    
}

if (isset($_POST['delete_submit'])) {

    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "DELETE from facility WHERE id = '$_POST[delete_id]'")) {

        echo "<script>alert('Facility Deleted successfully');location.href='adding-facility.php'</script>";
    } else {

        echo "<script>alert('Unable to process your request!');location.href='adding-facility.php'</script>";
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
          <h1 class="text-white">Facility</h1>
          <p>Experience excellence in every corner of our exceptional facility</p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section">
  <style>
            .container-fluid{
                 width: 85%;
            }
        </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="service_detail text-center">
                <h2 style="font-weight: bold;">Add Facility</h2>

                </div>
                <div class="input-group mt-4 justify-content-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                        <i class="bi bi-plus-square-fill me-2"></i> Add Facility
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row py-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Building Name</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <!-- <th scope="col">Status</th> -->
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP loop to populate table rows -->
                    <?php
                    $sql = "SELECT facility.*, building.name AS building_name FROM facility LEFT JOIN building ON facility.building_id = building.id";
                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['building_name']}</td>";
                            echo "<td>{$row['facility']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td>" . date('d-M-Y', strtotime($row['date'])) . "</td>";
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
                    <div class="modal fade" id="update<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="addLabel">Update Facility Details</h3>
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
                                            <label for="facility" class="col-sm-3 col-form-label">Facility<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="facility" maxlength="100" pattern="^(?:[A-Za-z]+(?: [A-Za-z]+)*|[\w\s]*)$" title="The name should only contain letters, spaces, and special characters." name="facility" value="<?php echo htmlspecialchars($row['facility']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-3 col-form-label">Description<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text_area" class="form-control" id="description" maxlength="100" name="description" value="<?php echo htmlspecialchars($row['description']); ?>">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select class="default-select form-control" id="status" name="status">
                                                        <option value="">Choose Status</option>
                                                        <option value="Active" <?php echo $row['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="In-Active" <?php echo $row['status'] == 'In-Active' ? 'selected' : ''; ?>>In-Active</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                        <input autocomplete='off' type="hidden" name="id" value="<?php echo $row['id']; ?>" />
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
                            <h3 class="modal-title fs-5" id="addLabel">Add Facility Details</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group row">
                                <label for="building_name" class="col-sm-3 col-form-label">Building Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="building_name" name="building_id" required>
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
                                <label for="facility" class="col-sm-3 col-form-label">Facility<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="facility" pattern="^(?:[A-Za-z]+(?: [A-Za-z]+)*|[\w\s]*)$" title="The name should only contain letters, spaces." maxlength="100" required name="facility">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">description<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="description" maxlength="100" required name="description">
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

  </body>
</html>