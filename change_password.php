<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}

if (isset($_POST['change_password'])) {

    $id = $_SESSION['id'];
  
    $oldpassword = addslashes(trim($_POST['oldpassword']));
    $newpassword = addslashes(trim($_POST['newpassword']));
    $confirmpassword = addslashes(trim($_POST['confirmpassword']));
  
    $qry = "SELECT password from user WHERE id = '$id'";
    $resu = mysqli_query($conn, $qry);
    if ($resu) {
      $row1 = mysqli_fetch_assoc($resu);
      $stored_password = $row1['password'];
  
      if ($oldpassword == $stored_password) {
  
        if ($confirmpassword == $newpassword) {
  
          $passqry = "UPDATE user SET password = '$newpassword' WHERE id = '$id'";
      
          if ($conn->query($passqry) === TRUE) {
              echo "<script>alert('Password updated successfully!');location.href='change_password.php'</script>";
          } else {
              echo "<script>alert('Error updating password');location.href='change_password.php'</script>";
          }
        } else {
      
            echo "<script>alert('Password confirmation doesnot match!');location.href='change_password.php'</script>";
        }
      } else {
  
        echo "<script>alert('Old password doesnot match!');location.href='change_password.php'</script>";
  
      }
  
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
    </div>
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');"
    data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
          <h1 class="text-white">Change Password</h1>
          <p>Stay one step ahead, Change your password.</p>
        </div>
      </div>
    </div>
  </div>

    <div class="site-section border-bottom">
    <div class="container">
        <h2 style="font-weight: bold; text-align: center;">Change Password</h2><br>
        <div class="row justify-content-center">
        <div class="col-md-12 col-lg-7 mb-5">
            <form action="" method="POST" class="change-password-form">
            <div class="row form-group">
                <div class="col-md-12">
                <label class="font-weight-bold" for="oldpassword">Current Password</label>
                <input type="password" id="oldpassword" name="oldpassword" class="form-control" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                <label class="font-weight-bold" for="newpassword">New Password</label>
                <input type="password" id="newpassword" name="newpassword" class="form-control" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                <label class="font-weight-bold" for="confirmpassword">Confirm New Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                <input type="submit" value="Change Password" name="change_password" class="btn btn-primary py-3 px-4">
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