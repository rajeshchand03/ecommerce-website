<?php include 'includes/header.php'; ?>

<!-- ================= HERO SECTION ================= -->
<div class="hero-slider-container">
    <section class="hero-section">
        <!-- Slide 1 -->
        <div class="hero-slide active" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.95) 35%, rgba(15, 23, 42, 0.45) 100%), url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=80');">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-badge">🔥 Big Sale Offer</span>
                    <h1>Upgrade Your Style <br><span style="color: var(--primary);">Up to 50% Off</span></h1>
                    <p>Discover our latest collection of premium products designed for the modern era. Quality meets affordability.</p>
                    <div class="flex gap-4">
                        <a href="search.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                            Shop Now <i class="fa-solid fa-bag-shopping"></i>
                        </a>
                        <a href="search.php" class="btn btn-outline-mock" style="display: inline-flex; align-items: center; gap: 8px;">
                            Explore Collection <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div class="hero-slide" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.95) 35%, rgba(15, 23, 42, 0.45) 100%), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80');">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-badge">✨ New Season</span>
                    <h1>Exclusive Trends <br><span style="color: var(--primary);">Just Arrived</span></h1>
                    <p>Explore our new arrivals and find the perfect look for any occasion. Shop the hottest trends today.</p>
                    <div class="flex gap-4">
                        <a href="search.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                            Shop Now <i class="fa-solid fa-bag-shopping"></i>
                        </a>
                        <a href="search.php" class="btn btn-outline-mock" style="display: inline-flex; align-items: center; gap: 8px;">
                            Explore Collection <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div class="hero-slide" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.95) 35%, rgba(15, 23, 42, 0.45) 100%), url('https://images.unsplash.com/photo-1472851294608-062f824d29cc?auto=format&fit=crop&w=1400&q=80');">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-badge">⚡ Flash Deal</span>
                    <h1>Tech & Gadgets <br><span style="color: var(--primary);">Lowest Prices</span></h1>
                    <p>Upgrade your daily routine with state of the art electronics and tech accessories. Grab them before they are gone!</p>
                    <div class="flex gap-4">
                        <a href="search.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                            Shop Now <i class="fa-solid fa-bag-shopping"></i>
                        </a>
                        <a href="search.php" class="btn btn-outline-mock" style="display: inline-flex; align-items: center; gap: 8px;">
                            Explore Collection <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slider Controls -->
        <button class="slider-arrow prev-arrow" style="z-index: 10;"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-arrow next-arrow" style="z-index: 10;"><i class="fa-solid fa-chevron-right"></i></button>
        
        <!-- Slider Dots -->
        <div class="slider-dots" style="z-index: 10;">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>
</div>

<!-- ================= FEATURES BAR ================= -->
<section class="features-bar-section">
    <div class="container">
        <div class="features-bar">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="feature-text">
                    <h4>Free Shipping</h4>
                    <p>On orders over 999</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div class="feature-text">
                    <h4>Easy Returns</h4>
                    <p>30-day return policy</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="feature-text">
                    <h4>Secure Payment</h4>
                    <p>100% secure checkout</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div class="feature-text">
                    <h4>24/7 Support</h4>
                    <p>We're here to help</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CATEGORIES SECTION ================= -->
<section style="padding: 20px 0; background: #fff; border-bottom: 1px solid #eee; margin-top: 40px;">
    <div class="container">
        <div class="flex gap-4 overflow-x-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="index.php" class="btn <?php echo !isset($_GET['category']) ? 'btn-primary' : 'btn-outline'; ?>" style="white-space: nowrap; padding: 8px 20px; border-radius: 20px; font-size: 14px;">All</a>
            <?php
            $cats = $conn->query("SELECT * FROM categories");
            if($cats) {
                while($c = $cats->fetch_assoc()):
                    $isActive = (isset($_GET['category']) && $_GET['category'] == $c['id']);
            ?>
            <a href="index.php?category=<?php echo $c['id']; ?>" 
               class="btn <?php echo $isActive ? 'btn-primary' : 'btn-outline'; ?>" 
               style="white-space: nowrap; padding: 8px 20px; border-radius: 20px; font-size: 14px;">
                <?php echo htmlspecialchars($c['name']); ?>
            </a>
            <?php 
                endwhile;
            }
            ?>
        </div>
    </div>
</section>

<!-- ================= PRODUCTS SECTION ================= -->
<section class="section-padding" style="padding-top: 40px;">
    <div class="container">
        <div class="flex justify-between items-center mb-8">
            <?php
            $cat_title = "Latest Products";
            $where = "";
            if(isset($_GET['category'])){
                $cat_id = intval($_GET['category']);
                $c_res = $conn->query("SELECT name FROM categories WHERE id = $cat_id");
                if($c_res && $c_row = $c_res->fetch_assoc()){
                    $cat_title = $c_row['name'];
                }
                $where = "WHERE category_id = $cat_id";
            }
            ?>
            <h2 style="font-size: 24px; font-weight: 700;"><?php echo $cat_title; ?></h2>
            <a href="search.php" style="color: var(--primary); font-weight: 600; font-size: 14px;">View All</a>
        </div>

        <div class="product-grid">
            <?php
            $result = $conn->query("SELECT * FROM products $where ORDER BY id DESC LIMIT 20");
            if($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()):
            ?>
            <div class="product-card">
                <div class="product-img">
                    <a href="product.php?id=<?php echo $row['id']; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($row['image1'] ?? $row['image']); ?>" alt="Product" onerror="this.src='https://via.placeholder.com/300x300?text=Product'">
                    </a>
                </div>
                <div class="product-info">
                    <span class="product-cat">
                        <?php 
                        // Fetch category name
                        $cname = "Product";
                        if(!empty($row['category_id'])){
                            $cr = $conn->query("SELECT name FROM categories WHERE id = ".$row['category_id']);
                            if($cr && $cr->num_rows > 0) {
                                $cname = $cr->fetch_assoc()['name'];
                            }
                        }
                        echo htmlspecialchars($cname);
                        ?>
                    </span>
                    <h4><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title'] ?? $row['product_name']); ?></a></h4>
                    <div class="flex justify-between items-center mt-4">
                        <span class="product-price">Rs. <?php echo number_format($row['price'], 0); ?></span>
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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
                echo "<p class='text-center' style='grid-column: 1/-1; padding: 40px; color: #6b7280;'>No products found in this category.</p>";
            endif;
            ?>
        </div>
    </div>
</section>

<style>
/* Modern Product Card Styles */
.product-cat { font-size: 12px; color: var(--primary); font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px; letter-spacing: 0.5px; }
.product-info h4 a { color: inherit; text-decoration: none; }
.product-info h4 a:hover { color: var(--primary); }
.add-to-cart-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; font-size: 16px; box-shadow: 0 4px 10px rgba(15,118,110,0.3);}
.add-to-cart-icon:hover { transform: scale(1.1) rotate(90deg); box-shadow: 0 6px 15px rgba(15,118,110,0.5); }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
<script>
    VanillaTilt.init(document.querySelectorAll(".product-card"), {
        max: 10,
        speed: 400,
        glare: true,
        "max-glare": 0.2,
    });

    // Hero Slider Functionality
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    const prevBtn = document.querySelector('.prev-arrow');
    const nextBtn = document.querySelector('.next-arrow');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        if (slides.length === 0) return;
        
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;
        
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetInterval();
        });
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetInterval();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetInterval();
        });
    });

    function startInterval() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    if (slides.length > 0) {
        startInterval();
    }
</script>

<?php include 'includes/footer.php'; ?>