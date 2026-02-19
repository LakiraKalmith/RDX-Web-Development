<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';

include __DIR__ . '/includes/header.php';

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn, "
    SELECT cart.quantity, products.name, products.price, products.image
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = '$user_id'
");

$cart_rows = [];
$total = 0;
while ($row = mysqli_fetch_assoc($cart_items)) {
    $cart_rows[] = $row;
    $total += $row['price'] * $row['quantity'];
}

// Clear the cart from DB now that payment is done
mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

// Get shipping address from session
$shipping = $_SESSION['shipping'] ?? null;

// Clear shipping from session too
unset($_SESSION['shipping']);

// Get user info
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'"));

// Make a simple order number (date + user id)
$order_number = 'RDX' . date('ymd') . $user_id;
?>

<body>
<?php include 'includes/nav.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');

    .success-page {
        max-width: 720px;
        margin: 0 auto;
        padding: 80px 24px 120px;
    }

    /* ── Tick animation ── */
    .success-icon {
        width: 80px; height: 80px;
        border: 1px solid #c5ab80;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 36px;
        animation: popIn .5s cubic-bezier(.175,.885,.32,1.275) both;
    }
    .success-icon i { font-size: 32px; color: #c5ab80; }

    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }

    /* ── Header ── */
    .success-header { text-align: center; margin-bottom: 56px; animation: fadeUp .5s .1s ease both; }

    .success-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 52px; font-weight: 300;
        color: #c5ab80; letter-spacing: 6px;
        text-transform: uppercase; margin-bottom: 12px;
    }

    .success-header p { color: #666; font-size: 13px; letter-spacing: 1px; }

    .order-number {
        display: inline-block;
        border: 1px solid #2a2a2a;
        padding: 8px 20px;
        font-size: 11px; letter-spacing: 3px;
        color: #c5ab80; text-transform: uppercase;
        margin-top: 16px;
    }

    /* ── Cards ── */
    .card {
        background: #161616;
        border: 1px solid #2a2a2a;
        padding: 32px;
        margin-bottom: 20px;
        animation: fadeUp .5s ease both;
    }
    .card:nth-child(1) { animation-delay: .15s; }
    .card:nth-child(2) { animation-delay: .22s; }
    .card:nth-child(3) { animation-delay: .29s; }

    .card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px; color: #c5ab80;
        letter-spacing: 3px; text-transform: uppercase;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #2a2a2a;
    }

    /* ── Order items ── */
    .order-item {
        display: flex; gap: 16px;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #1e1e1e;
    }
    .order-item:last-of-type { border-bottom: none; }

    .order-item img {
        width: 64px; height: 64px;
        object-fit: cover;
        border: 1px solid #2a2a2a;
        flex-shrink: 0;
    }

    .order-item-info { flex: 1; }
    .order-item-info .name { font-size: 14px; font-weight: 500; margin-bottom: 4px; }
    .order-item-info .qty { font-size: 11px; color: #666; letter-spacing: 1px; }
    .order-item-price { font-size: 14px; color: #c5ab80; font-weight: 600; }

    .order-total-row {
        display: flex; justify-content: space-between;
        padding-top: 20px; margin-top: 4px;
        border-top: 1px solid #2a2a2a;
    }
    .order-total-row span {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px; color: #c5ab80;
    }

    /* ── Address ── */
    .address-text { font-size: 13px; color: #aaa; line-height: 2; }
    .address-text strong { color: #e8e0d0; display: block; font-size: 15px; margin-bottom: 4px; }

    /* ── Button ── */
    .btn-shop {
        display: block; width: 100%;
        padding: 18px; background: #c5ab80; color: #000;
        border: none; cursor: pointer; margin-top: 32px;
        font-family: 'Poppins', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: 3px; text-transform: uppercase;
        text-align: center; text-decoration: none;
        transition: background .2s;
        animation: fadeUp .5s .35s ease both;
    }
    .btn-shop:hover { background: #d9c49e; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
</style>

<div class="success-page">

    <!-- Tick -->
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>

    <!-- Header -->
    <div class="success-header">
        <h1>Order Confirmed</h1>
        <p>Thank you, <?= $user['first_name'] ?>. Your order has been received.</p>
        <div class="order-number"># <?= $order_number ?></div>
    </div>

    <!-- What they ordered -->
    <?php if (!empty($cart_rows)): ?>
    <div class="card">
        <div class="card-title">Items Ordered</div>
        <?php foreach ($cart_rows as $item): ?>
        <div class="order-item">
            <img src="/RDX/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
            <div class="order-item-info">
                <div class="name"><?= $item['name'] ?></div>
                <div class="qty">Qty: <?= $item['quantity'] ?></div>
            </div>
            <div class="order-item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
        </div>
        <?php endforeach; ?>
        <div class="order-total-row">
            <span>Total Paid</span>
            <span>$<?= number_format($total, 2) ?></span>
        </div>
    </div>
    <?php endif; ?>

    <!-- Shipping address -->
    <?php if ($shipping): ?>
    <div class="card">
        <div class="card-title">Delivering To</div>
        <div class="address-text">
            <strong><?= $shipping['full_name'] ?></strong>
            <?= $shipping['address_line1'] ?><br>
            <?php if (!empty($shipping['address_line2'])) echo $shipping['address_line2'] . '<br>'; ?>
            <?= $shipping['city'] ?>, <?= $shipping['state'] ?> <?= $shipping['zip_code'] ?><br>
            <?= $shipping['country'] ?>
        </div>
    </div>
    <?php endif; ?>

    <a href="/RDX/shop.php" class="btn-shop">Continue Shopping</a>

</div>

<!-- Clear localStorage cart too -->
<script>
    localStorage.removeItem('rdx_cart');
</script>

<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
