<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';

include __DIR__ . '/includes/header.php';

$user_id = $_SESSION['user_id'];

// Get saved addresses
$addresses = mysqli_query($conn, "SELECT * FROM addresses WHERE user_id = '$user_id' ORDER BY is_default DESC");

// Get cart from DB
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

// If cart is empty, send them back to shop
if (empty($cart_rows)) {
    header('Location: /RDX/shop.php');
    exit;
}
?>

<body>
<?php include 'includes/nav.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Poppins:wght@300;400;500;600&display=swap');

    .checkout-page { max-width: 1100px; margin: 0 auto; padding: 60px 24px 100px; }

    .checkout-page h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px; font-weight: 300;
        color: #c5ab80; letter-spacing: 5px;
        text-transform: uppercase; margin-bottom: 8px;
    }
    .checkout-page .sub { color: #666; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 48px; }

    .checkout-layout { display: grid; grid-template-columns: 1fr 380px; gap: 48px; align-items: start; }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px; color: #c5ab80;
        letter-spacing: 3px; text-transform: uppercase;
        margin-bottom: 20px;
    }

    /* Saved address cards */
    .address-list { display: grid; gap: 12px; margin-bottom: 20px; }

    .address-card {
        border: 1px solid #2a2a2a; padding: 18px 20px;
        cursor: pointer; transition: border-color .2s;
        position: relative; display: block;
    }
    .address-card:hover { border-color: #c5ab80; }
    .address-card input[type="radio"] { position: absolute; top: 18px; right: 18px; accent-color: #c5ab80; }
    .address-card p { font-size: 13px; color: #aaa; line-height: 1.7; margin: 0; }
    .address-card .addr-name { font-size: 14px; font-weight: 600; color: #e8e0d0; margin-bottom: 4px; }
    .address-card.selected { border-color: #c5ab80; background: rgba(197,171,128,0.05); }

    /* New address toggle button */
    .new-address-toggle {
        background: none; border: 1px dashed #333;
        color: #666; width: 100%; padding: 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
        cursor: pointer; transition: all .2s; margin-bottom: 24px;
    }
    .new-address-toggle:hover { border-color: #c5ab80; color: #c5ab80; }

    /* New address form (hidden by default) */
    .new-address-form { display: none; }
    .new-address-form.open { display: block; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #666; margin-bottom: 7px; }
    .form-group input, .form-group select {
        width: 100%; background: #1a1a1a; border: 1px solid #2a2a2a;
        color: #e8e0d0; padding: 12px 14px;
        font-family: 'Poppins', sans-serif; font-size: 13px;
        outline: none; transition: border-color .2s; appearance: none;
    }
    .form-group input:focus, .form-group select:focus { border-color: #c5ab80; }
    .form-group select { 
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%23c5ab80' d='M5 7L0 2h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px;
    }
    .form-group select option { background: #1a1a1a; }

    /* Order summary box */
    .summary-box {
        background: #161616; border: 1px solid #2a2a2a;
        padding: 28px; position: sticky; top: 90px;
    }
    .summary-item { display: flex; gap: 14px; padding: 14px 0; border-bottom: 1px solid #222; align-items: center; }
    .summary-item:last-of-type { border-bottom: none; }
    .summary-item img { width: 60px; height: 60px; object-fit: cover; border: 1px solid #2a2a2a; }
    .summary-item .name { font-size: 13px; font-weight: 500; margin-bottom: 3px; }
    .summary-item .qty { font-size: 11px; color: #666; }
    .summary-item-price { font-size: 13px; color: #c5ab80; font-weight: 600; margin-left: auto; }

    .summary-total {
        border-top: 1px solid #2a2a2a; margin-top: 16px; padding-top: 16px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .summary-total span { font-family: 'Cormorant Garamond', serif; font-size: 20px; color: #c5ab80; }

    .btn-pay {
        width: 100%; padding: 16px; background: #c5ab80; color: #000;
        border: none; cursor: pointer; margin-top: 20px;
        font-family: 'Poppins', sans-serif; font-size: 11px;
        font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
        transition: background .2s;
    }
    .btn-pay:hover { background: #d9c49e; }
    .secure { text-align: center; font-size: 10px; color: #555; margin-top: 10px; letter-spacing: 1px; }
    .secure i { color: #c5ab80; margin-right: 4px; }

    @media(max-width: 800px) {
        .checkout-layout { grid-template-columns: 1fr; }
        .summary-box { position: static; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="checkout-page">
    <h1>Checkout</h1>
    <p class="sub">Cart → <strong style="color:#c5ab80">Details</strong> → Payment</p>

    <form method="POST" action="/RDX/checkout_process.php">

        <!-- tells process-checkout.php whether to use a saved address or the new form -->
        <input type="hidden" name="address_mode" id="addressMode" value="saved">

        <div class="checkout-layout">

            <!-- LEFT: Shipping -->
            <div>
                <!-- Saved addresses (only shows if they have any) -->
                <?php if (mysqli_num_rows($addresses) > 0): ?>
                    <div class="section-title">Your Addresses</div>
                    <div class="address-list">
                        <?php
                        $first = true;
                        while ($addr = mysqli_fetch_assoc($addresses)):
                        ?>
                        <label class="address-card <?= $first ? 'selected' : '' ?>" onclick="selectAddress(this)">
                            <input type="radio" name="address_id" value="<?= $addr['id'] ?>" <?= $first ? 'checked' : '' ?>>
                            <p class="addr-name"><?= $addr['full_name'] ?></p>
                            <p>
                                <?= $addr['address_line1'] ?><br>
                                <?php if ($addr['address_line2']) echo $addr['address_line2'] . '<br>'; ?>
                                <?= $addr['city'] ?>, <?= $addr['state'] ?> <?= $addr['zip_code'] ?><br>
                                <?= $addr['country'] ?>
                            </p>
                        </label>
                        <?php $first = false; endwhile; ?>
                    </div>
                <?php endif; ?>

                <!-- Button to show new address form -->
                <button type="button" class="new-address-toggle" onclick="toggleNewAddress()">
                    + Use a different address
                </button>

                <!-- New address form (hidden until button clicked) -->
                <div class="new-address-form" id="newAddressForm">
                    <div class="section-title">New Address</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" placeholder="John">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" placeholder="Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" placeholder="+1 555 000 0000">
                    </div>
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line1" placeholder="123 Main St">
                    </div>
                    <div class="form-group">
                        <label>Address Line 2 (optional)</label>
                        <input type="text" name="address_line2" placeholder="Apt 4B">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" placeholder="New York">
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" placeholder="NY">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>ZIP Code</label>
                            <input type="text" name="zip_code" placeholder="10001">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>United Kingdom</option>
                                <option>Australia</option>
                                <option>Sri Lanka</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="summary-box">
                <div class="section-title">Order Summary</div>

                <?php foreach ($cart_rows as $item): ?>
                <div class="summary-item">
                    <img src="/RDX/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    <div>
                        <div class="name"><?= $item['name'] ?></div>
                        <div class="qty">Qty: <?= $item['quantity'] ?></div>
                    </div>
                    <div class="summary-item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </div>
                <?php endforeach; ?>

                <div class="summary-total">
                    <span>Total</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>

                <button type="submit" class="btn-pay">
                    <i class="fas fa-lock" style="margin-right:6px;font-size:10px;"></i>
                    Pay with Stripe
                </button>
                <p class="secure"><i class="fas fa-shield-alt"></i> Secured by Stripe</p>
            </div>

        </div>
    </form>
</div>

<script>
function selectAddress(card) {
    document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    card.querySelector('input[type="radio"]').checked = true;
    document.getElementById('addressMode').value = 'saved';
    document.getElementById('newAddressForm').classList.remove('open');
}

function toggleNewAddress() {
    const form = document.getElementById('newAddressForm');
    const isOpen = form.classList.toggle('open');
    if (isOpen) {
        // deselect saved addresses
        document.querySelectorAll('.address-card').forEach(c => {
            c.classList.remove('selected');
            c.querySelector('input[type="radio"]').checked = false;
        });
        document.getElementById('addressMode').value = 'new';
    } else {
        document.getElementById('addressMode').value = 'saved';
    }
}
</script>

<?php include __DIR__ . '/includes/footer-scripts.php'; ?>