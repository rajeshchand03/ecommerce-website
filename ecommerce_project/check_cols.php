<?php
require_once 'includes/db.php';
$res = mysqli_query($conn, "SHOW COLUMNS FROM products");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
