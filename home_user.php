<?php
session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
    exit;
}

$user_id = $_SESSION['id'];

$query1 = "SELECT flat.*, user.name AS user_name, booking.booking_date, booking.to_date, booking.from_date 
            FROM booking 
            JOIN user ON user.id = booking.user_id 
            JOIN flat ON flat.id = booking.flat_id 
            JOIN building ON building.id = flat.building_id 
            WHERE flat.status = 'Owned' 
            AND booking.booking_type = 'Flat' 
            AND booking.user_id = $user_id 
            ORDER BY booking.id DESC";


$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT hall.*, user.name AS user_name, booking.booking_date, booking.to_date, booking.from_date 
            FROM booking 
            JOIN user ON user.id = booking.user_id 
            JOIN hall ON hall.id = booking.hall_id 
            JOIN building ON building.id = hall.building_id 
            WHERE hall.status = 'Owned' 
            AND booking.booking_type = 'hall' 
            AND booking.user_id = $user_id 
            ORDER BY booking.id DESC";


$result2 = mysqli_query($conn, $query2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apartment Mainframe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/mediaelementplayer.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/fl-bigmug-line.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .site-navbar .container-fluid {
            width: 85%;
        }
    </style>
</head>
<body>
<div class="site-wrap">
    <div class="site-navbar mt-4">
        <?php require_once 'include/header.php'; ?>

        <div class="site-mobile-menu">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div> <!-- .site-mobile-menu -->
    </div>

    <div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_1.jpg');" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                    <h1 class="mb-4">Excellent Space For Your Next Home</h1>
                
                </div>
            </div>
        </div>
    </div>
    <div class="site-section bg-light">
        <div class="container">
            <div class="row">
                <div class="site-section-heading text-center mb-5 w-100" data-aos="fade-up">
                    <h2 class="mb-5">Booked Flat</h2>
                    <p>Discover the epitome of style and convenience.</p>
                </div>
            </div>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result1)) : ?>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                        <a href="view-booked-flat.php">
                            <img src="flat/<?php echo $row['image']; ?>" alt="Image" class="img-fluid" style="width: 100%; height: 200px;">
                        </a>
                        <div class="p-4 bg-white">
                            <span class="d-block text-secondary small text-uppercase">
                                <?php 
                                $from_date = date('j M Y', strtotime($row['from_date']));
                                $to_date = date('j M Y', strtotime($row['to_date']));
                                echo "Booked from $from_date to $to_date"; 
                                ?>
                            </span>
                            <h2 class="h5 text-black mb-3"><a href="view-booked-flat.php"><?php echo $row['flat_number']; ?></a></h2>
                            <p><?php echo $row['description']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container">
            <div class="row">
                <div class="site-section-heading text-center mb-5 w-100" data-aos="fade-up">
                    <h2 class="mb-5">Booked Hall</h2>
                    <p>Enter our hall where every event becomes extraordinary.</p>
                </div>
            </div>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                        <a href="view-booked-hall.php">
                            <img src="hall/<?php echo $row['image']; ?>" alt="Image" class="img-fluid" style="width: 100%; height: 200px;">
                        </a>
                        <div class="p-4 bg-white">
                            <span class="d-block text-secondary small text-uppercase">
                                <?php 
                                $from_date = date('j M Y', strtotime($row['from_date']));
                                $to_date = date('j M Y', strtotime($row['to_date']));
                                echo "Booked from $from_date to $to_date"; 
                                ?>
                            </span>
                            <h2 class="h5 text-black mb-3"><a href="view-booked-hall.php"><?php echo $row['hall_name']; ?></a></h2>
                            <p><?php echo $row['description']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php
    $query = "SELECT * FROM events";
    $result = mysqli_query($conn, $query);
    ?>
    <div class="site-section bg-light">
        <div class="container">
            <div class="site-section-heading text-center mb-5 w-border col-md-6 mx-auto" data-aos="fade-up">
                <h2 class="mb-5">Events</h2>
                <p>Experience unforgettable events in our versatile venue</p>
            </div>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100" style="width: 300px; height: 400px;">
                        <a href="view-events.php"><img src="<?php echo $row['image']; ?>" alt="Image" class="img-fluid" style="width: 100%; height: 200px;"></a>
                        <div class="p-4 bg-white" style="height: 200px;">
                            <span class="d-block text-secondary small text-uppercase"><?php echo date('j F Y', strtotime($row['createddate'])); ?></span>
                            <h2 class="h5 text-black mb-3"><a href="view-events.php"><?php echo $row['title']; ?></a></h2>
                            <p><?php echo $row['description']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    
    <?php require_once 'include/footer.php'; ?>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/mediaelement-and-player.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
