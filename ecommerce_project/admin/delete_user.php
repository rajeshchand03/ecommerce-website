<?php
require_once 'auth.php';
require_once '../includes/db.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    
    // Check if user has orders, maybe we shouldn't delete users with orders, or we can just delete them.
    // For now, let's just delete the user.
    $conn->query("DELETE FROM users WHERE id = $id");
}
header("Location: users.php");
exit;
?>
