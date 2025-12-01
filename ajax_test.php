<?php
require_once 'config.php';

// Simple test to check if the update_appointment_status.php works
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test'])) {
    // Simulate the AJAX call
    $data = array(
        'appointment_id' => 1,
        'status' => 'confirmed'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/hospitalmanagement/update_appointment_status.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, session_name().'='.session_id());
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo "<h3>Test Response:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    $json_response = json_decode($response, true);
    echo "<h3>Parsed JSON:</h3>";
    echo "<pre>" . print_r($json_response, true) . "</pre>";
}

$page_title = "AJAX Test";
include 'includes/header.php';
?>

<div style="text-align: center; margin-top: 50px;">
    <h2>AJAX Update Status Test</h2>
</div>

<div class="container content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Test Appointment Status Update</h3>
                </div>
                <div class="panel-body">
                    <?php if (isLoggedIn() && isAdmin()): ?>
                        <p>You are logged in as admin. Testing AJAX functionality:</p>
                        
                        <button id="testBtn" class="btn btn-primary">Test Status Update (ID: 1)</button>
                        <div id="result" style="margin-top: 20px;"></div>
                        
                        <hr>
                        
                        <form method="post">
                            <button type="submit" name="test" class="btn btn-info">Test via PHP cURL</button>
                        </form>
                    <?php else: ?>
                        <p class="text-danger">You must be logged in as admin to test this functionality.</p>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#testBtn').click(function() {
        $('#result').html('<div class="alert alert-info">Testing...</div>');
        
        $.ajax({
            url: 'update_appointment_status.php',
            method: 'POST',
            dataType: 'json',
            data: {
                appointment_id: 1,
                status: 'confirmed'
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    $('#result').html('<div class="alert alert-success">Success: ' + response.message + '</div>');
                } else {
                    $('#result').html('<div class="alert alert-danger">Error: ' + (response.message || 'Unknown error') + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
                $('#result').html('<div class="alert alert-danger">AJAX Error: ' + error + '<br>Response: ' + xhr.responseText + '</div>');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
