<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';
require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51T22o0FvrK1afc4dRUvObAaTNE59UR01FRR32FmyxN39wiVzV41g5I5fR2MZbpcw2BWdsnsIxXOj21QwRa39ZSYv00HJDH77DE";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$user_id = $_SESSION['user_id'];

$sqlCart = "SELECT cart.quantity, products.name, products.price
            FROM cart
            JOIN products ON cart.product_id = products.id
            WHERE cart.user_id = '$user_id' ";

$cart_items = $conn->query($sqlCart);

$line_items = [];
while ($item = mysqli_fetch_assoc($cart_items)) {
    $line_items[] = [
        'quantity'   => $item['quantity'],
        'price_data' => [
            'currency'     => 'usd',
            'unit_amount'  => $item['price'] * 100, 
            'product_data' => [
                'name' => $item['name']
            ]
        ]
    ];
}

if (empty($line_items)) {
    header('Location: /RDX/shop.php');
    exit;
}

$address_mode = $_POST['address_mode'] ?? 'saved';

if ($address_mode == 'saved') {
    $address_id = (int) $_POST['address_id'];
    $addr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM addresses WHERE id = '$address_id' AND user_id = '$user_id'"));
    $_SESSION['shipping'] = $addr; 

} else {
    // filled in a new address
    $_SESSION['shipping'] = [
        'full_name'     => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'phone'         => $_POST['phone'],
        'address_line1' => $_POST['address_line1'],
        'address_line2' => $_POST['address_line2'] ?? '',
        'city'          => $_POST['city'],
        'state'         => $_POST['state'],
        'zip_code'      => $_POST['zip_code'],
        'country'       => $_POST['country'],
    ];
}

$checkout_session = \Stripe\Checkout\Session::create([
    'mode'        => 'payment',
    'success_url' => 'http://localhost:3000/RDX/success.php',
    'cancel_url'  => 'http://localhost:3000/RDX/checkout-page.php',
    'line_items'  => $line_items,
]);

http_response_code(303);
header("Location: " . $checkout_session->url);