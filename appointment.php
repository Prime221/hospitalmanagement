<?php
require_once 'config.php';

$page_title = "Book Appointment";
$additional_css = [
    'assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css',
    'assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css'
];

// Check if user is logged in
if (!isLoggedIn() || isAdmin()) {
    redirect('login.php');
}

$message = '';
$selected_doctor_id = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 0;

// Handle appointment booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $symptoms = sanitize($_POST['symptoms']);
    
    // Validation
    $errors = [];
    
    if (empty($doctor_id)) $errors[] = "Please select a doctor";
    if (empty($appointment_date)) $errors[] = "Please select appointment date";
    if (empty($appointment_time)) $errors[] = "Please select appointment time";
    if (strtotime($appointment_date) < strtotime(date('Y-m-d'))) $errors[] = "Appointment date cannot be in the past";
      if (empty($errors)) {
        try {
            // Check if appointment slot is available
            $stmt = $pdo->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'");
            $stmt->execute([$doctor_id, $appointment_date, $appointment_time]);
            
            if ($stmt->rowCount() > 0) {
                $message = '<div class="alert alert-danger">This appointment slot is already booked. Please choose a different time.</div>';
            } else {
                // Book the appointment
                $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, symptoms) VALUES (?, ?, ?, ?, ?)");
                
                if ($stmt->execute([$_SESSION['user_id'], $doctor_id, $appointment_date, $appointment_time, $symptoms])) {
                    $message = '<div class="alert alert-success">Appointment booked successfully! We will contact you soon for confirmation.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Failed to book appointment. Please try again.</div>';
                }
            }
        } catch(PDOException $e) {
            $message = '<div class="alert alert-danger">Database error. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
    }
}

// Get doctors for the dropdown
try {
    $stmt = $pdo->prepare("SELECT d.*, dept.name as department_name FROM doctors d LEFT JOIN departments dept ON d.department_id = dept.id ORDER BY d.name");
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $doctors = [];
}

include 'includes/header.php';
?>

<!--=== Heading ===-->
<div class="container content">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-9" style="margin-bottom: 30px;">
            <div class="headline">
                <h2>BOOK APPOINTMENT</h2>
                <p>Schedule your appointment with our expert doctors</p>
            </div>
            
            <?php echo $message; ?>
            
            <!--=== APPOINTMENT FORM ===-->
            <form method="post" action="appointment.php" class="sky-form sky-changes-3">
                <header>Appointment Details</header>
                
                <fieldset>
                    <div class="row">
                        <section class="col col-6">
                            <label class="label">Select Doctor <span class="required">*</span></label>
                            <label class="select">
                                <select name="doctor_id" required>
                                    <option value="">Choose Doctor</option>
                                    <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?php echo $doctor['id']; ?>" 
                                            <?php echo ($selected_doctor_id == $doctor['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($doctor['name']); ?> - <?php echo htmlspecialchars($doctor['specialization']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <i></i>
                            </label>
                        </section>
                        
                        <section class="col col-6">
                            <label class="label">Department</label>
                            <label class="input">
                                <input type="text" id="department_display" readonly placeholder="Department will be shown here">
                            </label>
                        </section>
                    </div>
                    
                    <div class="row">
                        <section class="col col-6">
                            <label class="label">Appointment Date <span class="required">*</span></label>
                            <label class="input">
                                <input type="date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                            </label>
                        </section>
                        
                        <section class="col col-6">
                            <label class="label">Appointment Time <span class="required">*</span></label>
                            <label class="select">
                                <select name="appointment_time" required>
                                    <option value="">Choose Time</option>
                                    <option value="09:00:00">09:00 AM</option>
                                    <option value="09:30:00">09:30 AM</option>
                                    <option value="10:00:00">10:00 AM</option>
                                    <option value="10:30:00">10:30 AM</option>
                                    <option value="11:00:00">11:00 AM</option>
                                    <option value="11:30:00">11:30 AM</option>
                                    <option value="14:00:00">02:00 PM</option>
                                    <option value="14:30:00">02:30 PM</option>
                                    <option value="15:00:00">03:00 PM</option>
                                    <option value="15:30:00">03:30 PM</option>
                                    <option value="16:00:00">04:00 PM</option>
                                    <option value="16:30:00">04:30 PM</option>
                                    <option value="17:00:00">05:00 PM</option>
                                    <option value="17:30:00">05:30 PM</option>
                                </select>
                                <i></i>
                            </label>
                        </section>
                    </div>
                    
                    <section>
                        <label class="label">Symptoms / Reason for Visit</label>
                        <label class="textarea">
                            <textarea rows="4" name="symptoms" placeholder="Please describe your symptoms or reason for the appointment"></textarea>
                        </label>
                    </section>
                </fieldset>
                
                <footer>
                    <button type="submit" class="btn-u">Book Appointment</button>
                    <button type="button" class="btn-u btn-u-light" onclick="window.location.href='doctors.php'">View Doctors</button>
                </footer>
            </form>
        </div><!--/col-md-9-->
        
        <!-- side part of appointment -->
        <div class="col-md-3" style="margin-top: 56px;">
            <!-- Address -->
            <div class="headline">
                <h2>Appointment Hours</h2>
            </div>
            <p>You Only Can Book Your Appointment Between <strong>9 AM to 6 PM.</strong></p>
            <p>In Other Times You Can Call Our Ambulance Which Is Available 24/7.</p>
            
            <!-- Business Hours -->
            <div class="headline" style="margin-top: 30px;">
                <h2>Emergency Contact</h2>
            </div>
            <ul class="list-unstyled">
                <li><i class="fa fa-phone"></i> Emergency: +8801765489641</li>
                <li><i class="fa fa-envelope"></i> Email: emergency@unityhospital.com</li>
                <li><i class="fa fa-clock-o"></i> 24/7 Emergency Services</li>
            </ul>
            
            <!-- Instructions -->
            <div class="headline" style="margin-top: 30px;">
                <h2>Important Notes</h2>
            </div>
            <ul class="list-unstyled">
                <li><i class="fa fa-check"></i> Arrive 15 minutes early</li>
                <li><i class="fa fa-check"></i> Bring valid ID and insurance</li>
                <li><i class="fa fa-check"></i> Bring previous medical records</li>
                <li><i class="fa fa-check"></i> List current medications</li>
            </ul>
        </div><!--/col-md-3-->
    </div><!--/row-->
</div><!--/container-->

<?php
$inline_js = "
// Update department when doctor is selected
$(document).ready(function() {
    var doctors = " . json_encode($doctors) . ";
    
    $('select[name=\"doctor_id\"]').change(function() {
        var doctorId = $(this).val();
        var department = '';
        
        if (doctorId) {
            for (var i = 0; i < doctors.length; i++) {
                if (doctors[i].id == doctorId) {
                    department = doctors[i].department_name || 'General';
                    break;
                }
            }
        }
        
        $('#department_display').val(department);
    });
    
    // Trigger change on page load if doctor is pre-selected
    $('select[name=\"doctor_id\"]').trigger('change');
});
";

include 'includes/footer.php';
?>
