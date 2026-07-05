<?php
session_start();
include("includes/db.php");

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) == 1){

        $user = mysqli_fetch_assoc($query);

        if(password_verify($password,$user['password'])){

            $_SESSION['user'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: index.php");
            exit();

        }else{
            $message = "Incorrect password!";
        }

    }else{
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DoonKart</title>
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
        
        <h2>Welcome Back!</h2>
        <p class="subtitle">Log in to your DoonKart account to continue shopping.</p>

        <?php if($message): ?>
            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required autocomplete="email">
                <i class="fa-regular fa-envelope"></i>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <i class="fa-solid fa-lock"></i>
            </div>
            
            <button type="submit" name="login">Login Now</button>
        </form>

        <p class="footer-link">Don't have an account? <a href="register.php">Register here</a></p>
        <p class="footer-link" style="margin-top: 15px;"><a href="index.php" style="color: #64748b; font-weight: 500;"><i class="fa-solid fa-arrow-left"></i> Back to Store</a></p>
    </div>
</div>

</body>
</html>
