<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - DoonKart</title>

<style>

.about-container{
    max-width:900px;
    margin:50px auto;
    padding:20px;
    text-align:center;
}

.about-container h1{
    color:#e91e63;
    margin-bottom:15px;
}

.about-container p{
    color:#555;
    line-height:1.6;
    margin-bottom:15px;
}

.about-box{
    display:flex;
    gap:20px;
    margin-top:30px;
    flex-wrap:wrap;
    justify-content:center;
}

.box{
    width:250px;
    padding:20px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    transition:0.3s;
}

.box:hover{
    transform:translateY(-5px);
}

.box i{
    font-size:30px;
    color:#e91e63;
    margin-bottom:10px;
}

</style>
</head>

<body>

<div class="about-container">

    <h1>About DoonKart 🛒</h1>

    <p>
        Welcome to <b>DoonKart</b>, your one-stop destination for online shopping.
        We aim to provide high-quality products at affordable prices with a smooth and user-friendly experience.
    </p>

    <p>
        Our mission is to make online shopping easy, fast, and reliable for everyone.
        Whether you are looking for electronics, fashion, or daily essentials, DoonKart has it all.
    </p>

    <p>
        We focus on customer satisfaction, secure transactions, and fast delivery services.
    </p>

    <!-- FEATURES -->
    <div class="about-box">

        <div class="box">
            <i class="fas fa-truck"></i>
            <h4>Fast Delivery</h4>
            <p>Quick and reliable delivery at your doorstep.</p>
        </div>

        <div class="box">
            <i class="fas fa-shield-alt"></i>
            <h4>Secure Payment</h4>
            <p>Your transactions are safe and protected.</p>
        </div>

        <div class="box">
            <i class="fas fa-headset"></i>
            <h4>24/7 Support</h4>
            <p>We are here to help you anytime.</p>
        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>