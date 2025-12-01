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

$page_title = "Login";
$message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
      if (!empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Redirect based on user type
                if ($user['user_type'] === 'admin') {
                    redirect('admin.php');
                } else {
                    redirect('index.php');
                }
            } else {
                $message = '<div class="alert alert-danger">Invalid email or password!</div>';
            }
        } catch(PDOException $e) {
            $message = '<div class="alert alert-danger">Database error. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Please fill in all fields!</div>';
    }
}

include 'includes/header.php';
?>

<!-- title -->
<div style="text-align: center; margin-top: 50px;">
    <h2>LOGIN</h2>
</div>
<!--  title  -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <?php echo $message; ?>
            
            <form class="reg-page" method="post" action="login.php">
                <div class="reg-header">
                    <h2>Login to Your Account</h2>
                    <p>Please enter your credentials to access your account</p>
                </div>
                
                <div class="input-group" style="margin-bottom: 20px;">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>
                
                <div class="input-group" style="margin-bottom: 20px;">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label class="checkbox">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <button class="btn-u pull-right" type="submit">Login</button>
                    </div>
                </div>
                
                <hr>
                
                <h4>Don't have an account?</h4>
                <p><a class="color-green" href="registration.php">Register here</a> to create a new account.</p>
                
                <h4>Forget your Password?</h4>
                <p>no worries, <a class="color-green" href="#" onclick="alert('Please contact administrator at <?php echo ADMIN_EMAIL; ?>')">click here</a> to reset your password.</p>
            </form>
        </div>
    </div><!--/row-->
</div><!--/container-->
<!--=== End Content Part ===-->

<?php include 'includes/footer.php'; ?>
