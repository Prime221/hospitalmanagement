<?php
require_once 'config.php';

$page_title = "About Us";
include 'includes/header.php';

try {
    // Get departments for the about section
    $stmt = $pdo->prepare("SELECT * FROM departments ORDER BY name");
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $departments = [];
}
?>

<!-- About Heading -->
<div class="container content-sm" style="margin-top: -25px;">
    <div class="headline-center" style="margin-bottom: 60px;">
        <h2>ABOUT<span style="color: #72c02c;"> UNITY </span></h2>
    </div>
</div>

<!-- About Section 1 -->
<div class="container content" style="margin-top: -90px">
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-6" style="margin-bottom: 40px;">
            <div class="headline">
                <h2>Our Mission</h2>
            </div>
            <p>Unity Hospital is committed to providing exceptional healthcare services with compassion, integrity, and excellence. We strive to improve the health and well-being of our community through innovative medical care, advanced technology, and a patient-centered approach.</p>
            
            <div class="headline" style="margin-top: 30px;">
                <h2>Our Vision</h2>
            </div>
            <p>To be the leading healthcare provider in the region, recognized for our clinical excellence, innovative treatments, and commitment to improving lives. We envision a future where quality healthcare is accessible to all.</p>
        </div>
        
        <div class="col-md-6" style="margin-bottom: 20px; text-align: right;">
            <img src="assets/img/bg/1.jpg" alt="About Unity Hospital" class="img-responsive" style="border-radius: 8px;">
        </div>
    </div>
</div>
<!-- End About Section 1 -->

<!--=== About Section 2 ===-->
<div class="container content-sm aboutSection">
    <div class="row service-block-v6 section1">
        <div class="col-md-4" style="margin-bottom: 50px;">
            <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-054"></i>
            <div class="service-desc">
                <h2 class="title-v3-md margin-bottom-10">Expert Medical Care</h2>
                <p>Our team of highly qualified doctors and medical professionals provide expert care across all medical specialties with years of experience and dedication.</p>
            </div>
        </div>
        <div class="col-md-4" style="margin-bottom: 50px;">
            <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-038"></i>
            <div class="service-desc">
                <h2 class="title-v3-md margin-bottom-10">Advanced Technology</h2>
                <p>We utilize state-of-the-art medical equipment and cutting-edge technology to ensure accurate diagnosis and effective treatment for all our patients.</p>
            </div>
        </div>
        <div class="col-md-4">
            <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-004"></i>
            <div class="service-desc">
                <h2 class="title-v3-md margin-bottom-10">24/7 Emergency Care</h2>
                <p>Our emergency department is fully equipped and staffed 24/7 to handle all types of medical emergencies with prompt and professional care.</p>
            </div>
        </div>
    </div><!--/end row-->
</div>
<!--=== End About Section 2===-->

<!--=== About Section 3 ===-->
<div class="bg-color-light">
    <div class="container content-sm">
        <div class="headline-center" style="margin-bottom: 60px;">
            <h2>OUR DEPARTMENTS</h2>
            <div class="line"></div>
            <p>UNITY Hospital is spread over a massive 6 acre campus <br /> providing<strong> 300+ </strong> beds and comprehensive medical services</p>
        </div>
        
        <?php if (!empty($departments)): ?>
        <!-- Service Block v8 -->
        <div class="row" style="margin-bottom: 30px;">
            <?php 
            $count = 0;
            foreach ($departments as $department): 
                if ($count % 2 == 0 && $count > 0): 
            ?>
        </div>
        <div class="row" style="margin-bottom: 30px;">
            <?php endif; ?>
            
            <div class="col-sm-6" style="margin-bottom: 50px;">
                <div class="service-block-v8">
                    <i class="icon-medical-<?php echo str_pad(($count % 10) + 1, 3, '0', STR_PAD_LEFT); ?> icon-color-u rounded-x"></i>
                    <div class="service-block-desc">
                        <h3><?php echo htmlspecialchars($department['name']); ?></h3>
                        <p><?php echo htmlspecialchars($department['description']); ?></p>
                        <?php if (!empty($department['head_doctor'])): ?>
                        <small><strong>Head:</strong> <?php echo htmlspecialchars($department['head_doctor']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php 
            $count++;
            endforeach; 
            ?>
        </div>
        <!-- End Service Block v8 -->
        <?php endif; ?>
    </div>
</div>
<!--=== End About Section 3===-->

<!-- Our Values -->
<div class="container content">
    <div class="headline-center" style="margin-bottom: 60px;">
        <h2>OUR VALUES</h2>
        <div class="line"></div>
        <p>The core values that guide everything we do</p>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-heart-o" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Compassion</h4>
                    <p>We treat every patient with empathy, kindness, and understanding.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-shield" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Integrity</h4>
                    <p>We maintain the highest standards of honesty and ethical conduct.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-star-o" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Excellence</h4>
                    <p>We strive for excellence in all aspects of patient care and service.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-users" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Teamwork</h4>
                    <p>We work together as a unified team to achieve the best outcomes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
