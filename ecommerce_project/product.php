<?php
include 'includes/header.php';

if(!isset($_GET['id'])){
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if(!$product){
    echo "<div class='container text-center section-padding'><h2>Product not found</h2></div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="container section-padding">
    <div class="product-detail-grid">
        <!-- Gallery -->
        <div class="gallery-col">
            <div class="main-img-box">
                <img id="mainImage" src="uploads/<?php echo $product['image1']; ?>" alt="Product">
            </div>
            <div class="thumb-row mt-4">
                <?php if(!empty($product['image1'])): ?>
                    <img src="uploads/<?php echo $product['image1']; ?>" onclick="changeImg(this)" class="active-thumb">
                <?php endif; ?>
                <?php if(!empty($product['image2'])): ?>
                    <img src="uploads/<?php echo $product['image2']; ?>" onclick="changeImg(this)">
                <?php endif; ?>
                <?php if(!empty($product['image3'])): ?>
                    <img src="uploads/<?php echo $product['image3']; ?>" onclick="changeImg(this)">
                <?php endif; ?>
            </div>
        </div>

        <!-- Info -->
        <div class="info-col">
            <span class="stock-tag">In Stock</span>
            <h1 style="font-size: 28px; margin-bottom: 10px;"><?php echo htmlspecialchars($product['title']); ?></h1>
            <div class="price-box mb-8">Rs. <?php echo number_format($product['price'], 2); ?></div>
            
            <div class="desc-box mb-8">
                <h4 style="margin-bottom: 10px; border-bottom: 2px solid var(--primary); display: inline-block;">Description</h4>
                <p style="color: var(--text-muted); font-size: 15px;"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <form method="post" action="add_to_cart.php" class="flex gap-4">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 15px;">Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h3 style="border-bottom: 2px solid var(--primary); padding-bottom: 10px; margin-bottom: 20px;">Customer Reviews & Ratings</h3>
        
        <?php
        $rev_q = $conn->prepare("SELECT * FROM reviews WHERE product_id=? ORDER BY id DESC");
        $rev_q->bind_param("i", $id);
        $rev_q->execute();
        $reviews = $rev_q->get_result();

        if($reviews->num_rows > 0){
            while($r = $reviews->fetch_assoc()){
                $stars = str_repeat("⭐", $r['rating']);
                $date = date('d M, Y', strtotime($r['created_at']));
                echo "<div class='review-card'>";
                echo "<h4><i class='fa-solid fa-circle-user' style='color:#ccc; margin-right:5px;'></i> " . htmlspecialchars($r['user_name']) . " <span style='font-size: 12px; color: #888; font-weight: normal; margin-left: 10px;'>$date</span></h4>";
                echo "<div class='stars' style='margin-bottom: 10px;'>$stars</div>";
                echo "<p style='color: #555;'>" . nl2br(htmlspecialchars($r['comment'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p style='color: #777;'>No reviews yet. Buy this product and be the first to review!</p>";
        }
        ?>
    </div>
</div>

<style>
.product-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.main-img-box { height: 400px; border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; background: #fff; }
.main-img-box img { width: 100%; height: 100%; object-fit: contain; }
.thumb-row { display: flex; gap: 10px; }
.thumb-row img { width: 70px; height: 70px; object-fit: cover; border: 2px solid transparent; cursor: pointer; border-radius: 4px; }
.thumb-row img.active-thumb { border-color: var(--primary); }
.stock-tag { color: #16a34a; background: #f0fdf4; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; margin-bottom: 10px; }
.price-box { font-size: 24px; font-weight: 700; color: var(--primary); }

.reviews-section { margin-top: 50px; background: #fff; padding: 30px; border-radius: var(--radius-md); border: 1px solid var(--border-color); }
.review-card { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
.review-card:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.review-card h4 { margin-bottom: 5px; font-size: 16px; color: #333; }

@media (max-width: 768px) {
    .product-detail-grid { grid-template-columns: 1fr; gap: 20px; }
    .main-img-box { height: 300px; }
}
</style>

<script>
function changeImg(el) {
    document.getElementById("mainImage").src = el.src;
    document.querySelectorAll('.thumb-row img').forEach(i => i.classList.remove('active-thumb'));
    el.classList.add('active-thumb');
}
</script>

<?php include 'includes/footer.php'; ?>