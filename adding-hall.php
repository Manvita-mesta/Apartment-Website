<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}

if (isset($_POST['add_submit'])) {
    $building_id = $_POST['building_id'];
    $hall_name = $_POST['hall_name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $date = date('Y-m-d H:i:s');

    $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES['image']['tmp_name'], "hall/" . $imagePath)) {
        $sql = "INSERT INTO hall (building_id, hall_name, description, capacity, image, status, date) 
                VALUES ('$building_id', '$hall_name', '$description', '$capacity', '$imagePath', 'Available', '$date')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Hall added successfully!'); window.location.href = 'adding-hall.php';</script>";
        } else {
            echo "<script>alert('Oops, unable to submit request!');</script>";
        }
    } else {
        echo "<script>alert('Unable to upload image on server.');</script>";
    }
}

// Update hall
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $building_id = $_POST['building_id'];
    $hall_name = $_POST['hall_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $capacity = $_POST['capacity'];

    $sql = "UPDATE hall SET building_id = '$building_id', hall_name = '$hall_name', description = '$description', 
            status = '$status', capacity = '$capacity' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Hall updated successfully');location.href='adding-hall.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-hall.php'</script>";
    }
}

// Delete hall
if (isset($_POST['delete_submit'])) {
    $hall_id = $_POST['delete_id'];

    $sql = "DELETE FROM hall WHERE id = '$hall_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Hall deleted successfully');location.href='adding-hall.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='adding-hall.php'</script>";
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

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
                    <h1 class="text-white">Hall</h1>
                    <p>Enter our hall where every event becomes extraordinary</p>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="service_detail text-center">
                        <h2 style="font-weight: bold;">Add Hall</h2>
                    </div>
                    <div class="input-group mt-4 justify-content-end">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                            <i class="bi bi-plus-square-fill me-2"></i> Add Hall
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
                            <th scope="col">Hall Name</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT hall.*, building.name AS building_name FROM hall LEFT JOIN building ON hall.building_id = building.id";
                        $res = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($res) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>{$row['building_name']}</td>";
                                echo "<td>{$row['hall_name']}</td>";
                                echo "<td> <i class='fas fa-user'></i> {$row['capacity']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td><img src='hall/{$row['image']}' alt='Hall image' style='max-width: 80px; max-height: 80px;'></td>";
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
                        <div class="modal fade" id="update<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-5" id="updateLabel">Update Hall Details</h3>
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
                                                                echo "<option value='{$row1['id']}' " . ($row1['id'] == $row['building_id'] ? 'selected' : '') . ">{$row1['name']}</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hall_name" class="col-sm-3 col-form-label">Hall Name<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="hall_name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." maxlength="100" name="hall_name" value="<?php echo htmlspecialchars($row['hall_name']); ?>" placeholder="Hall Name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="capacity" class="col-sm-3 col-form-label">Capacity<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="capacity" maxlength="100" name="capacity" value="<?php echo htmlspecialchars($row['capacity']); ?>" placeholder="Capacity" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label">Description<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="description" maxlength="100" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" placeholder="Description" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select class="default-select form-control" id="status" name="status">
                                                        <option value="Available" <?php echo ($row['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                                        <option value="Owned" <?php echo ($row['status'] == 'Owned') ? 'selected' : ''; ?>>Owned</option>
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
                                <h3 class="modal-title fs-5" id="addLabel">Add Hall Details</h3>
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
                                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hall_name" class="col-sm-3 col-form-label">Hall Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="hall_name" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" title="The name should only contain letters and spaces." maxlength="100" name="hall_name" placeholder="Hall Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="capacity" class="col-sm-3 col-form-label">Capacity<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="capacity" maxlength="100" name="capacity" placeholder="Capacity" required>
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

    <?php require_once 'include/footer.php';?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#time_in').datetimepicker({
                format: 'LT',
                stepping: 30,
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
