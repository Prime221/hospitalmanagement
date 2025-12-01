        <!--=== Footer ===-->
        <div class="footer-v1">
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <!-- About -->
                        <div class="col-md-3" style="margin-bottom: 40px;">
                            <div class="headline"><h2>About</h2></div>
                            <p>Unity Hospital - Your trusted healthcare partner providing comprehensive medical services with state-of-the-art facilities and experienced medical professionals.</p>
                        </div>
                        <!-- End About -->
                        
                        <!-- Latest -->
                        <div class="col-md-3" style="margin-bottom: 40px;">
                            <div class="headline"><h2>Quick Links</h2></div>
                            <ul class="list-unstyled link-list">
                                <li><a href="about.php">About Us</a></li>
                                <li><a href="doctors.php">Our Doctors</a></li>
                                <li><a href="appointment.php">Book Appointment</a></li>
                                <li><a href="contact.php">Contact Us</a></li>
                            </ul>
                        </div><!--/col-md-3-->
                        <!-- End Latest -->
                        
                        <!-- Link List -->
                        <div class="col-md-3" style="margin-bottom: 40px;">
                            <div class="headline"><h2>Services</h2></div>
                            <ul class="list-unstyled link-list">
                                <li><a href="#">Emergency Care</a></li>
                                <li><a href="#">Health Checkup</a></li>
                                <li><a href="#">Surgery</a></li>
                                <li><a href="#">Laboratory</a></li>
                            </ul>
                        </div><!--/col-md-3-->
                        <!-- End Link List -->
                        
                        <!-- Address -->
                        <div class="col-md-3" style="margin-bottom: 40px;">
                            <div class="headline"><h2>Contact Info</h2></div>
                            <address>
                                <strong>Unity Hospital</strong><br>
                                Embankment Drive Road<br>
                                Dhaka 1230<br>
                                <abbr title="Phone">P:</abbr> +8801765489641<br>
                                <abbr title="Email">E:</abbr> unityhospital@gmail.com
                            </address>
                        </div><!--/col-md-3-->
                        <!-- End Address -->
                    </div>
                </div>
            </div><!--/footer-->
            
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p>&copy; <?php echo date('Y'); ?> Unity Hospital. All Rights Reserved.</p>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="col-md-6">
                            <ul class="footer-socials list-inline">
                                <li><a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <!-- End Social Links -->
                    </div>
                </div>
            </div><!--/copyright-->
        </div>
        <!--=== End Footer ===-->
    </div><!--/wrapper-->
    
    <!-- Java scripts -->
    <script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    
    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script type="text/javascript" src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($inline_js)): ?>
        <script type="text/javascript">
            <?php echo $inline_js; ?>
        </script>
    <?php endif; ?>
</body>
</html>
