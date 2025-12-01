<?php
require_once 'config.php';
require_once 'includes/header.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    if (empty($name)) {
        $error = 'Name is required.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Valid email is required.';
    } elseif (empty($subject)) {
        $error = 'Subject is required.';
    } elseif (empty($message)) {
        $error = 'Message is required.';
    } else {
        // Insert contact message into database
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $subject, $message]);
            $success = 'Thank you for your message! We will get back to you soon.';
            
            // Clear form data
            $name = $email = $subject = $message = '';
        } catch (PDOException $e) {
            $error = 'Error sending message. Please try again.';
        }
    }
}
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>CONTACT US</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Get in Touch</h3>
                </div>
                <div class="panel-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contact Information</h3>
                </div>
                <div class="panel-body">
                    <div class="contact-info">
                        <h4><i class="fa fa-map-marker"></i> Address</h4>
                        <p>123 Medical Center Drive<br>
                        Healthcare City, HC 12345<br>
                        United States</p>
                        
                        <h4><i class="fa fa-phone"></i> Phone</h4>
                        <p>+1 (555) 123-4567<br>
                        Emergency: +1 (555) 911-0000</p>
                        
                        <h4><i class="fa fa-envelope"></i> Email</h4>
                        <p>info@hospitalmgmt.com<br>
                        emergency@hospitalmgmt.com</p>
                        
                        <h4><i class="fa fa-clock-o"></i> Working Hours</h4>
                        <p>Monday - Friday: 8:00 AM - 8:00 PM<br>
                        Saturday: 9:00 AM - 6:00 PM<br>
                        Sunday: 10:00 AM - 4:00 PM<br>
                        Emergency: 24/7</p>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Emergency Services</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger">
                        <strong>Emergency?</strong> Call <strong>911</strong> or visit our Emergency Department immediately.
                    </div>
                    <p>Our emergency department is open 24/7 and equipped to handle all types of medical emergencies.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
