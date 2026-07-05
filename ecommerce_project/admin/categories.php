<?php
require_once 'auth.php';
require_once '../includes/db.php';
// Add Category
if(isset($_POST['add_category'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    if(!empty($name)){
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        mysqli_query($conn, $query);
    }
}

// Delete Category
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    header("Location: categories.php");
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<link rel="stylesheet" href="css/style.css">
<style>
    .cat-form { margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .cat-form input { padding: 8px; width: 250px; border: 1px solid #ddd; border-radius: 4px; }
    .cat-form button { padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { background: #f8f9fa; }
    .btn-delete { color: #dc3545; text-decoration: none; font-weight: bold; }
</style>
</head>
<body style="background: var(--bg-color);">

<?php include("sidebar.php"); ?>

<div class="main">
    <h1 style="color: var(--heading-color); margin-bottom: 30px; font-size: 28px; font-weight: 700;">📂 Manage Categories</h1>

    <div style="background: var(--card-bg); padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 30px;">
        <h2 style="font-size: 18px; margin-bottom: 15px; color: var(--heading-color);">Add New Category</h2>
        <form method="POST" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="name" placeholder="Enter category name" required style="flex: 1; min-width: 200px; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s;">
            <button type="submit" name="add_category" style="padding: 12px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.3s ease;">➕ Add Category</button>
        </form>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($categories)): ?>
                    <tr>
                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                        <td style="font-weight: 500; color: var(--heading-color);"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <a href="categories.php?delete=<?php echo $row['id']; ?>" class="action-btn" style="background: #fee2e2; color: #dc2626;" onclick="return confirm('Are you sure you want to delete this category?')">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if(mysqli_num_rows($categories) == 0): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 30px;">No categories found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
