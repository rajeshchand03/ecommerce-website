<?php
include 'includes/header.php';

// Get Filter Parameters
$keyword = $_GET['q'] ?? '';
$cat_id = isset($_GET['category']) ? intval($_GET['category']) : '';
$min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? intval($_GET['min_price']) : '';
$max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? intval($_GET['max_price']) : '';
$sort = $_GET['sort'] ?? 'newest';

// Build Query dynamically
$query = "SELECT * FROM products WHERE 1=1";

if(!empty($keyword)) {
    $kw = $conn->real_escape_string($keyword);
    $query .= " AND (title LIKE '%$kw%' OR description LIKE '%$kw%')";
}
if(!empty($cat_id)) {
    $query .= " AND category_id = $cat_id";
}
if($min_price !== '') {
    $query .= " AND price >= $min_price";
}
if($max_price !== '') {
    $query .= " AND price <= $max_price";
}

// Sorting logic
if($sort == 'price_low') {
    $query .= " ORDER BY price ASC";
} elseif($sort == 'price_high') {
    $query .= " ORDER BY price DESC";
} else {
    $query .= " ORDER BY id DESC"; // newest
}

$res = $conn->query($query);
?>

<div class="container section-padding" style="display: flex; gap: 30px; flex-wrap: wrap;">
    
    <!-- Filter Sidebar -->
    <aside class="filter-sidebar" style="flex: 1; min-width: 250px; max-width: 300px; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); align-self: start;">
        <h3 style="font-size: 18px; margin-bottom: 20px; color: var(--heading-color); border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
            <i class="fa-solid fa-sliders"></i> Filters
        </h3>
        
        <form method="GET" action="search.php">
            <!-- Keyword -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563;">Search Keyword</label>
                <input type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="e.g. T-Shirt" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none;">
            </div>

            <!-- Category -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563;">Category</label>
                <select name="category" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; background: #fff;">
                    <option value="">All Categories</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM categories");
                    while($c = $cats->fetch_assoc()){
                        $selected = ($c['id'] == $cat_id) ? 'selected' : '';
                        echo "<option value='{$c['id']}' $selected>".htmlspecialchars($c['name'])."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Price Range -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563;">Price Range (Rs.)</label>
                <div style="display: flex; gap: 10px;">
                    <input type="number" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>" placeholder="Min" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none;">
                    <span style="align-self: center;">-</span>
                    <input type="number" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>" placeholder="Max" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none;">
                </div>
            </div>

            <!-- Sort By -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #4b5563;">Sort By</label>
                <select name="sort" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; background: #fff;">
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest First</option>
                    <option value="price_low" <?php if($sort=='price_low') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="price_high" <?php if($sort=='price_high') echo 'selected'; ?>>Price: High to Low</option>
                </select>
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.3s;">Apply Filters</button>
            <a href="search.php" style="display: block; text-align: center; margin-top: 10px; font-size: 13px; color: #6b7280; text-decoration: none;">Clear Filters</a>
        </form>
    </aside>

    <!-- Results Area -->
    <div class="search-results" style="flex: 3; min-width: 300px;">
        <div class="search-header mb-8" style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <h2 style="font-size: 22px; color: var(--heading-color);">
                <?php if($keyword || $cat_id || $min_price !== '' || $max_price !== ''): ?>
                    <i class="fa-solid fa-list-check mr-2"></i> Filtered Results (<span style="color: var(--primary);"><?php echo $res->num_rows; ?></span> found)
                <?php else: ?>
                    <i class="fa-solid fa-bag-shopping mr-2"></i> All Products (<span style="color: var(--primary);"><?php echo $res->num_rows; ?></span> found)
                <?php endif; ?>
            </h2>
        </div>

        <div class="product-grid">
            <?php
            if($res && $res->num_rows > 0):
                while($p = $res->fetch_assoc()):
            ?>
            <div class="product-card">
                <div class="product-img">
                    <a href="product.php?id=<?php echo $p['id']; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($p['image1'] ?? $p['image']); ?>" alt="Product" onerror="this.src='https://via.placeholder.com/300x300?text=Product'">
                    </a>
                </div>
                <div class="product-info">
                    <span class="product-cat">
                        <?php 
                        // Fetch category name
                        $cname = "Product";
                        if(!empty($p['category_id'])){
                            $cr = $conn->query("SELECT name FROM categories WHERE id = ".$p['category_id']);
                            if($cr && $cr->num_rows > 0) {
                                $cname = $cr->fetch_assoc()['name'];
                            }
                        }
                        echo htmlspecialchars($cname);
                        ?>
                    </span>
                    <h4><a href="product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title'] ?? $p['product_name']); ?></a></h4>
                    <div class="flex justify-between items-center mt-4">
                        <span class="product-price">Rs. <?php echo number_format($p['price'], 0); ?></span>
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="add-to-cart-icon" title="Add to Cart">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            else:
                echo "
                <div class='empty-search text-center' style='grid-column: 1/-1; padding: 60px; background: #fff; border-radius: 12px; border: 1px solid #f3f4f6;'>
                    <i class='fa-solid fa-box-open' style='font-size: 64px; color: #d1d5db; margin-bottom: 20px;'></i>
                    <h3 style='color: var(--heading-color);'>Oops! No products found</h3>
                    <p class='text-muted'>Try adjusting your filters or search keywords.</p>
                </div>";
            endif;
            ?>
        </div>
    </div>
</div>

<style>
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 25px;
}
.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f3f4f6;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}
.product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-color: var(--primary); }
.product-img { height: 260px; overflow: hidden; background: #f9fafb; display: flex; align-items: center; justify-content: center; }
.product-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
.product-card:hover .product-img img { transform: scale(1.05); }
.product-info { padding: 20px; }
.product-cat { font-size: 12px; color: var(--primary); font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px; letter-spacing: 0.5px; }
.product-info h4 { font-size: 16px; font-weight: 700; color: var(--heading-color); line-height: 1.4; margin-bottom: 10px;}
.product-info h4 a { color: inherit; text-decoration: none; }
.product-info h4 a:hover { color: var(--primary); }
.product-price { font-size: 18px; font-weight: 700; color: #111827; }
.add-to-cart-icon { width: 36px; height: 36px; background: rgba(15, 118, 110, 0.1); color: var(--primary); border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 14px;}
.add-to-cart-icon:hover { background: var(--primary); color: white; transform: rotate(90deg); }
</style>

<?php include 'includes/footer.php'; ?>