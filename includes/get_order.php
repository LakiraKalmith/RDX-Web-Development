<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/db.php';

$order_id = (int) $_GET['order_id'];
$user_id  = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '$user_id'";
$order = mysqli_fetch_assoc($conn->query($sql));

if (!$order) { echo 'Order not found.'; exit; }

$items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id = '$order_id'");
?>

<div class="modal-meta" style="margin-bottom:20px;">
    <p>Order #RDX<?= $order['id'] ?></p>
    <p>Placed on <?= date('F j, Y', strtotime($order['created_at'])) ?></p>
</div>

<!-- Items -->
<div>
    <?php while ($item = mysqli_fetch_assoc($items)): ?>
    <div class="detail-item">
        <div>
            <div class="detail-item-name"><?= $item['name'] ?></div>
            <div class="detail-item-qty">Qty: <?= $item['quantity'] ?></div>
        </div>
        <div class="detail-item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
    </div>
    <?php endwhile; ?>
</div>

<!-- Total -->
<div class="detail-total">
    <span>Total</span>
    <span>$<?= number_format($order['total'], 2) ?></span>
</div>

<!-- Address -->
<div class="detail-address">
    <div class="detail-address-label">Delivered To</div>
    <p>
        <strong><?= $order['full_name'] ?></strong>
        <?= $order['address'] ?><br>
        <?= $order['city'] ?><br>
        <?= $order['country'] ?>
    </p>
</div>