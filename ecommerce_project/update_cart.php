<?php
session_start();

$id = intval($_GET['id']);
$action = $_GET['action'];

if(!isset($_SESSION['cart'][$id])){
    header("Location: cart.php"); exit;
}

if($action == 'inc'){
    $_SESSION['cart'][$id]++;
}
elseif($action == 'dec'){
    $_SESSION['cart'][$id]--;
    if($_SESSION['cart'][$id] <= 0){
        unset($_SESSION['cart'][$id]);
    }
}
elseif($action == 'remove'){
    unset($_SESSION['cart'][$id]);
}

header("Location: cart.php");
exit;