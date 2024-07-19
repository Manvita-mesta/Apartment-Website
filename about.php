<?php
session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit;
}
?><!DOCTYPE html>
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
          <h1 class="text-white">About Us</h1>
          <p>At Apartment Mainframe, we are dedicated to revolutionizing apartment management through cutting-edge technology.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <img src="images/img_1.jpg" alt="Image" class="img-fluid">
        </div>
        <div class="col-lg-6">
          <div class="site-section-heading text-center mb-5 w-border col-md-6 mx-auto">
          <h2 class="mb-5">Our Office</h2>
          <p>The apartment office can be contacted via phone or email for any issues.The office is open frpm 10am to 6pm.Rent payments can be made through the online portal. The admin updates about the events happening in the apartment.</p>
        </div>
        </div>
      </div>
    </div>
  </div>
    
    <?php require_once 'include/footer.php';?>
  </body>
</html>