<?php
require_once 'User.php';

class Admin extends User {
    public function addProduct($conn, $name, $price) {
        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
    }
}
?>
