<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - DoonKart</title>

<style>

.contact-container{
    max-width:600px;
    margin:50px auto;
    padding:25px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.contact-container h2{
    text-align:center;
    margin-bottom:20px;
    color:#e91e63;
}

.contact-container input,
.contact-container textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:6px;
}

.contact-container textarea{
    resize:none;
    height:120px;
}

.contact-container button{
    width:100%;
    padding:10px;
    background:#111;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.contact-container button:hover{
    background:#e91e63;
}

.success{
    color:green;
    text-align:center;
}

</style>
</head>

<body>

<div class="contact-container">

    <h2>Contact DoonKart 📞</h2>

    <?php
    if(isset($_POST['submit'])){
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        echo "<p class='success'>Thank you $name! We will contact you soon.</p>";
    }
    ?>

    <form method="post">
        <input type="text" name="name" placeholder="Your Name" required>

        <input type="email" name="email" placeholder="Your Email" required>

        <textarea name="message" placeholder="Your Message" required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>