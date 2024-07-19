<?php

session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
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
          <h1 class="text-white">View Booked Hall</h1>
          <p>Enter our hall where every event becomes extraordinary</p>
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
                <h2 style="font-weight: bold;">View Booked Hall</h2>

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
                        <th scope="col">User Name</th>
                        <th scope="col">Building Name</th>
                        <th scope="col">Hall Name</th>
                        <th scope="col">From Date</th>
                        <th scope="col">To Date</th>
                        <th scope="col">Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                  $sql = "SELECT b.*, u.name AS user_name, bd.name AS building_name, h.hall_name 
                          FROM booking b
                          INNER JOIN user u ON b.user_id = u.id
                          INNER JOIN building bd ON b.building_id = bd.id
                          INNER JOIN hall h ON b.hall_id = h.id
                          WHERE b.booking_type = 'Hall'";
            
            
                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['user_name']}</td>";
                            echo "<td>{$row['building_name']}</td>";
                            echo "<td>{$row['hall_name']}</td>";
                            echo "<td>" . date('d-M-Y', strtotime($row['from_date'])) . "</td>";
                            echo "<td>" . date('d-M-Y', strtotime($row['to_date'])) . "</td>";
                            echo "<td>" . date('d-M-Y', strtotime($row['booking_date'])) . "</td>";
                            echo "</tr>";
                            $i++;
                    }
                }
                ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

    
    <?php require_once 'include/footer.php';?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  </body>
</html>