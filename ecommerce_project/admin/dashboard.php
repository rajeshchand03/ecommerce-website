<?php
require_once 'auth.php';
require_once '../includes/db.php';

// Fetch Total Products
$product_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$total_products = mysqli_fetch_assoc($product_query)['total'];

// Fetch Total Orders
$order_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$total_orders = mysqli_fetch_assoc($order_query)['total'];

// Fetch Total Users
$user_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($user_query)['total'];

// Fetch Total Revenue
$revenue_query = mysqli_query($conn, "SELECT SUM(o.quantity * p.price) as revenue FROM orders o JOIN products p ON o.product_id = p.id WHERE o.status != 'Cancelled'");
$total_revenue = mysqli_fetch_assoc($revenue_query)['revenue'];
$total_revenue = $total_revenue ? $total_revenue : 0;

// Fetch Recent Orders
$recent_orders = mysqli_query($conn, "SELECT o.*, (o.quantity * p.price) as total_amount FROM orders o LEFT JOIN products p ON o.product_id = p.id ORDER BY o.id DESC LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">
    <h1>Admin Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h3>Total Products</h3>
            <h2><?php echo $total_products; ?></h2>
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <h2><?php echo $total_orders; ?></h2>
        </div>
        <div class="card">
            <h3>Total Users</h3>
            <h2><?php echo $total_users; ?></h2>
        </div>
        <div class="card">
            <h3>Total Revenue</h3>
            <h2>Rs. <?php echo number_format($total_revenue, 2); ?></h2>
        </div>
    </div>

    <div class="table-container">
        <h2>Recent Orders</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td>Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                        <td>
                            <?php
                                $status = strtolower($order['status']);
                                $badge_class = 'badge-pending';
                                if ($status == 'delivered') $badge_class = 'badge-delivered';
                                if ($status == 'cancelled') $badge_class = 'badge-cancelled';
                            ?>
                            <strong class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($order['status']); ?></strong>
                        </td>
                        <td><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></td>
                        <td>
                            <a href="orders.php?id=<?php echo $order['id']; ?>" class="action-btn edit-btn">View</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if(mysqli_num_rows($recent_orders) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No recent orders.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
