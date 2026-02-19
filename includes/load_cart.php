<?php

require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql ="SELECT cart.quantity, cart.product_id, products.name, products.price, products.image
            FROM cart
            JOIN products ON cart.product_id = products.id
            WHERE cart.user_id = '$user_id'";

    $result = $conn->query($sql);

    
    $cart = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cart[] = [
            'product_id' => $row['product_id'],
            'name'       => $row['name'],
            'price'      => $row['price'],
            'image'      => '/RDX/images/products/' . $row['image'],
            'quantity'   => $row['quantity'],
        ];
    }

    // Print the cart array as JS so the browser can put it in localStorage
    echo "<script>
        const dbCart = " . json_encode($cart) . ";
        if (dbCart.length > 0) {
            localStorage.setItem('rdx_cart', JSON.stringify(dbCart));
        }
    </script>";
}
?>