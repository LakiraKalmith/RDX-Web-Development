<?php 
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id    = $_SESSION['user_id'];
$data       = json_decode(file_get_contents('php://input'), true);
$action     = $data['action']     ?? ''; // this shows js if its update, remove or add
$product_id = (int) $data['product_id'];
$quantity   = (int) ($data['quantity'] ?? 1);

if ($action == 'add') {
    $sql = "INSERT INTO cart (user_id, product_id, quantity)
            VALUES ($user_id, $product_id, $quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + $quantity";
    $conn->query($sql);
}
 else if ($action == 'update') {
    $sql = "UPDATE cart SET quantity = $quantity
            WHERE user_id = $user_id AND product_id = $product_id";
    $conn->query($sql);
}
else if ($action == 'remove') {
    $sql = "DELETE FROM cart
            WHERE user_id = $user_id AND product_id = $product_id";
    $conn->query($sql);
}

?>