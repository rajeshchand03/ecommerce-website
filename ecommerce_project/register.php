<?php
session_start();
include("includes/db.php");

$message = "";

if(isset($_POST['register'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password != $confirm){
        $message = "Passwords do not match!";
    }else{

        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $message = "Email already exists!";
        }else{

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn,"INSERT INTO users(name,email,password)
                                VALUES('$name','$email','$hashed')");

            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | DoonKart</title>
    <link rel="stylesheet" href="assets/css/auth.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="auth-card-container">
    <div class="auth-box">
        <div class="auth-logo">
            <a href="index.php">
                <img src="assets/logo1.png" alt="DoonKart" onerror="this.src='https://via.placeholder.com/120x30?text=DoonKart'">
            </a>
        </div>
        
        <h2>Create Account</h2>
        <p class="subtitle">Join DoonKart and start your premium shopping journey.</p>

        <?php if($message): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="name" placeholder="Full Name" required autocomplete="name">
                <i class="fa-regular fa-user"></i>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required autocomplete="email">
                <i class="fa-regular fa-envelope"></i>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                <i class="fa-solid fa-lock"></i>
            </div>
            
            <div class="input-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password">
                <i class="fa-solid fa-shield-check" style="font-size: 14px;"></i>
            </div>
            
            <button type="submit" name="register">Sign Up Now</button>
        </form>

        <p class="footer-link">Already have an account? <a href="login.php">Login here</a></p>
        <p class="footer-link" style="margin-top: 15px;"><a href="index.php" style="color: #64748b; font-weight: 500;"><i class="fa-solid fa-arrow-left"></i> Back to Store</a></p>
    </div>
</div>

</body>
</html>
