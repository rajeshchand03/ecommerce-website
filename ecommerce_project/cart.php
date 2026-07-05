<?php
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
?>

<div class="container section-padding">
    <h2 class="mb-8"><i class="fa-solid fa-bag-shopping mr-2"></i> Your Shopping Cart</h2>

    <div class="cart-layout">
        <!-- Cart Items -->
        <div class="cart-items-panel">
            <?php
            $total = 0;
            if(empty($cart)):
                echo "
                <div class='empty-cart-state text-center'>
                    <i class='fa-solid fa-cart-shopping' style='font-size: 64px; color: var(--border-color); margin-bottom: 20px;'></i>
                    <h3>Your cart is empty</h3>
                    <p class='mb-8'>Looks like you haven't added anything to your cart yet.</p>
                    <a href='index.php' class='btn btn-primary'>Start Shopping</a>
                </div>";
            else:
                foreach($cart as $id => $qty):
                    $p_stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
                    $p_stmt->bind_param("i", $id);
                    $p_stmt->execute();
                    $p = $p_stmt->get_result()->fetch_assoc();
                    
                    if(!$p) continue;

                    $subtotal = $p['price'] * $qty;
                    $total += $subtotal;
            ?>
            <div class="cart-card">
                <div class="cart-item-img">
                    <img src="uploads/<?php echo $p['image1']; ?>" alt="Product">
                </div>
                <div class="cart-item-info">
                    <div class="flex justify-between">
                        <h4><?php echo htmlspecialchars($p['title']); ?></h4>
                        <a href="update_cart.php?id=<?php echo $id; ?>&action=remove" class="remove-link" title="Remove Item">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </div>
                    <p class="cart-item-price">Rs. <?php echo number_format($p['price'], 2); ?></p>
                    
                    <div class="flex justify-between items-center mt-4">
                        <div class="qty-selector-sm">
                            <a href="update_cart.php?id=<?php echo $id; ?>&action=dec" class="qty-btn">-</a>
                            <span><?php echo $qty; ?></span>
                            <a href="update_cart.php?id=<?php echo $id; ?>&action=inc" class="qty-btn">+</a>
                        </div>
                        <span class="subtotal-text">Subtotal: <strong>Rs. <?php echo number_format($subtotal, 2); ?></strong></span>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>

        <!-- Order Summary -->
        <?php if(!empty($cart)): ?>
        <div class="cart-summary-panel">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid var(--border-color);">
                
                <div class="flex justify-between mb-4">
                    <span>Subtotal</span>
                    <span>Rs. <?php echo number_format($total, 2); ?></span>
                </div>
                <div class="flex justify-between mb-4">
                    <span>Shipping</span>
                    <span style="color: #166534; font-weight: 600;">FREE</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span>Tax (GST)</span>
                    <span>Rs. 0.00</span>
                </div>
                
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid var(--border-color);">
                
                <div class="flex justify-between items-center mb-8">
                    <span style="font-weight: 700; font-size: 18px;">Total</span>
                    <span style="font-weight: 700; font-size: 22px; color: var(--primary);">Rs. <?php echo number_format($total, 2); ?></span>
                </div>

                <a href="checkout.php" class="btn btn-primary" style="width: 100%; padding: 15px;">
                    Proceed to Checkout <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
                
                <p style="font-size: 12px; color: var(--text-muted); text-align: center; margin-top: 15px;">
                    Secure Checkout Guaranteed <i class="fa-solid fa-shield-halved"></i>
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
    align-items: start;
}

.cart-items-panel {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.cart-card {
    background: white;
    border-radius: var(--radius-md);
    padding: 20px;
    border: 1px solid var(--border-color);
    display: flex;
    gap: 20px;
    transition: var(--transition);
}
.cart-card:hover { box-shadow: var(--shadow-md); border-color: var(--primary); }

.cart-item-img {
    width: 120px;
    height: 120px;
    background: #fff;
    border-radius: var(--radius-sm);
    overflow: hidden;
    border: 1px solid var(--border-color);
}
.cart-item-img img { width: 100%; height: 100%; object-fit: contain; }

.cart-item-info { flex: 1; }
.cart-item-info h4 { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
.cart-item-price { color: var(--text-muted); font-weight: 500; }

.qty-selector-sm {
    display: flex;
    align-items: center;
    gap: 15px;
    background: var(--bg-light);
    padding: 5px 12px;
    border-radius: var(--radius-sm);
}
.qty-btn { font-size: 18px; font-weight: 700; color: var(--primary); }
.qty-btn:hover { transform: scale(1.2); }

.remove-link { color: #ef4444; font-size: 18px; transition: var(--transition); }
.remove-link:hover { transform: scale(1.1); color: #b91c1c; }

.summary-card {
    background: white;
    padding: 25px;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    position: sticky;
    top: 100px;
}

.subtotal-text { font-size: 14px; color: var(--text-muted); }

.empty-cart-state {
    padding: 80px 20px;
    background: white;
    border-radius: var(--radius-lg);
    border: 2px dashed var(--border-color);
}

@media (max-width: 992px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-summary-panel { order: -1; }
}
</style>

<?php include 'includes/footer.php'; ?>