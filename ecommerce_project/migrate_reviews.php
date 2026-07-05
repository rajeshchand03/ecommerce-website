<?php
require_once 'includes/db.php';

$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_name VARCHAR(100),
    rating INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'reviews' created successfully.\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}
?>
