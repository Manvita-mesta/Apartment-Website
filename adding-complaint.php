<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}


if (isset($_POST['submit_complaint'])) {
    $user_id = $_SESSION['id'];

    $complaint_title = addslashes(trim($_POST['complaint_title']));
    $complaint_description = addslashes(trim($_POST['complaint_description']));
    $status = 'Active';
    
    $insertQuery = "INSERT INTO complaints (user_id, title, description, status, created_date) 
                    VALUES ('$user_id', '$complaint_title', '$complaint_description', '$status', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Complaint filed successfully');</script>";
    } else {
        echo "<script>alert('Unable to process your complaint!');</script>";
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
    </div>

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');" data-aos="fade" data-stellar-background-ratio="0.5">
    
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
          <h1 class="text-white">Complaint</h1>
          <p>Any inconvenience express it here</p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section border-bottom">
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-7 mb-5">
        <h2 style="font-weight: bold; text-align: center;">File a Complaint</h2>
        <form action="" method="POST" class="complaint-form">
            <div class="row form-group">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="complaint_title">Title</label>
                    <input type="text" id="complaint_title" name="complaint_title" pattern="[A-Za-z]+" class="form-control" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="complaint_description">Description</label>
                    <textarea id="complaint_description" name="complaint_description" class="form-control" required></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <input type="submit" value="Submit Complaint" name="submit_complaint" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</div>

</div>


    
    <?php require_once 'include/footer.php';?>

  </body>
</html>