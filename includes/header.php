<?php
if (!defined('CONFIG_INCLUDED')) {
    require_once 'config.php';
    define('CONFIG_INCLUDED', true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Web Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin">
    
    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- CSS Header and Footer -->
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/plugins/line-icons-pro/styles.css">
    <link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
    
    <?php if (isset($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- CSS Customization -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
    <div class="wrapper">
        <!--=== Header v1 ===-->
        <div class="header-v1">
            <!-- Topbar -->
            <div class="topbar-v1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline top-v1-contacts">
                                <li><i class="fa fa-envelope"></i> Email: unityhospital@gmail.com</li>
                                <li><i class="fa fa-phone"></i> Contact no : 88666 00555</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-inline top-v1-contacts pull-right">
                                <?php if (isLoggedIn()): ?>
                                    <li><i class="fa fa-user"></i> Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></li>
                                    <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                                <?php else: ?>
                                    <li><a href="login.php"><i class="fa fa-sign-in"></i> Login</a></li>
                                    <li><a href="registration.php"><i class="fa fa-user-plus"></i> Register</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar -->
            
            <!-- Navbar -->
            <div class="navbar mega-menu" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="res-container">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                        <div class="navbar-brand">
                            <a href="index.php">
                                <img src="assets/img/logo/unity_white.jpg" alt="Logo">
                            </a>
                        </div>
                    </div><!--/end responsive container-->
                    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-responsive-collapse">
                        <div class="res-container">
                            <ul class="nav navbar-nav">
                                <!-- Home -->
                                <li class="mega-menu-fullwidth">
                                    <a href="index.php">HOME</a>
                                </li>
                                
                                <!-- About Us -->
                                <li class="mega-menu-fullwidth">
                                    <a href="about.php">ABOUT US</a>
                                </li>
                                
                                <!-- Doctors -->
                                <li class="mega-menu-fullwidth">
                                    <a href="doctors.php">DOCTORS</a>
                                </li>
                                
                                <!-- Gallery -->
                                <li class="mega-menu-fullwidth">
                                    <a href="gallery.php">GALLERY</a>
                                </li>
                                
                                <!-- Blog -->
                                <li class="mega-menu-fullwidth">
                                    <a href="blog.php">BLOGS</a>
                                </li>
                                
                                <!-- Contact Us -->
                                <li class="mega-menu-fullwidth">
                                    <a href="contact.php">CONTACT US</a>
                                </li>
                                
                                <?php if (isLoggedIn() && !isAdmin()): ?>
                                    <!-- Appointment -->
                                    <li class="mega-menu-fullwidth">
                                        <a href="appointment.php">BOOK APPOINTMENT</a>
                                    </li>
                                    
                                    <!-- Payment -->
                                    <li class="mega-menu-fullwidth">
                                        <a href="payment.php">PAYMENT</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if (isAdmin()): ?>
                                    <!-- Admin Panel -->
                                    <li class="mega-menu-fullwidth">
                                        <a href="admin.php">ADMIN PANEL</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navbar -->
