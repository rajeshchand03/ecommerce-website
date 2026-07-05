<?php
require_once 'auth.php';
require_once '../includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin | Users</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body style="background: var(--bg-color);">

<?php include("sidebar.php"); ?>

<div class="main">
    <h1 style="color: var(--heading-color); margin-bottom: 30px; font-size: 28px; font-weight: 700;">👥 Users Management</h1>
    
    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Registered Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = $conn->query("SELECT * FROM users ORDER BY id DESC");

                    while($u = $q->fetch_assoc()){
                    ?>
                    <tr>
                        <td><strong>#<?php echo $u['id']; ?></strong></td>
                        <td style="font-weight: 600; color: var(--heading-color);">
                            <?php echo htmlspecialchars($u['name']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['phone']); ?></td>
                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($u['address']); ?>">
                            <?php echo htmlspecialchars($u['address']); ?>
                        </td>
                        <td><?php echo date('d M Y, h:i A', strtotime($u['created_at'])); ?></td>
                        <td style="white-space: nowrap;">
                            <a href="delete_user.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="action-btn" style="background: #fee2e2; color: #dc2626;">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($q->num_rows == 0){ ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px;">No users registered yet.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
