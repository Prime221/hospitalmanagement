<?php
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        redirect('admin.php');
    } else {
        redirect('index.php');
    }
}

$page_title = "Registration";
$message = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    
    // Validation
    $errors = [];
    
    if (empty($first_name)) $errors[] = "First name is required";
    if (empty($last_name)) $errors[] = "Last name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
      if (empty($errors)) {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $message = '<div class="alert alert-danger">Email already exists!</div>';
            } else {
                // Insert new user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, phone, address, date_of_birth, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                if ($stmt->execute([$first_name, $last_name, $email, $hashed_password, $phone, $address, $date_of_birth, $gender])) {
                    $message = '<div class="alert alert-success">Registration successful! You can now <a href="login.php">login</a>.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Registration failed. Please try again.</div>';
                }
            }
        } catch(PDOException $e) {
            $message = '<div class="alert alert-danger">Database error. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
    }
}

include 'includes/header.php';
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px;">
    <h2>REGISTER</h2>
</div>
<!-- End title -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <?php echo $message; ?>
            
            <form method="post" action="registration.php" class="reg-page">
                <div class="reg-header">
                    <h2>Create Your Account</h2>
                    <p>Join Unity Hospital for better healthcare services</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label>First Name <span class="color-red">*</span></label>
                        <input type="text" name="first_name" class="form-control" style="margin-bottom: 20px;" required value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Last Name <span class="color-red">*</span></label>
                        <input type="text" name="last_name" class="form-control" style="margin-bottom: 20px;" required value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                    </div>
                </div>
                
                <label>Email Address <span class="color-red">*</span></label>
                <input type="email" name="email" class="form-control" style="margin-bottom: 20px;" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <label>Password <span class="color-red">*</span></label>
                        <input type="password" name="password" class="form-control" style="margin-bottom: 20px;" required>
                    </div>
                    <div class="col-md-6">
                        <label>Confirm Password <span class="color-red">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" style="margin-bottom: 20px;" required>
                    </div>
                </div>
                
                <label>Phone Number</label>
                <input type="tel" name="phone" class="form-control" style="margin-bottom: 20px;" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                
                <label>Address</label>
                <textarea name="address" class="form-control" style="margin-bottom: 20px;" rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                
                <div class="row">
                    <div class="col-md-6">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" style="margin-bottom: 20px;" value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Gender</label>
                        <select name="gender" class="form-control" style="margin-bottom: 20px;">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="checkbox">
                    <label>
                        <input type="checkbox" required>
                        I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>
                    </label>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p>Already have an account? <a href="login.php" class="color-green">Login here</a></p>
                    </div>
                    <div class="col-md-6">
                        <button class="btn-u pull-right" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--/container-->
<!--=== End Content Part ===-->

<?php include 'includes/footer.php'; ?>
