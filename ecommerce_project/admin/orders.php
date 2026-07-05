<?php
require_once 'auth.php';
require_once '../includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin | Orders</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body style="background: var(--bg-color);">

<?php include("sidebar.php"); ?>

<div class="main">
    <h1 style="color: var(--heading-color); margin-bottom: 30px; font-size: 28px; font-weight: 700;">📦 Orders Management</h1>
    
    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = $conn->query("
                    SELECT o.*, p.title 
                    FROM orders o 
                    JOIN products p ON o.product_id = p.id
                    ORDER BY o.id DESC
                    ");

                    while($o = $q->fetch_assoc()){
                        $status = strtolower($o['status']);
                        $badge_class = 'badge-pending';
                        if ($status == 'delivered') $badge_class = 'badge-delivered';
                        if ($status == 'cancelled') $badge_class = 'badge-cancelled';
                    ?>
                    <tr>
                        <td><strong>#<?php echo $o['id']; ?></strong></td>
                        <td>
                            <div style="font-weight: 600; color: var(--heading-color);"><?php echo htmlspecialchars($o['name']); ?></div>
                            <div style="font-size: 13px; color: #6b7280;"><?php echo $o['phone']; ?></div>
                        </td>
                        <td><?php echo htmlspecialchars($o['title']); ?></td>
                        <td><?php echo $o['quantity']; ?></td>
                        <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($o['address']); ?>">
                            <?php echo htmlspecialchars($o['address']); ?>
                        </td>
                        <td><?php echo $o['payment']; ?></td>
                        <td>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo htmlspecialchars($o['status']); ?>
                            </span>
                        </td>
                        <td style="white-space: nowrap;">
                            <?php if($o['status'] == "Pending"){ ?>
                            <a href="update_order.php?id=<?php echo $o['id']; ?>&status=Delivered" class="action-btn" style="background: #d1fae5; color: #059669;">
                                ✔ Deliver
                            </a>
                            <?php } ?>
                            
                            <a href="delete_order.php?id=<?php echo $o['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')" class="action-btn" style="background: #fee2e2; color: #dc2626;">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($q->num_rows == 0){ ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px;">No orders found.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>