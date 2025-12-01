<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>PRIVACY POLICY</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="privacy-content">
                        <h3>Privacy Policy for Hospital Management System</h3>
                        <p><strong>Effective Date:</strong> <?php echo date('F j, Y'); ?></p>
                        
                        <h4>1. Information We Collect</h4>
                        <p>We collect information you provide directly to us, such as when you:</p>
                        <ul>
                            <li>Create an account or register for our services</li>
                            <li>Schedule appointments</li>
                            <li>Contact us with questions or comments</li>
                            <li>Use our online services</li>
                        </ul>
                        
                        <h4>2. Types of Information</h4>
                        <p>The types of information we may collect include:</p>
                        <ul>
                            <li><strong>Personal Information:</strong> Name, email address, phone number, date of birth</li>
                            <li><strong>Medical Information:</strong> Medical history, appointment details, treatment records</li>
                            <li><strong>Payment Information:</strong> Billing address, payment method details</li>
                            <li><strong>Technical Information:</strong> IP address, browser type, device information</li>
                        </ul>
                        
                        <h4>3. How We Use Your Information</h4>
                        <p>We use the information we collect to:</p>
                        <ul>
                            <li>Provide, maintain, and improve our healthcare services</li>
                            <li>Schedule and manage appointments</li>
                            <li>Process payments and billing</li>
                            <li>Communicate with you about your healthcare</li>
                            <li>Send you important updates and notifications</li>
                            <li>Comply with legal and regulatory requirements</li>
                        </ul>
                        
                        <h4>4. Information Sharing and Disclosure</h4>
                        <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except:</p>
                        <ul>
                            <li>When required by law or legal process</li>
                            <li>To protect our rights, property, or safety</li>
                            <li>With your healthcare providers as necessary for treatment</li>
                            <li>With trusted service providers who assist in our operations</li>
                        </ul>
                        
                        <h4>5. Data Security</h4>
                        <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. This includes:</p>
                        <ul>
                            <li>Encryption of sensitive data</li>
                            <li>Secure server infrastructure</li>
                            <li>Regular security audits and updates</li>
                            <li>Access controls and authentication</li>
                        </ul>
                        
                        <h4>6. HIPAA Compliance</h4>
                        <p>As a healthcare provider, we comply with the Health Insurance Portability and Accountability Act (HIPAA) and other applicable privacy laws. Your protected health information is handled according to HIPAA standards.</p>
                        
                        <h4>7. Your Rights</h4>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Access your personal information</li>
                            <li>Request corrections to your information</li>
                            <li>Request deletion of your information (subject to legal requirements)</li>
                            <li>Opt-out of certain communications</li>
                            <li>File a complaint with regulatory authorities</li>
                        </ul>
                        
                        <h4>8. Cookies and Tracking</h4>
                        <p>Our website uses cookies and similar technologies to:</p>
                        <ul>
                            <li>Remember your preferences and settings</li>
                            <li>Improve website functionality</li>
                            <li>Analyze website usage and performance</li>
                            <li>Provide personalized content</li>
                        </ul>
                        
                        <h4>9. Data Retention</h4>
                        <p>We retain your information for as long as necessary to provide our services and comply with legal obligations. Medical records are typically retained according to state and federal requirements.</p>
                        
                        <h4>10. Children's Privacy</h4>
                        <p>Our services are not intended for children under 13. We do not knowingly collect personal information from children under 13 without parental consent.</p>
                        
                        <h4>11. Updates to This Policy</h4>
                        <p>We may update this privacy policy from time to time. We will notify you of any material changes by posting the new policy on our website and updating the effective date.</p>
                        
                        <h4>12. Contact Information</h4>
                        <p>If you have questions about this privacy policy or our privacy practices, please contact us:</p>
                        <ul>
                            <li><strong>Email:</strong> privacy@hospitalmgmt.com</li>
                            <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                            <li><strong>Address:</strong> 123 Medical Center Drive, Healthcare City, HC 12345</li>
                        </ul>
                        
                        <div class="alert alert-info">
                            <strong>Note:</strong> This privacy policy applies to all services provided through our hospital management system. For specific medical privacy concerns, please consult with your healthcare provider.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.privacy-content h3 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.privacy-content h4 {
    color: #34495e;
    margin-top: 25px;
    margin-bottom: 15px;
}

.privacy-content p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.privacy-content ul {
    margin-bottom: 15px;
}

.privacy-content li {
    margin-bottom: 8px;
    line-height: 1.5;
}
</style>

<?php require_once 'includes/footer.php'; ?>
