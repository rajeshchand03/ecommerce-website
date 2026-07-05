<?php
require_once 'includes/db.php';

// Create categories table
$sql1 = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
)";

// Add category_id to products
$sql2 = "ALTER TABLE products ADD COLUMN category_id INT AFTER title";

if (mysqli_query($conn, $sql1)) {
    echo "Table 'categories' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql2)) {
    echo "Column 'category_id' added to 'products' successfully.<br>";
} else {
    echo "Error adding column: " . mysqli_error($conn) . " (Might already exist)<br>";
}
?>
