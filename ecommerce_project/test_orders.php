<?php
require 'includes/db.php';
$res = $conn->query("SELECT id, user, name FROM orders");
while($row = $res->fetch_assoc()){
    print_r($row);
}
?>
