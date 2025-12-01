<?php
require_once 'config.php';

// Set JSON content type
header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Validate input
    if (empty($appointment_id) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit();
    }
    
    // Validate status
    $allowed_statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
    if (!in_array($status, $allowed_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit();
    }
      try {
        // Get current status before updating
        $stmt = $pdo->prepare("SELECT status FROM appointments WHERE id = ?");
        $stmt->execute([$appointment_id]);
        $current_appointment = $stmt->fetch();
        
        if (!$current_appointment) {
            echo json_encode(['success' => false, 'message' => 'Appointment not found']);
            exit();
        }
        
        $old_status = $current_appointment['status'];
          // Update appointment status
        $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $result = $stmt->execute([$status, $appointment_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update appointment status']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
