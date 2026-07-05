<?php
require_once 'includes/db.php';
session_start();

$id = intval($_GET['id']);
$user = $_SESSION['user'] ?? '';

$q = $conn->prepare("
SELECT o.*, p.title, p.price
FROM orders o
JOIN products p ON o.product_id=p.id
WHERE o.id=? AND o.user=?
");
$q->bind_param("is",$id,$user);
$q->execute();
$o = $q->get_result()->fetch_assoc();

if(!$o) die("Invoice not found");
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice #<?php echo $o['id']; ?></title>
<style>
body{font-family:Arial}
.invoice{
 max-width:600px;margin:40px auto;border:1px solid #ddd;padding:20px
}
h2{text-align:center}
</style>
</head>
<body>

<div class="invoice">
<h2>🧾 Invoice</h2>

<p><b>Order ID:</b> <?php echo $o['id']; ?></p>
<p><b>Name:</b> <?php echo htmlspecialchars($o['name']); ?></p>
<p><b>Product:</b> <?php echo htmlspecialchars($o['title']); ?></p>
<p><b>Quantity:</b> <?php echo $o['quantity']; ?></p>
<p><b>Price:</b> Rs. <?php echo $o['price']; ?></p>
<p><b>Total:</b> Rs. <?php echo $o['price'] * $o['quantity']; ?></p>
<p><b>Payment:</b> <?php echo $o['payment']; ?></p>
<p><b>Status:</b> <?php echo $o['status']; ?></p>

<hr>
<p>Thank you for shopping with us ❤️</p>
</div>

</body>
</html>