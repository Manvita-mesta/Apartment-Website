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
    </div>

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('images/hero_bg_1.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
                    <h1 class="text-white"> Booked Flat</h1>
                    <p>Discover the epitome of style and convenience</p>
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

    <?php require_once 'include/footer.php'; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</body>

</html>
