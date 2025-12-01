<?php
require_once 'config.php';

$page_title = "Home";
$additional_css = [];
$additional_js = [];

include 'includes/header.php';

try {
    // Get recent blog posts
    $stmt = $pdo->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 3");
    $stmt->execute();
    $recent_blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get doctors count
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM doctors");
    $stmt->execute();
    $doctors_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get departments count
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM departments");
    $stmt->execute();
    $departments_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
} catch(PDOException $e) {
    $recent_blogs = [];
    $doctors_count = 0;
    $departments_count = 0;
}
?>

<!-- Slider -->
<div id="slide">
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="assets/img/slider/1.jpg" alt="Slider1" style="width:100%">
        </div>
        <div class="mySlides fade">
            <img src="assets/img/slider/2.jpg" alt="Slider2" style="width:100%">
        </div>
        <div class="mySlides fade">
            <img src="assets/img/slider/3.jpg" alt="Slider3" style="width:100%">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</div>

<!--=== Welcome to Unity===-->
<div class="container content-md welcomeSection">
    <div class="row section1">
        <div class="col-md-6" style="margin-bottom: 40px;">
            <div class="headline">
                <h2>Welcome to <span style="color: #72c02c;">UNITY</span> Hospital</h2>
            </div>
            <p>Unity Hospital is a leading healthcare institution providing comprehensive medical services with state-of-the-art facilities and experienced medical professionals. We are committed to delivering exceptional patient care and maintaining the highest standards of medical excellence.</p>
            <p>Our hospital features modern equipment, comfortable patient rooms, and a dedicated team of healthcare professionals who work tirelessly to ensure the best possible outcomes for our patients.</p>
            <ul class="list-unstyled">
                <li><i class="fa fa-check color-green"></i> 24/7 Emergency Services</li>
                <li><i class="fa fa-check color-green"></i> Experienced Medical Staff</li>
                <li><i class="fa fa-check color-green"></i> Modern Medical Equipment</li>
                <li><i class="fa fa-check color-green"></i> Comprehensive Healthcare</li>
            </ul>
        </div>
        
        <div class="col-md-6" style="margin-bottom: 20px; text-align: center;">
            <img src="assets/img/bg/1.jpg" alt="Unity Hospital" class="img-responsive" style="border-radius: 8px;">
        </div>
    </div>
</div>
<!--=== End Welcome ===-->

<!-- Statistics -->
<div class="bg-color-light">
    <div class="container content-sm">
        <div class="headline-center" style="margin-bottom: 60px;">
            <h2>OUR ACHIEVEMENTS</h2>
            <div class="line"></div>
            <p>UNITY Hospital is spread over a massive 6 acre campus providing <strong>300+</strong> beds</p>
        </div>
        
        <div class="row" style="margin-bottom: 40px;">
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                <div class="service-block-v6" style="text-align: center;">
                    <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-054" style="font-size: 40px;"></i>
                    <div class="service-desc">
                        <h3 style="color: #72c02c;"><?php echo $doctors_count; ?>+</h3>
                        <h4>Expert Doctors</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                <div class="service-block-v6" style="text-align: center;">
                    <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-038" style="font-size: 40px;"></i>
                    <div class="service-desc">
                        <h3 style="color: #72c02c;"><?php echo $departments_count; ?>+</h3>
                        <h4>Departments</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                <div class="service-block-v6" style="text-align: center;">
                    <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-004" style="font-size: 40px;"></i>
                    <div class="service-desc">
                        <h3 style="color: #72c02c;">300+</h3>
                        <h4>Hospital Beds</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                <div class="service-block-v6" style="text-align: center;">
                    <i class="icon-custom rounded-x icon-color-u icon-line icon-medical-002" style="font-size: 40px;"></i>
                    <div class="service-desc">
                        <h3 style="color: #72c02c;">24/7</h3>
                        <h4>Emergency Care</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Blog part -->
<?php if (!empty($recent_blogs)): ?>
<div class="container">
    <div class="headline-center" style="margin-bottom: 40px;">
        <h2>LATEST HEALTH TIPS</h2>
        <div class="line"></div>
        <p>Stay updated with our latest health tips and medical insights</p>
    </div>
    
    <div class="row" style="margin-bottom: 50px;">
        <?php foreach ($recent_blogs as $blog): ?>
        <div class="col-md-4" style="margin-bottom: 30px;">
            <div class="blog-thumb" style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
                <div class="blog-thumb-hover">
                    <img class="img-responsive" src="assets/img/blogs/<?php echo ($blog['id'] % 4) + 1; ?>.jpg" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                </div>
                <div class="blog-thumb-desc" style="padding: 20px;">
                    <h3><a href="blog.php#blog-<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h3>
                    <p><?php echo htmlspecialchars(substr($blog['content'], 0, 100)); ?>...</p>
                    <small class="blog-thumb-meta">
                        <span><i class="fa fa-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
                        <span><i class="fa fa-clock-o"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                    </small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php
$inline_js = "
var slideIndex = 0;
showSlides();
var slides, dots;

function showSlides() {
    var i;
    slides = document.getElementsByClassName('mySlides');
    dots = document.getElementsByClassName('dot');
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(' active', '');
    }
    if (slides.length > 0) {
        slides[slideIndex - 1].style.display = 'block';
        dots[slideIndex - 1].className += ' active';
    }
    setTimeout(showSlides, 8000);
}

function plusSlides(position) {
    slideIndex += position;
    if (slideIndex > slides.length) { slideIndex = 1 }
    else if (slideIndex < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    if (slides.length > 0) {
        slides[slideIndex - 1].style.display = 'block';
    }
}

function currentSlide(index) {
    slideIndex = index;
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(' active', '');
    }
    if (slides.length > 0) {
        slides[slideIndex - 1].style.display = 'block';
        dots[slideIndex - 1].className += ' active';
    }
}
";

include 'includes/footer.php';
?>
