<?php
session_start();
require_once 'includes/db.php';

if(empty($_SESSION['cart'])){
    header("Location: cart.php"); exit;
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$payment = $_POST['payment'];
$user = $_SESSION['user'] ?? 'Guest';

foreach($_SESSION['cart'] as $pid=>$qty){
    $stmt = $conn->prepare(
      "INSERT INTO orders 
      (user, product_id, quantity, name, phone, address, payment)
      VALUES (?,?,?,?,?,?,?)"
    );
    $stmt->bind_param(
      "siissss",
      $user,$pid,$qty,$name,$phone,$address,$payment
    );
    $stmt->execute();
}

unset($_SESSION['cart']);
?>

<script>
alert("✅ Order placed successfully!");
window.location.href="index.php";
</script>