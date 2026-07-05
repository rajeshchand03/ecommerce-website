<?php
require_once 'includes/db.php';
session_start();

$user = $_SESSION['user'] ?? '';
$id = intval($_GET['id']);

$stmt = $conn->prepare(
 "UPDATE orders SET status='Cancelled' WHERE id=? AND user=? AND status='Pending'"
);
$stmt->bind_param("is",$id,$user);
$stmt->execute();

header("Location: my_orders.php");
exit;