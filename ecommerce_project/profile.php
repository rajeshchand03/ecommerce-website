<?php

require_once 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<style>
.profile-container{
    max-width:900px;
    margin:30px auto;
    display:grid;
    grid-template-columns:300px 1fr;
    gap:20px;
}
.profile-card{
    background:#fff;
    padding:20px;
    border-radius:8px;
    text-align:center;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
.profile-card img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
}
.profile-card h3{
    margin:10px 0;
}
.profile-actions a{
    display:block;
    padding:10px;
    margin:8px 0;
    background:#f5f5f5;
    text-decoration:none;
    border-radius:5px;
    color:#333;
}
.profile-actions a:hover{
    background:#2874f0;
    color:#fff;
}
.profile-info{
    background:#fff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
.profile-info h2{
    margin-bottom:15px;
}
.info-row{
    margin-bottom:10px;
}
.info-row span{
    font-weight:bold;
}
</style>

<div class="profile-container">

    <!-- LEFT PROFILE CARD -->
    <div class="profile-card">
        <img src="uploads/<?php echo $user['profile_pic'] ?: 'default.png'; ?>">
        <h3><?php echo htmlspecialchars($user['name']); ?></h3>
        <p><?php echo htmlspecialchars($user['email']); ?></p>

        <div class="profile-actions">
            <a href="edit_profile.php">✏️ Edit Profile</a>
            <a href="address.php">📍 Address Book</a>
            <a href="my_orders.php">📦 My Orders</a>
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>

    <!-- RIGHT DETAILS -->
    <div class="profile-info">
        <h2>Account Details</h2>

        <div class="info-row">
            <span>Name:</span> <?php echo htmlspecialchars($user['name']); ?>
        </div>

        <div class="info-row">
            <span>Email:</span> <?php echo htmlspecialchars($user['email']); ?>
        </div>

        <div class="info-row">
            <span>Phone:</span> <?php echo htmlspecialchars($user['phone']); ?>
        </div>

        <div class="info-row">
            <span>Joined On:</span> <?php echo date("d M Y", strtotime($user['created_at'])); ?>
        </div>

        <hr>

        <h3>Quick Actions</h3>
        <a href="my_orders.php">🔍 Track Orders</a><br><br>
        <a href="my_orders.php">📄 Download Invoice</a><br><br>
        <a href="my_orders.php">❌ Cancel Order</a>

    </div>

</div>

<?php include 'includes/footer.php'; ?>