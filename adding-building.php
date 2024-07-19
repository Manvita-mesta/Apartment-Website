<?php

session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}
if (isset($_POST['add_submit'])) {

    $name = addslashes(trim($_POST['name']));
    $builder_name = addslashes(trim($_POST['builder_name']));
    $contact = addslashes(trim($_POST['contact']));
    $address = addslashes(trim($_POST['address']));
    $status = 'Active';
    
    $insertQuery = "INSERT INTO building (name, builder_name, contact, address, Status, date) VALUES ('$name', '$builder_name', '$contact', '$address', '$status', NOW())";

    if (mysqli_query($conn, $insertQuery)) {

        echo "<script>alert('Building Added successfully');location.href='adding-building.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-building.php'</script>";
    }
    
}

if (isset($_POST['update'])) {

    $id = addslashes(trim($_POST['id']));
    $name = addslashes(trim($_POST['name']));
    $builder_name = addslashes(trim($_POST['builder_name']));
    $contact = addslashes(trim($_POST['contact']));
    $address = addslashes(trim($_POST['address']));
    $status = addslashes(trim($_POST['status']));

    $update = "UPDATE building SET name = '$name', builder_name = '$builder_name', contact = '$contact', address = '$address',status = '$status' WHERE id = '$id'";

    if (mysqli_query($conn, $update)) {

        echo "<script>alert('Building Updated successfully');location.href='adding-building.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-building.php'</script>";
    }
    
}

if (isset($_POST['delete_submit'])) {

    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "DELETE from building WHERE id = '$_POST[delete_id]'")) {

        echo "<script>alert('Building Deleted successfully');location.href='adding-building.php'</script>";
    } else {

        echo "<script>alert('Unable to process your request!');location.href='adding-building.php'</script>";
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
          <h1 class="text-white">Buliding</h1>
          <p>Building with a touch of grace</p>
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
                <h2 style="font-weight: bold;">Add Building</h2>

                </div>
                <div class="input-group mt-4 justify-content-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                        <i class="bi bi-plus-square-fill me-2"></i> Add Building
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
                        <th scope="col">Name</th>
                        <th scope="col">Builder Name</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Address</th>
                        <!-- <th scope="col">Date</th> -->
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM building";
                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['builder_name']}</td>";
                            echo "<td>{$row['contact']}</td>";
                            echo "<td>{$row['address']}</td>";
                            // echo "<td>" . date('d-M-Y', strtotime($row['date'])) . "</td>";
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
                    <div class="modal fade" id="update<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="addLabel">Update Building Details</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Building Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" maxlength="100" name="name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." value="<?php echo htmlspecialchars($row['name']); ?>">
                                        </div>
                                    </div>

                                        <div class="form-group row">
                                            <label for="builder_name" class="col-sm-3 col-form-label">Builder Name<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="builder_name" maxlength="100" name="builder_name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." value="<?php echo htmlspecialchars($row['builder_name']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="contact" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="contact" pattern="\d{10}" title="The contact number should be exactly 10 digits."maxlength="100" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-3 col-form-label">Address<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="address" maxlength="100" name="address" value="<?php echo htmlspecialchars($row['address']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select class="default-select form-control" id="status" name="status">
                                                        <option value="">Choose Status</option>
                                                        <option value="Active" <?php echo $row['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="In-Active" <?php echo $row['status'] == 'In-Active' ? 'selected' : ''; ?>>In-Active</option>
                                                    </select>
                                                </div>
                                            </div>
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
                            <h3 class="modal-title fs-5" id="addLabel">Add Building Details</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Building Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" maxlength="100" required name="name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces.">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="builder_name" class="col-sm-3 col-form-label">Builder Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="builder_name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." maxlength="100" required name="builder_name">
                                </div>
                            </div>
                            <div class="form-group row">
    <label for="contact" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="contact" maxlength="10" required name="contact" pattern="\d{10}" title="The contact number should be exactly 10 digits.">
    </div>
</div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 col-form-label">Address<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="address" maxlength="100" required name="address">
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