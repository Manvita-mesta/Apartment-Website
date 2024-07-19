<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit; 
}


if (isset($_POST['pay'])) {
    $user_id = $_SESSION['id'];
    $month = $_POST['month'];
    $amount = $_POST['amount'];
    $pno = "PAY".rand(10000, 99999);
    $year = date("Y");

    $insertQuery = "INSERT INTO rent (user_id, month, year, amount,status, payment_number) VALUES ('$user_id', '$month', '$year', '$amount', 'Active', '$pno')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Payment successfully...!!');</script>";
    } else {
        echo "<script>alert('Unable to process your Payment!');</script>";
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
          <h1 class="text-white">Rent Payment</h1>
          <p>Paying rent with flair,living with grace</p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section border-bottom">
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-7 mb-5">
      <h2 style="font-weight: bold; text-align: center;">Rent Pay</h2>
      <form action="" method="POST" class="rent-payment-form">
        <div class="row form-group">
            <div class="col-md-12">
            <label class="font-weight-bold" for="month">Select Month</label>
            <select id="month" name="month" class="form-control" required>
                <option value="">Choose Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
            </div>
            <div class="col-md-12">
            <label class="font-weight-bold" for="amount">Enter Amount</label>
            <input type="number" id="amount" name="amount" class="form-control" placeholder="Rs." required>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
            <input type="submit" name="pay" value="PAY NOW" class="btn btn-primary">
            </div>
        </div>
      </form>

    </div>
  </div>
</div>

    
    <?php require_once 'include/footer.php';?>

  </body>
</html>