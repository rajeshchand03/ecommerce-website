<?php
require_once 'auth.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce_project/includes/db.php';

$success = false;

if (isset($_POST['add'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = intval($_POST['price']);

    $allowed = ['image/jpeg','image/png','image/webp'];
    $images = [];

    for ($i=1; $i<=3; $i++) {
        if (!in_array($_FILES["image$i"]['type'], $allowed)) {
            die("Invalid image type");
        }

        $name = time()."_$i_".basename($_FILES["image$i"]['name']);
        $path = $_SERVER['DOCUMENT_ROOT']."/ecommerce_project/uploads/".$name;

        move_uploaded_file($_FILES["image$i"]['tmp_name'], $path);
        $images[] = $name;
    }

    $category_id = intval($_POST['category_id']);

    $stmt = $conn->prepare(
        "INSERT INTO products (title, category_id, description, price, image1, image2, image3)
         VALUES (?,?,?,?,?,?,?)"
    );
    $stmt->bind_param("sisisss",
        $title, $category_id, $description, $price, $images[0], $images[1], $images[2]
    );
    $stmt->execute();

    $success = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: #f4f6f9;">

<?php if($success){ ?>
<script>
alert("✅ Product Added Successfully");
window.location.href="products.php";
</script>
<?php } ?>

<?php include("sidebar.php"); ?>

<div class="main">

<?php
$cats = mysqli_query($conn, "SELECT * FROM categories");
?>
    <div style="max-width: 600px; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-top: 20px;">
        <h2 style="margin-bottom: 25px; color: var(--heading-color); font-size: 24px; font-weight: 700;">Add New Product</h2>
        <form method="post" enctype="multipart/form-data">

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 14px;">Product Title</label>
                <input type="text" name="title" placeholder="Enter product name" required style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 14px; outline: none; transition: border-color 0.2s;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 14px;">Category</label>
                <select name="category_id" required style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 14px; outline: none; background: #fff; cursor: pointer;">
                    <option value="">Select Category</option>
                    <?php while($c = mysqli_fetch_assoc($cats)): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 14px;">Description</label>
                <textarea name="description" placeholder="Full Description" rows="5" required style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 14px; outline: none; resize: vertical;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 14px;">Price (Rs.)</label>
                <input type="number" name="price" placeholder="e.g. 1500" required style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 14px; outline: none;">
            </div>

            <div class="form-group" style="margin-bottom: 25px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px dashed #d1d5db;">
                    <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: #4b5563;">Image 1 (Main)</label>
                    <input type="file" name="image1" required style="width: 100%; font-size: 13px; color: #6b7280; cursor: pointer;">
                </div>
                <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px dashed #d1d5db;">
                    <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: #4b5563;">Image 2</label>
                    <input type="file" name="image2" required style="width: 100%; font-size: 13px; color: #6b7280; cursor: pointer;">
                </div>
                <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px dashed #d1d5db;">
                    <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: #4b5563;">Image 3</label>
                    <input type="file" name="image3" required style="width: 100%; font-size: 13px; color: #6b7280; cursor: pointer;">
                </div>
            </div>

            <button name="add" style="width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s ease;">➕ Add Product</button>
        </form>
    </div>
</div>

</body>
</html>