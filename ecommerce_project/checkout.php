<?php
require_once 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    echo "<script>window.location.href='login.php?redirect=checkout.php';</script>";
    exit;
}

if(empty($_SESSION['cart'])){
    echo "<script>window.location.href='cart.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$user_res = $conn->query("SELECT name, phone, address FROM users WHERE id=$user_id");
$user = $user_res->fetch_assoc();

// Calculate total for summary
$total = 0;
foreach($_SESSION['cart'] as $id => $qty) {
    $p_res = $conn->query("SELECT price FROM products WHERE id=$id");
    if($p = $p_res->fetch_assoc()) {
        $total += $p['price'] * $qty;
    }
}
?>

<div class="container section-padding">
    <div class="checkout-container">
        <!-- Shipping Form -->
        <div class="checkout-form-panel">
            <h2 class="mb-4">Shipping Information</h2>
            <p class="text-muted mb-8">Please fill in your delivery details below.</p>
            
            <form method="post" action="place_order.php" id="checkoutForm">
                <div class="form-group mb-4">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Enter your full name" required>
                </div>

                <div class="form-row mb-4">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="e.g. +91 9876543210" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="yourname@example.com" readonly style="background: var(--bg-light); cursor: not-allowed;">
                    </div>
                </div>

                <div class="form-group mb-8">
                    <label>Delivery Address</label>
                    <textarea name="address" rows="4" placeholder="Enter your complete delivery address" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <h2 class="mb-4">Payment Method</h2>
                <div class="payment-options">
                    <label class="payment-card active">
                        <input type="radio" name="payment" value="COD" checked>
                        <div class="payment-info">
                            <i class="fa-solid fa-truck-fast"></i>
                            <div>
                                <strong>Cash on Delivery (COD)</strong>
                                <p>Pay when you receive the product.</p>
                            </div>
                        </div>
                    </label>

                    <label class="payment-card">
                        <input type="radio" name="payment" value="ONLINE">
                        <div class="payment-info">
                            <i class="fa-solid fa-credit-card"></i>
                            <div>
                                <strong>Online Payment</strong>
                                <p>Pay securely via Khalti / eSewa / Card.</p>
                            </div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-8" style="width: 100%; padding: 18px; font-size: 18px;">
                    Place Order Now <i class="fa-solid fa-check-circle ml-2"></i>
                </button>
            </form>
        </div>

        <!-- Order Summary Sticky -->
        <div class="checkout-summary-panel">
            <div class="summary-box">
                <h3>Order Summary</h3>
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border-color);">
                
                <div class="order-items-scroll">
                    <?php 
                    foreach($_SESSION['cart'] as $id => $qty): 
                        $p_res = $conn->query("SELECT title, price, image1 FROM products WHERE id=$id");
                        $p = $p_res->fetch_assoc();
                    ?>
                    <div class="summary-item">
                        <img src="uploads/<?php echo $p['image1']; ?>" alt="p">
                        <div class="item-detail">
                            <h6><?php echo htmlspecialchars($p['title']); ?></h6>
                            <span>Qty: <?php echo $qty; ?></span>
                        </div>
                        <div class="item-price">
                            Rs. <?php echo number_format($p['price'] * $qty, 0); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border-color);">
                
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span>Rs. <?php echo number_format($total, 2); ?></span>
                </div>
                <div class="summary-line">
                    <span>Shipping Fee</span>
                    <span style="color: #166534; font-weight: 600;">FREE</span>
                </div>
                
                <div class="summary-line total-line">
                    <span>Grand Total</span>
                    <span>Rs. <?php echo number_format($total, 2); ?></span>
                </div>

                <div class="trust-badges">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/SSL_icon.svg" height="30" alt="SSL">
                    <p>SSL Secure Checkout</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 60px;
    align-items: start;
}

.checkout-form-panel { background: white; padding: 40px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); }
.form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: var(--text-muted); }
.form-group input, .form-group textarea {
    width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none; transition: var(--transition);
}
.form-group input:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

.payment-options { display: flex; flex-direction: column; gap: 15px; }
.payment-card {
    border: 2px solid var(--border-color); padding: 15px 20px; border-radius: var(--radius-md); cursor: pointer; transition: var(--transition); display: block; position: relative;
}
.payment-card input { position: absolute; opacity: 0; }
.payment-card:has(input:checked) { border-color: var(--primary); background: rgba(99, 102, 241, 0.05); }

.payment-info { display: flex; align-items: center; gap: 15px; }
.payment-info i { font-size: 24px; color: var(--primary); }
.payment-info strong { display: block; font-size: 16px; }
.payment-info p { font-size: 13px; color: var(--text-muted); margin: 0; }

.summary-box { background: white; padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); position: sticky; top: 100px; }
.order-items-scroll { max-height: 300px; overflow-y: auto; padding-right: 10px; }
.summary-item { display: flex; gap: 15px; margin-bottom: 15px; align-items: center; }
.summary-item img { width: 50px; height: 50px; border-radius: 8px; border: 1px solid var(--border-color); }
.item-detail { flex: 1; }
.item-detail h6 { margin: 0; font-size: 14px; font-weight: 600; }
.item-detail span { font-size: 12px; color: var(--text-muted); }
.item-price { font-weight: 600; font-size: 14px; }

.summary-line { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; }
.total-line { margin-top: 20px; font-weight: 700; font-size: 20px; color: var(--primary); }

.trust-badges { margin-top: 30px; text-align: center; border-top: 1px solid var(--border-color); padding-top: 20px; }
.trust-badges p { font-size: 12px; margin-top: 5px; color: var(--text-muted); }

@media (max-width: 992px) {
    .checkout-container { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .checkout-summary-panel { order: -1; }
}
</style>

<?php include 'includes/footer.php'; ?>