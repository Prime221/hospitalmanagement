<?php
require_once 'config.php';

$page_title = "Payment";
$additional_css = [
    'assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css',
    'assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css'
];

// Check if user is logged in
if (!isLoggedIn() || isAdmin()) {
    redirect('login.php');
}

$message = '';

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = sanitize($_POST['patient_name']);
    $amount = (float)$_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $card_number = sanitize($_POST['card_number']);
    
    // Basic validation
    $errors = [];
    
    if (empty($patient_name)) $errors[] = "Patient name is required";
    if ($amount <= 0) $errors[] = "Valid amount is required";
    if (empty($payment_method)) $errors[] = "Payment method is required";
    
    if ($payment_method === 'credit_card' || $payment_method === 'debit_card') {
        if (empty($card_number)) $errors[] = "Card number is required";
        if (strlen($card_number) < 13) $errors[] = "Valid card number is required";
    }
      if (empty($errors)) {
        try {
            // Generate transaction ID
            $transaction_id = 'TXN' . time() . rand(1000, 9999);
            
            // Insert payment record
            $stmt = $pdo->prepare("INSERT INTO payments (patient_id, patient_name, amount, payment_method, card_number, transaction_id, status) VALUES (?, ?, ?, ?, ?, ?, 'completed')");
            
            $masked_card = $card_number ? '**** **** **** ' . substr($card_number, -4) : null;
            
            if ($stmt->execute([$_SESSION['user_id'], $patient_name, $amount, $payment_method, $masked_card, $transaction_id])) {
                $message = '<div class="alert alert-success">
                    <h4>Payment Successful!</h4>
                    <p><strong>Transaction ID:</strong> ' . $transaction_id . '</p>
                    <p><strong>Amount:</strong> $' . number_format($amount, 2) . '</p>
                    <p>Thank you for your payment. A receipt has been generated.</p>
                </div>';
            } else {
                $message = '<div class="alert alert-danger">Payment processing failed. Please try again.</div>';
            }
        } catch(PDOException $e) {
            $message = '<div class="alert alert-danger">Payment processing error. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
    }
}

include 'includes/header.php';
?>

<div class="payment-container">
    <div class="logo">
        <img src="assets/img/logo/unity_dark.jpg" alt="Unity Hospital">
    </div>
    
    <h2>Hospital Payment</h2>
    
    <?php echo $message; ?>
    
    <form method="post" action="payment.php" class="payment-form">
        <label for="patient_name">Patient Name *</label>
        <input type="text" id="patient_name" name="patient_name" required 
               value="<?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>">
        
        <label for="amount">Amount ($) *</label>
        <input type="number" id="amount" name="amount" step="0.01" min="1" required>
        
        <label for="payment_method">Payment Method *</label>
        <select id="payment_method" name="payment_method" required onchange="toggleCardDetails()">
            <option value="">Select Payment Method</option>
            <option value="credit_card">Credit Card</option>
            <option value="debit_card">Debit Card</option>
            <option value="cash">Cash</option>
            <option value="insurance">Insurance</option>
        </select>
        
        <div class="card-details" id="card_details" style="display: none;">
            <label for="card_number">Card Number *</label>
            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" 
                   pattern="[0-9\s]{13,19}" maxlength="19">
            
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="text" id="expiry_date" placeholder="MM/YY" maxlength="5">
                </div>
                <div style="flex: 1;">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" placeholder="123" maxlength="4">
                </div>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" required>
                I agree to the payment terms and conditions
            </label>
        </div>
        
        <button type="submit">Process Payment</button>
    </form>
    
    <!-- Payment Information -->
    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
        <h4>Payment Information</h4>
        <ul style="margin: 10px 0; padding-left: 20px;">
            <li>All payments are processed securely</li>
            <li>You will receive a confirmation email</li>
            <li>For insurance claims, please contact our billing department</li>
            <li>Cash payments can be made at the reception desk</li>
        </ul>
        
        <p><strong>Contact Billing Department:</strong></p>
        <p>Phone: +8801765489641<br>
        Email: billing@unityhospital.com<br>
        Hours: 9:00 AM - 6:00 PM</p>
    </div>
</div>

<style>
body {
    font-family: 'Open Sans', sans-serif;
    background: #f8f8f8;
    margin: 0;
    padding: 0;
}

.payment-container {
    max-width: 500px;
    background: white;
    margin: 40px auto;
    padding: 30px 40px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.logo {
    max-width: 120px;
    margin: 0 auto 20px auto;
}

.logo img {
    max-width: 100%;
    height: auto;
}

h2 {
    color: #72c02c;
    margin-bottom: 25px;
}

.payment-form {
    text-align: left;
}

.payment-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
}

.payment-form input,
.payment-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.payment-form button {
    width: 100%;
    padding: 12px;
    background-color: #72c02c;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.payment-form button:hover {
    background-color: #5da423;
}

.card-details {
    margin-top: 20px;
}
</style>

<?php
$inline_js = "
function toggleCardDetails() {
    var paymentMethod = document.getElementById('payment_method').value;
    var cardDetails = document.getElementById('card_details');
    
    if (paymentMethod === 'credit_card' || paymentMethod === 'debit_card') {
        cardDetails.style.display = 'block';
        document.getElementById('card_number').required = true;
    } else {
        cardDetails.style.display = 'none';
        document.getElementById('card_number').required = false;
    }
}

// Format card number input
document.getElementById('card_number').addEventListener('input', function(e) {
    var value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
    var formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    if (formattedValue.length <= 19) {
        e.target.value = formattedValue;
    }
});

// Format expiry date
document.getElementById('expiry_date').addEventListener('input', function(e) {
    var value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// Only allow numbers in CVV
document.getElementById('cvv').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\D/g, '');
});
";

include 'includes/footer.php';
?>
