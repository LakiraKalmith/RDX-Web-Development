<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';

include __DIR__ . '/includes/header.php';

$user_id = $_SESSION['user_id'];

// Get cart items BEFORE clearing
$cart_items = mysqli_query($conn, "
    SELECT cart.quantity, cart.product_id, products.name, products.price, products.image
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

// Get shipping from session
$shipping = $_SESSION['shipping'] ?? null;

// ── Save order to DB ──────────────────────────────────────
if (!empty($cart_rows)) {
    $full_name = $shipping['full_name'] ?? '';
    $address   = $shipping['address_line1'] ?? '';
    $city      = $shipping['city'] ?? '';
    $country   = $shipping['country'] ?? '';

    // Insert into orders table
    mysqli_query($conn, "
        INSERT INTO orders (user_id, total, status, full_name, address, city, country)
        VALUES ('$user_id', '$total', 'processing', '$full_name', '$address', '$city', '$country')
    ");

    // Get the order id we just created
    $order_id = mysqli_insert_id($conn);

    // Insert each item into order_items
    foreach ($cart_rows as $item) {
        $name       = $item['name'];
        $price      = $item['price'];
        $quantity   = $item['quantity'];
        $product_id = $item['product_id'];

        mysqli_query($conn, "
            INSERT INTO order_items (order_id, product_id, name, price, quantity)
            VALUES ('$order_id', '$product_id', '$name', '$price', '$quantity')
        ");
    }

    // Now clear the cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");
}

// Clear shipping from session
unset($_SESSION['shipping']);

// Get user info
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'"));

$order_number = 'RDX' . date('ymd') . ($order_id ?? '');
?>

<body>
<?php include 'includes/nav.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');

    .success-page { max-width: 720px; margin: 0 auto; padding: 80px 24px 120px; }

    .success-icon {
        width: 80px; height: 80px;
        border: 1px solid #c5ab80; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 36px;
        animation: popIn .5s cubic-bezier(.175,.885,.32,1.275) both;
    }
    .success-icon i { font-size: 32px; color: #c5ab80; }

    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }

    .success-header { text-align: center; margin-bottom: 56px; animation: fadeUp .5s .1s ease both; }
    .success-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 52px; font-weight: 300;
        color: #c5ab80; letter-spacing: 6px;
        text-transform: uppercase; margin-bottom: 12px;
    }
    .success-header p { color: #666; font-size: 13px; letter-spacing: 1px; }
    .order-number {
        display: inline-block; border: 1px solid #2a2a2a;
        padding: 8px 20px; font-size: 11px; letter-spacing: 3px;
        color: #c5ab80; text-transform: uppercase; margin-top: 16px;
    }

    .card {
        background: #161616; border: 1px solid #2a2a2a;
        padding: 32px; margin-bottom: 20px;
        animation: fadeUp .5s ease both;
    }
    .card:nth-child(1) { animation-delay: .15s; }
    .card:nth-child(2) { animation-delay: .22s; }
    .card:nth-child(3) { animation-delay: .29s; }

    .card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px; color: #c5ab80;
        letter-spacing: 3px; text-transform: uppercase;
        margin-bottom: 24px; padding-bottom: 16px;
        border-bottom: 1px solid #2a2a2a;
    }

    .order-item {
        display: flex; gap: 16px; align-items: center;
        padding: 14px 0; border-bottom: 1px solid #1e1e1e;
    }
    .order-item:last-of-type { border-bottom: none; }
    .order-item img { width: 64px; height: 64px; object-fit: cover; border: 1px solid #2a2a2a; }
    .order-item .name { font-size: 14px; font-weight: 500; margin-bottom: 4px; }
    .order-item .qty { font-size: 11px; color: #666; letter-spacing: 1px; }
    .order-item-price { font-size: 14px; color: #c5ab80; font-weight: 600; margin-left: auto; }

    .order-total-row {
        display: flex; justify-content: space-between;
        padding-top: 20px; margin-top: 4px;
        border-top: 1px solid #2a2a2a;
    }
    .order-total-row span { font-family: 'Cormorant Garamond', serif; font-size: 20px; color: #c5ab80; }

    .address-text { font-size: 13px; color: #aaa; line-height: 2; }
    .address-text strong { color: #e8e0d0; display: block; font-size: 15px; margin-bottom: 4px; }

    .btn-shop {
        display: block; width: 100%; padding: 18px;
        background: #c5ab80; color: #000; border: none;
        cursor: pointer; margin-top: 32px;
        font-family: 'Poppins', sans-serif; font-size: 11px;
        font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
        text-align: center; text-decoration: none; transition: background .2s;
        animation: fadeUp .5s .35s ease both;
    }
    .btn-shop:hover { background: #d9c49e; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
</style>

<div class="success-page">

    <div class="success-icon"><i class="fas fa-check"></i></div>

    <div class="success-header">
        <h1>Order Confirmed</h1>
        <p>Thank you, <?= $user['first_name'] ?>. Your order has been received.</p>
        <div class="order-number"># <?= $order_number ?></div>
    </div>

    <?php if (!empty($cart_rows)): ?>
    <div class="card">
        <div class="card-title">Items Ordered</div>
        <?php foreach ($cart_rows as $item): ?>
        <div class="order-item">
            <img src="/RDX/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
            <div>
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

<script>
    localStorage.removeItem('rdx_cart');
</script>

<?php include __DIR__ . '/includes/footer-scripts.php'; ?>