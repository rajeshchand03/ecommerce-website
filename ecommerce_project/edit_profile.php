<?php
require_once 'includes/db.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

if(isset($_POST['update'])){

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    // IMAGE UPLOAD
    if(!empty($_FILES['profile_pic']['name'])){
        $allowed = ['image/jpeg','image/png','image/webp'];

        if(!in_array($_FILES['profile_pic']['type'],$allowed)){
            die("Invalid image type");
        }

        $imgName = time().'_'.$_FILES['profile_pic']['name'];
        move_uploaded_file(
            $_FILES['profile_pic']['tmp_name'],
            "uploads/".$imgName
        );

        $stmt = $conn->prepare(
            "UPDATE users SET name=?, phone=?, profile_pic=? WHERE id=?"
        );
        $stmt->bind_param("sssi",$name,$phone,$imgName,$user_id);

    }else{

        $stmt = $conn->prepare(
            "UPDATE users SET name=?, phone=? WHERE id=?"
        );
        $stmt->bind_param("ssi",$name,$phone,$user_id);
    }

    $stmt->execute();
    header("Location: profile.php");
    exit;
}
?>

<style>
.edit-box{
    max-width:500px;
    margin:40px auto;
    background:#fff;
    padding:20px;
    border-radius:8px;
}
.edit-box input{
    width:100%;
    padding:10px;
    margin-bottom:10px;
}
</style>

<div class="edit-box">
<h2>Edit Profile</h2>

<form method="post" enctype="multipart/form-data">
    Name:
    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

    Phone:
    <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

    Profile Picture:
    <input type="file" name="profile_pic">

    <button name="update">Update Profile</button>
</form>
</div>

<?php include 'includes/footer.php'; ?>