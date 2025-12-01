<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>TERMS OF SERVICE</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="terms-content">
                        <h3>Terms of Service for Hospital Management System</h3>
                        <p><strong>Effective Date:</strong> <?php echo date('F j, Y'); ?></p>
                        <p><strong>Last Updated:</strong> <?php echo date('F j, Y'); ?></p>
                        
                        <h4>1. Acceptance of Terms</h4>
                        <p>By accessing and using our hospital management system, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                        
                        <h4>2. Description of Service</h4>
                        <p>Our hospital management system provides:</p>
                        <ul>
                            <li>Online appointment scheduling</li>
                            <li>Patient registration and management</li>
                            <li>Doctor and department information</li>
                            <li>Payment processing for medical services</li>
                            <li>Communication tools between patients and healthcare providers</li>
                        </ul>
                        
                        <h4>3. User Accounts and Registration</h4>
                        <p>To use certain features of our service, you must register for an account. You agree to:</p>
                        <ul>
                            <li>Provide accurate, current, and complete information</li>
                            <li>Maintain and update your information to keep it accurate</li>
                            <li>Maintain the confidentiality of your account credentials</li>
                            <li>Accept responsibility for all activities under your account</li>
                            <li>Notify us immediately of any unauthorized use</li>
                        </ul>
                        
                        <h4>4. Acceptable Use Policy</h4>
                        <p>You agree not to use the service to:</p>
                        <ul>
                            <li>Violate any applicable laws or regulations</li>
                            <li>Infringe on the rights of others</li>
                            <li>Upload malicious code or viruses</li>
                            <li>Attempt to gain unauthorized access to our systems</li>
                            <li>Interfere with the proper functioning of the service</li>
                            <li>Provide false or misleading medical information</li>
                        </ul>
                        
                        <h4>5. Medical Disclaimer</h4>
                        <p><strong>Important:</strong> This system is a tool to facilitate healthcare services but does not replace professional medical advice, diagnosis, or treatment. Always consult with qualified healthcare professionals for medical concerns.</p>
                        
                        <h4>6. Appointment and Scheduling</h4>
                        <ul>
                            <li>Appointments are subject to doctor availability</li>
                            <li>We reserve the right to reschedule appointments when necessary</li>
                            <li>Cancellations must be made at least 24 hours in advance</li>
                            <li>No-shows may result in charges or restrictions on future bookings</li>
                            <li>Emergency cases should contact emergency services directly</li>
                        </ul>
                        
                        <h4>7. Payment Terms</h4>
                        <ul>
                            <li>Payment is required at the time of service or as agreed</li>
                            <li>We accept various payment methods as displayed on our platform</li>
                            <li>All payments are processed securely through encrypted channels</li>
                            <li>Refunds are subject to our refund policy and applicable laws</li>
                            <li>Additional charges may apply for specialized services</li>
                        </ul>
                        
                        <h4>8. Privacy and Data Protection</h4>
                        <p>Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the service, to understand our practices.</p>
                        
                        <h4>9. Intellectual Property</h4>
                        <p>All content, features, and functionality of our service are owned by us or our licensors and are protected by copyright, trademark, and other intellectual property laws.</p>
                        
                        <h4>10. Service Availability</h4>
                        <ul>
                            <li>We strive to maintain service availability but cannot guarantee uninterrupted access</li>
                            <li>Scheduled maintenance will be announced in advance when possible</li>
                            <li>We are not liable for service interruptions beyond our control</li>
                        </ul>
                        
                        <h4>11. Limitation of Liability</h4>
                        <p>To the fullest extent permitted by law, we shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues.</p>
                        
                        <h4>12. Indemnification</h4>
                        <p>You agree to defend, indemnify, and hold us harmless from any claims, damages, obligations, losses, liabilities, costs, or debt arising from your use of the service.</p>
                        
                        <h4>13. Termination</h4>
                        <p>We may terminate or suspend your account and access to the service at any time, without prior notice or liability, for any reason, including if you breach these terms.</p>
                        
                        <h4>14. Governing Law</h4>
                        <p>These terms shall be governed and construed in accordance with the laws of [Your State/Country], without regard to its conflict of law provisions.</p>
                        
                        <h4>15. Changes to Terms</h4>
                        <p>We reserve the right to modify or replace these terms at any time. If a revision is material, we will try to provide at least 30 days notice prior to any new terms taking effect.</p>
                        
                        <h4>16. Contact Information</h4>
                        <p>Questions about these Terms of Service should be sent to:</p>
                        <ul>
                            <li><strong>Email:</strong> legal@hospitalmgmt.com</li>
                            <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                            <li><strong>Address:</strong> 123 Medical Center Drive, Healthcare City, HC 12345</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <strong>Emergency Notice:</strong> This platform is not intended for emergency medical situations. In case of a medical emergency, please call 911 or visit your nearest emergency room immediately.
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Agreement:</strong> By continuing to use our services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.terms-content h3 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.terms-content h4 {
    color: #34495e;
    margin-top: 25px;
    margin-bottom: 15px;
}

.terms-content p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.terms-content ul {
    margin-bottom: 15px;
}

.terms-content li {
    margin-bottom: 8px;
    line-height: 1.5;
}
</style>

<?php require_once 'includes/footer.php'; ?>
