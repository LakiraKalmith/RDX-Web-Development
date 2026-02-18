<?php

require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51T22o0FvrK1afc4dRUvObAaTNE59UR01FRR32FmyxN39wiVzV41g5I5fR2MZbpcw2BWdsnsIxXOj21QwRa39ZSYv00HJDH77DE";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    // enter susces page
    "success_url" => "http://localhost:3000/RDX/success.php",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                // amount is in cents put variable here
                "unit_amount" => 2000,
                // product detaisl
                "product_data" => [
                    "name" => "T-shirt" 
                ]

            ]
        ]
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);