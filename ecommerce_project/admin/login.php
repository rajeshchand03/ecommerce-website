<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

<form action="login_check.php" method="post" class="login-box">
<h2>DoonKart Admin Login</h2>

<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

<?php if(isset($_GET['error'])){ ?>
<p style="color:red;text-align:center">Invalid Login</p>
<?php } ?>

</form>

</body>
</html>