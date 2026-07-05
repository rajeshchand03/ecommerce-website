    <?php
session_start();
require_once 'includes/db.php';

if(isset($_POST['add'])){
$conn->query("INSERT INTO addresses(user_id,address,city,pincode)
VALUES($_SESSION[user_id],'$_POST[address]','$_POST[city]','$_POST[pincode]')");
}
$result=$conn->query("SELECT * FROM addresses WHERE user_id=$_SESSION[user_id]");
?>