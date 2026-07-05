<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if($username === "admin" && $password === "admin123"){

    $_SESSION['admin_logged_in'] = true;

    header("Location: dashboard.php");
    exit();

}else{

    header("Location: login.php?error=1");
    exit();

}
?>