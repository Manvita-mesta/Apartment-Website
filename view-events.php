<?php

session_start();

require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}
?>

<?php require_once 'include/header-link.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
</head>
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
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image:url('images/hero_bg_1.jpg');">
        <data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center" data-aos="fade-up" data-aos-delay="400">
                        <h1 class="text-white">Events</h1>
                        <p>Experience unforgettable events in our versatile venue</p>
                    </div>
                </div>
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
    
    <?php require_once 'include/footer.php';?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</body>
</html>
