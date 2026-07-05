<?php
require_once '../includes/db.php';

$id = intval($_GET['id']);
$conn->query("DELETE FROM orders WHERE id=$id");

header("Location: orders.php");
exit;