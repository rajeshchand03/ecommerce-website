<?php
include 'includes/header.php';
require_once 'includes/db.php';

if(!isset($_SESSION['user'])){
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit;
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$user = $_SESSION['user'];

// Fetch product details for display
$stmt = $conn->prepare("SELECT title FROM products WHERE id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();

if(!$prod){
    echo "<div class='container section-padding'><h2>Product not found.</h2></div>";
    include 'includes/footer.php';
    exit;
}

if(isset($_POST['submit_review'])){
    $rating = intval($_POST['rating']);
    $comment = htmlspecialchars($_POST['comment']);

    $q = $conn->prepare("INSERT INTO reviews (product_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
    $q->bind_param("isis", $product_id, $user, $rating, $comment);
    if($q->execute()){
        echo "<script>alert('Review added successfully!'); window.location.href='product.php?id=$product_id';</script>";
    } else {
        echo "<script>alert('Error adding review');</script>";
    }
}
?>

<style>
.review-container{
    max-width:600px;
    margin:50px auto;
    padding:25px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}
.review-container h2{ margin-bottom:20px; color:var(--primary); }
.review-container .form-group{ margin-bottom: 15px; }
.review-container label{ display:block; margin-bottom: 5px; font-weight: 500; }
.review-container select, .review-container textarea{
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-family: inherit;
}
.review-container textarea{ height: 120px; resize: none; }
.review-container button{
    width: 100%;
    padding: 12px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}
.review-container button:hover{ background: #111; }
</style>

<div class="container section-padding">
    <div class="review-container">
        <h2>Write a Review</h2>
        <p style="margin-bottom: 20px;">Product: <strong><?php echo htmlspecialchars($prod['title']); ?></strong></p>
        
        <form method="POST">
            <div class="form-group">
                <label>Rating (1 to 5 stars)</label>
                <select name="rating" required>
                    <option value="5">⭐⭐⭐⭐⭐ (5/5) Excellent</option>
                    <option value="4">⭐⭐⭐⭐ (4/5) Very Good</option>
                    <option value="3">⭐⭐⭐ (3/5) Average</option>
                    <option value="2">⭐⭐ (2/5) Poor</option>
                    <option value="1">⭐ (1/5) Very Poor</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="comment" placeholder="Tell us what you liked or disliked about this product..." required></textarea>
            </div>
            
            <button type="submit" name="submit_review">Submit Review</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
