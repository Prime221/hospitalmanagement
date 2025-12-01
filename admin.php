<?php
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'includes/header.php';

// Get dashboard statistics
try {
    $stats = [];
    
    // Total appointments
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM appointments");
    $stats['appointments'] = $stmt->fetch()['count'];
      // Total patients
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'patient'");
    $stats['patients'] = $stmt->fetch()['count'];
    
    // Total doctors
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM doctors");
    $stats['doctors'] = $stmt->fetch()['count'];
    
    // Total payments
    $stmt = $pdo->query("SELECT SUM(amount) as total FROM payments WHERE status = 'completed'");
    $stats['revenue'] = $stmt->fetch()['total'] ?? 0;    // Recent appointments
    $stmt = $pdo->prepare("
        SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as patient_name, d.name as doctor_name 
        FROM appointments a 
        JOIN users u ON a.patient_id = u.id 
        JOIN doctors d ON a.doctor_id = d.id 
        ORDER BY a.created_at DESC 
        LIMIT 10
    ");
    $stmt->execute();
    $recentAppointments = $stmt->fetchAll();
    
    // Recent contact messages
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
    $recentMessages = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $error = "Error fetching dashboard data: " . $e->getMessage();
}
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>ADMIN DASHBOARD</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calendar fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $stats['appointments'] ?? 0; ?></div>
                            <div>Total Appointments</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#appointments-section">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $stats['patients'] ?? 0; ?></div>
                            <div>Total Patients</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#patients-section">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user-md fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $stats['doctors'] ?? 0; ?></div>
                            <div>Total Doctors</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="doctors.php">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-dollar fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">$<?php echo number_format($stats['revenue'] ?? 0, 0); ?></div>
                            <div>Total Revenue</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#revenue-section">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Appointments -->
        <div class="col-md-8">
            <div class="panel panel-default" id="appointments-section">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent Appointments</h3>
                </div>
                <div class="panel-body">
                    <?php if (!empty($recentAppointments)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentAppointments as $appointment): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                            <td><?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?></td>
                                            <td><?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></td>
                                            <td>
                                                <span class="label label-<?php 
                                                    echo $appointment['status'] == 'confirmed' ? 'success' : 
                                                         ($appointment['status'] == 'pending' ? 'warning' : 'danger'); 
                                                ?>">
                                                    <?php echo ucfirst($appointment['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-xs btn-info" onclick="viewAppointment(<?php echo $appointment['id']; ?>)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button class="btn btn-xs btn-success" onclick="updateStatus(<?php echo $appointment['id']; ?>, 'confirmed')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button class="btn btn-xs btn-danger" onclick="updateStatus(<?php echo $appointment['id']; ?>, 'cancelled')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No appointments found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Messages -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent Messages</h3>
                </div>
                <div class="panel-body">
                    <?php if (!empty($recentMessages)): ?>
                        <div class="list-group">
                            <?php foreach ($recentMessages as $message): ?>
                                <div class="list-group-item">
                                    <h5 class="list-group-item-heading"><?php echo htmlspecialchars($message['subject']); ?></h5>
                                    <p class="list-group-item-text">
                                        <small>From: <?php echo htmlspecialchars($message['name']); ?></small><br>
                                        <small>Email: <?php echo htmlspecialchars($message['email']); ?></small><br>
                                        <small><?php echo date('M j, Y g:i A', strtotime($message['created_at'])); ?></small>
                                    </p>
                                    <p><?php echo substr(htmlspecialchars($message['message']), 0, 100) . '...'; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No messages found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Quick Actions</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="doctors.php" class="btn btn-primary btn-block">
                                <i class="fa fa-user-md"></i> Manage Doctors
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-block" onclick="viewAllAppointments()">
                                <i class="fa fa-calendar"></i> All Appointments
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info btn-block" onclick="viewAllPatients()">
                                <i class="fa fa-users"></i> All Patients
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="contact.php" class="btn btn-warning btn-block">
                                <i class="fa fa-envelope"></i> View Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.huge {
    font-size: 40px;
}

.panel-footer a {
    color: inherit;
    text-decoration: none;
}

.panel-footer a:hover {
    text-decoration: none;
    color: inherit;
}
</style>

<script>
function viewAppointment(id) {
    alert('View appointment #' + id + ' - Feature coming soon!');
}

function updateStatus(id, status) {
    if (confirm('Are you sure you want to update this appointment status to ' + status + '?')) {
        // AJAX call to update status
        $.ajax({
            url: 'update_appointment_status.php',
            method: 'POST',
            dataType: 'json',
            data: {
                appointment_id: id,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    alert('Appointment status updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating status: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', xhr.responseText);
                alert('Error updating appointment status: ' + error);
            }
        });
    }
}

function viewAllAppointments() {
    alert('All appointments view - Feature coming soon!');
}

function viewAllPatients() {
    alert('All patients view - Feature coming soon!');
}
</script>

<?php require_once 'includes/footer.php'; ?>
