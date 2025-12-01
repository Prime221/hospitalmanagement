<?php
require_once 'config.php';

$page_title = "Our Doctors";
include 'includes/header.php';

try {
    // Get all doctors with their departments
    $stmt = $pdo->prepare("
        SELECT d.*, dept.name as department_name 
        FROM doctors d 
        LEFT JOIN departments dept ON d.department_id = dept.id 
        ORDER BY d.name
    ");
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $doctors = [];
}
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px;">
    <h2>DOCTORS</h2>
</div>
<!-- End title -->

<!--=== Team v1 ===-->
<div class="container content-md team-v1">
    <?php if (!empty($doctors)): ?>
    <ul class="list-unstyled row">
        <?php 
        $count = 0;
        foreach ($doctors as $doctor): 
            if ($count > 0 && $count % 4 == 0): 
        ?>
    </ul>
    
    <!-- Next Row -->
    <div class="container content-md team-v1" style="margin-left: -13px;">
        <ul class="list-unstyled row">
        <?php endif; ?>
        
        <li class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
            <div class="team-img">
                <?php 
                // Use a default image or try to find specific image
                $imageFile = strtolower(str_replace([' ', '.', 'Dr.'], ['_', '', ''], $doctor['name'])) . '.jpg';
                $imagePath = 'assets/img/team/' . $imageFile;
                
                // Check if specific image exists, otherwise use default based on ID
                if (!file_exists($imagePath)) {
                    $defaultImages = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg'];
                    $imagePath = 'assets/img/team/' . $defaultImages[$doctor['id'] % count($defaultImages)];
                }
                ?>
                <img class="img-responsive" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>">
            </div>
            <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
            <h4>/ <?php echo htmlspecialchars($doctor['qualification']); ?></h4>
            <p><?php echo htmlspecialchars($doctor['specialization']); ?></p>
            <?php if (!empty($doctor['department_name'])): ?>
            <small class="text-muted"><?php echo htmlspecialchars($doctor['department_name']); ?></small>
            <?php endif; ?>
            
            <div class="margin-top-20">
                <?php if (!empty($doctor['phone'])): ?>
                <p><i class="fa fa-phone"></i> <?php echo htmlspecialchars($doctor['phone']); ?></p>
                <?php endif; ?>
                <?php if (!empty($doctor['email'])): ?>
                <p><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($doctor['email']); ?></p>
                <?php endif; ?>
            </div>
            
            <?php if (isLoggedIn() && !isAdmin()): ?>
            <div class="margin-top-15">
                <a href="appointment.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-xs btn-primary">
                    <i class="fa fa-calendar"></i> Book Appointment
                </a>
            </div>
            <?php endif; ?>
        </li>
        
        <?php 
        $count++;
        endforeach; 
        ?>
    </ul>
    
    <?php if ($count > 4): ?>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="text-center">
        <h3>No Doctors Available</h3>
        <p>Please check back later for our medical staff information.</p>
    </div>
    <?php endif; ?>
</div>
<!--=== End Team v1 ===-->

<!-- Specialties Section -->
<div class="bg-color-light">
    <div class="container content-sm">
        <div class="headline-center" style="margin-bottom: 60px;">
            <h2>OUR SPECIALTIES</h2>
            <div class="line"></div>
            <p>We provide comprehensive medical care across multiple specialties</p>
        </div>
        
        <div class="row">
            <?php
            try {
                $stmt = $pdo->prepare("SELECT DISTINCT specialization FROM doctors WHERE specialization IS NOT NULL ORDER BY specialization");
                $stmt->execute();
                $specialties = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($specialties as $index => $specialty):
            ?>
            <div class="col-md-4 col-sm-6" style="margin-bottom: 30px;">
                <div class="service-block-v6">
                    <i class="icon-medical-<?php echo str_pad(($index % 10) + 1, 3, '0', STR_PAD_LEFT); ?> icon-color-u rounded-x"></i>
                    <div class="service-desc">
                        <h4><?php echo htmlspecialchars($specialty['specialization']); ?></h4>
                        <p>Expert medical care and treatment in <?php echo htmlspecialchars($specialty['specialization']); ?> with experienced specialists.</p>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            } catch(PDOException $e) {
                // Handle error silently
            }
            ?>
        </div>
    </div>
</div>

<!-- Why Choose Our Doctors -->
<div class="container content">
    <div class="headline-center" style="margin-bottom: 60px;">
        <h2>WHY CHOOSE OUR DOCTORS</h2>
        <div class="line"></div>
        <p>Our medical professionals are committed to providing the highest quality care</p>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-graduation-cap" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Highly Qualified</h4>
                    <p>All our doctors are board-certified with extensive medical education and training.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-stethoscope" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Experienced</h4>
                    <p>Years of clinical experience in treating various medical conditions and diseases.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-heart-o" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Compassionate Care</h4>
                    <p>Patient-centered approach with empathy and understanding for every individual.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6" style="margin-bottom: 30px;">
            <div class="service-block-v6" style="text-align: center;">
                <i class="icon-custom rounded-x icon-color-u icon-line fa-clock-o" style="font-size: 40px;"></i>
                <div class="service-desc">
                    <h4>Available 24/7</h4>
                    <p>Round-the-clock medical care for emergency situations and critical conditions.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
