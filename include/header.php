<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-8 col-md-8 col-lg-4">
            <h1 class="mb-0"><a href="home.php" class="text-white h2 mb-0"><strong>Apartment  <span class="text-primary">Mainframe</span></strong></a></h1>
        </div>
        <div class="col-4 col-md-4 col-lg-8">
            <nav class="site-navigation text-right text-md-right" role="navigation">
                <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3">
                    <a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a>
                </div>
                <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']);
                    ?>
                    
                    <?php if (isset($_SESSION['type'])): ?>
                        <?php if ($_SESSION['type'] === 'Manager'): ?>
                            <li class="<?= $current_page == 'home.php' ? 'active' : '' ?>"><a href="home.php">Home</a></li>

                            <li class="<?= $current_page == 'about.php' ? 'active' : '' ?>"><a href="about.php">About</a></li>

                            <li class="<?= $current_page == 'adding-building.php' ? 'active' : '' ?>"><a href="adding-building.php">Building</a></li>
                            
                            <li class="<?= $current_page == 'adding-facility.php' ? 'active' : '' ?>"><a href="adding-facility.php">Facility</a></li>
                            
                            <li class="<?= $current_page == 'adding-visitor.php' ? 'active' : '' ?>"><a href="adding-visitor.php">Visitor</a></li>

                            <li class="<?= $current_page == 'adding-flat.php' ? 'active' : '' ?>"><a href="adding-flat.php">Flat</a></li>

                            <li class="<?= $current_page == 'adding-hall.php' ? 'active' : '' ?>"><a href="adding-hall.php">Hall</a></li>
                            
                            <li class="has-children <?= in_array($current_page, ['booking-flat.php', 'booking-hall.php', 'view-flat.php', 'view-hall.php']) ? 'active' : '' ?>">
                                <a href="#">Booking</a>
                                <ul class="dropdown arrow-top">
                                    <li class="<?= $current_page == 'booking-flat.php' ? 'active' : '' ?>"><a href="booking-flat.php">Booking Flat</a></li>
                                    <li class="<?= $current_page == 'view-flat.php' ? 'active' : '' ?>"><a href="view-flat.php">View Booked Flat</a></li>
                                    <li class="<?= $current_page == 'booking-hall.php' ? 'active' : '' ?>"><a href="booking-hall.php">Booking Hall</a></li>
                                    <li class="<?= $current_page == 'view-hall.php' ? 'active' : '' ?>"><a href="view-hall.php">View Booked Hall</a></li>
                                </ul>
                            </li>
                        <?php elseif ($_SESSION['type'] === 'User'): ?>
                            <li class="<?= $current_page == 'home_user.php' ? 'active' : '' ?>"><a href="home_user.php">Home</a></li>

                            <li class="<?= $current_page == 'about.php' ? 'active' : '' ?>"><a href="about.php">About</a></li>

                            <li class="has-children <?= $current_page == 'view-booked-flat.php' || $current_page == 'view-booked-hall.php' ? 'active' : '' ?>">
                                <a href="view-booked.php">Booked</a>
                                <ul class="dropdown arrow-top">
                                    <li class="<?= $current_page == 'view-booked-flat.php' ? 'active' : '' ?>"><a href="view-booked-flat.php">Booked Flat</a></li>
                                    <li class="<?= $current_page == 'view-booked-hall.php' ? 'active' : '' ?>"><a href="view-booked-hall.php">Booked Hall</a></li>
                                </ul>
                            </li>
                            <li class="<?= $current_page == 'adding-rent.php' ? 'active' : '' ?>"><a href="adding-rent.php">Rents</a></li>
                            <li class="<?= $current_page == 'adding-complaint.php' ? 'active' : '' ?>"><a href="adding-complaint.php">Complaint</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="<?= $current_page == 'view-events.php' ? 'active' : '' ?>"><a href="view-events.php">Events</a></li>
                    <li class="has-children <?= $current_page == 'view-profile.php' || $current_page == 'change_password.php' || $current_page == 'include/logout.php' ? 'active' : '' ?>">
                        <a href="#">Settings</a>
                        <ul class="dropdown arrow-top">
                            <li class="<?= $current_page == 'change_password.php' ? 'active' : '' ?>"><a href="change_password.php">Change Password</a></li>
                            <li><a href="include/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
