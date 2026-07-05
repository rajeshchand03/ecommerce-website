<?php
include 'includes/header.php';
require_once 'includes/db.php';

if(!isset($_SESSION['user_id'])){
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = intval($_SESSION['user_id']);
$user_res = $conn->query("SELECT name FROM users WHERE id=$user_id");
$user_row = $user_res->fetch_assoc();
$user_name = $user_row['name'] ?? '';

// Check if $_SESSION['user'] is set and not empty, if not set it
if(empty($_SESSION['user'])){
    $_SESSION['user'] = $user_name;
}
$user = $_SESSION['user'];
?>

<style>
.orders{
 max-width:1000px;
 margin:40px auto;
}
.order-card{
 border:1px solid #ddd;
 padding:15px;
 border-radius:8px;
 margin-bottom:15px;
 background:#fff;
}
.status{
 padding:4px 10px;
 border-radius:15px;
 font-size:13px;
}
.Pending{background:#ff9800;color:#fff}
.Delivered{background:#4caf50;color:#fff}
.Cancelled{background:#f44336;color:#fff}
.btn{
 padding:6px 12px;
 border:none;
 cursor:pointer;
 font-size:14px;
}
.cancel{background:#f44336;color:#fff}
.invoice{background:#2196f3;color:#fff}
</style>

<div class="orders">
<h2>📦 My Orders</h2>

<?php
$q = $conn->prepare("
SELECT o.*, p.title 
FROM orders o 
JOIN products p ON o.product_id=p.id
WHERE o.user=?
ORDER BY o.id DESC
");
$q->bind_param("s",$user);
$q->execute();
$res = $q->get_result();

if($res->num_rows > 0) {
    while($o = $res->fetch_assoc()){
?>
<div class="order-card">
<h4><?php echo htmlspecialchars($o['title']); ?></h4>
<p>Qty: <?php echo $o['quantity']; ?></p>
<p>Payment: <?php echo $o['payment']; ?></p>

<p>Status:
<span class="status <?php echo $o['status']; ?>">
<?php echo $o['status']; ?>
</span>
</p>

<?php if($o['status']=="Pending"){ ?>
<a href="cancel_order.php?id=<?php echo $o['id']; ?>"
onclick="return confirm('Cancel this order?')">
<button class="btn cancel">Cancel Order</button>
</a>
<?php } ?>

<a href="invoice.php?id=<?php echo $o['id']; ?>">
<button class="btn invoice">Download Invoice</button>
</a>
<a href="write_review.php?product_id=<?php echo $o['product_id']; ?>">
<button class="btn" style="background:#ffc107; color:#000; margin-top:5px;">⭐ Write Review</button>
</a>
</div>
<?php 
    } 
} else {
    echo "<div style='padding: 30px; background: #fff; border-radius: 8px; text-align: center; border: 1px solid #ddd;'>";
    echo "<h3 style='color: #666; margin-bottom: 10px;'>You haven't placed any orders yet.</h3>";
    echo "<p style='color: #888;'>Looks like you haven't made your first purchase.</p>";
    echo "<a href='index.php' style='display: inline-block; margin-top: 15px; padding: 10px 20px; background: var(--primary); color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;'>Start Shopping</a>";
    echo "</div>";
}
?>
</div>

<?php include 'includes/footer.php'; ?>