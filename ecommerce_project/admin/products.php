<?php
require_once 'auth.php';
include("../includes/db.php");

$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products - Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body style="background: var(--bg-color);">

<?php include("sidebar.php"); ?>

<div class="main">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <h1 style="color: var(--heading-color); font-size: 28px; font-weight: 700; margin: 0;">📦 Manage Products</h1>
        <a href="add_product.php" style="padding: 12px 25px; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; transition: background 0.3s ease;">➕ Add New Product</a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td>
                            <img src="../uploads/<?php echo $row['image1'] ?? $row['image']; ?>" width="50" height="50" style="border-radius: 8px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onerror="this.src='https://via.placeholder.com/50?text=Img'">
                        </td>
                        <td style="font-weight: 600; color: var(--heading-color);">
                            <?php echo htmlspecialchars($row['title'] ?? $row['product_name']); ?>
                        </td>
                        <td style="color: #4b5563; font-weight: 500;">Rs. <?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <span class="badge" style="background: #d1fae5; color: #059669;">
                                <?php echo ucfirst($row['status'] ?? 'Available'); ?>
                            </span>
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="action-btn" style="background: #eff6ff; color: #3b82f6; margin-right: 5px;">
                                ✏️ Edit
                            </a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="action-btn" style="background: #fee2e2; color: #dc2626;" onclick="return confirm('Are you sure you want to delete this product?')">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($result->num_rows == 0){ ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px;">No products found.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
