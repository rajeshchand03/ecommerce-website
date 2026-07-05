<?php
session_start();
require_once 'db.php';

$cartCount = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $qty){
        $cartCount += is_array($qty) ? ($qty['qty'] ?? 1) : $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DoonKart | Premium Shopping</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<!-- Announcement Bar -->
<div class="announcement-bar">
    <div class="container" style="display: flex; justify-content: center; align-items: center;">
        <span>🔥 Big Sale Offer! Up to 50% Off on Selected Items | Free Shipping on Orders Over ₹999</span>
    </div>
</div>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- Main Sticky Header -->
<header class="main-header">
    <div class="container header-container">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php" style="display: flex; align-items: center; gap: 8px;">
                <img src="assets/logo1.png" alt="DoonKart" onerror="this.src='https://via.placeholder.com/120x30?text=DoonKart'">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="desktop-only">
            <ul class="nav-links">
                <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['category']) ? 'active' : ''; ?>">Home</a></li>
                <li><a href="search.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'search.php' ? 'active' : ''; ?>">All Products</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-trigger">Categories <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        $nav_cats = $conn->query("SELECT * FROM categories");
                        if($nav_cats) {
                            while($nc = $nav_cats->fetch_assoc()):
                        ?>
                        <li><a href="index.php?category=<?php echo $nc['id']; ?>"><?php echo htmlspecialchars($nc['name']); ?></a></li>
                        <?php 
                            endwhile;
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a></li>
                <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </nav>

        <!-- Search & Actions -->
        <div class="header-right">
            <div class="search-container desktop-only">
                <form action="search.php" method="GET">
                    <input type="text" name="q" placeholder="Search products..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="action-item desktop-only" title="My Profile"><i class="fa-regular fa-user"></i></a>
            <?php else: ?>
                <a href="login.php" class="action-item desktop-only" title="Login"><i class="fa-regular fa-user"></i></a>
            <?php endif; ?>

            <a href="cart.php" class="action-item" title="Shopping Cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="badge"><?php echo $cartCount; ?></span>
            </a>

            <!-- Mobile Menu -->
            <div class="menu-btn mobile-only" onclick="openSidebar()" style="cursor:pointer; font-size: 20px;">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search Row -->
    <div class="container mobile-only" style="margin-top: 15px;">
        <div class="search-container" style="width: 100%;">
            <form action="search.php" method="GET">
                <input type="text" name="q" placeholder="Search products..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
</header>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3 class="sidebar-title"><i class="fa-solid fa-layer-group"></i> DoonKart</h3>
        <div class="close-btn" onclick="closeSidebar()">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="sidebar-user">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-info">
                <span>Welcome Back</span>
                <strong>User Profile</strong>
            </div>
        <?php else: ?>
            <div class="user-avatar">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <div class="user-info">
                <span>Guest</span>
                <strong><a href="login.php">Login to continue</a></strong>
            </div>
        <?php endif; ?>
    </div>
    <nav class="sidebar-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="search.php"><i class="fa-solid fa-bag-shopping"></i> Products</a>
        <a href="cart.php" class="cart-link">
            <i class="fa-solid fa-cart-shopping"></i> Cart 
            <?php if($cartCount > 0): ?>
                <span class="sidebar-badge"><?php echo $cartCount; ?></span>
            <?php endif; ?>
        </a>
        
        <div class="sidebar-divider"></div>
        <h4 class="sidebar-subtitle">Categories</h4>
        <?php
        $sidebar_cats = $conn->query("SELECT * FROM categories");
        if($sidebar_cats) {
            while($sc = $sidebar_cats->fetch_assoc()):
        ?>
            <a href="index.php?category=<?php echo $sc['id']; ?>"><i class="fa-solid fa-circle-dot" style="font-size: 8px;"></i> <?php echo htmlspecialchars($sc['name']); ?></a>
        <?php 
            endwhile;
        }
        ?>

        <div class="sidebar-divider"></div>
        <h4 class="sidebar-subtitle">Account</h4>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php"><i class="fa-solid fa-id-badge"></i> Profile</a>
            <a href="my_orders.php"><i class="fa-solid fa-box-open"></i> My Orders</a>
            <a href="logout.php" class="logout-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        <?php else: ?>
            <a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <a href="register.php"><i class="fa-solid fa-user-plus"></i> Sign Up</a>
        <?php endif; ?>
    </nav>
</aside>

<main>

<style>
@media (min-width: 993px) { .mobile-only { display: none !important; } }
@media (max-width: 992px) { .mobile-only { display: block !important; } }
</style>

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('active');
    document.getElementById('overlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('active');
    document.getElementById('overlay').classList.remove('active');
    document.body.style.overflow = 'auto';
}
</script>
