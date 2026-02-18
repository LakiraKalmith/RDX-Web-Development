<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/customer_only.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id = (int)$_SESSION['user_id'];

    if (!$user_id) {
        $_SESSION['error'] = "Error occured! Please login";
    }

    $address_type = trim($_POST['address_type']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address_line1 = trim($_POST['address_line1']);
    $address_line2 = trim($_POST['address_line2']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zip_code = trim($_POST['zip_code']);
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    $country = trim($_POST['country']);

    if (empty($full_name) || empty($phone) || empty($address_line1) || 
        empty($city) || empty($state) || empty($zip_code)) {
        $_SESSION['error'] = "All required fields must be filled!";
        header("Location: ../add-address.php");
        exit();
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $full_name)) {
        $_SESSION['error'] = "Name should only contain letters!";
        header("Location: ../add-address.php");
        exit();
    }

    if (!preg_match("/^[0-9\s\+\-\(\)]+$/", $phone)) {
        $_SESSION['error'] = "Invalid phone number format!";
        header("Location: ../add-address.php");
        exit();
    }

    if (!preg_match("/^[a-zA-Z0-9\s\-]+$/", $zip_code)) {
        $_SESSION['error'] = "Invalid zip code format!";
        header("Location: ../add-address.php");
        exit();
    }



    if ($is_default == 1) {
        $unset_sql = "UPDATE addresses SET is_default = 0 WHERE user_id = $user_id";
        $conn->query($unset_sql);
    }

    $sql = "INSERT INTO addresses (user_id, address_type, full_name, phone, address_line1, 
            address_line2, city, state, zip_code, country, is_default) 
            VALUES ('$user_id', '$address_type', '$full_name', '$phone', '$address_line1', 
            '$address_line2', '$city', '$state', '$zip_code', '$country', '$is_default')";

    $result = @mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['success'] = "Address added successfully!";
        header("Location: ../my-account.php?section=addresses");
    } else {
        $_SESSION['error'] = "Failed to add address!";
        header("Location: ../add-address.php");
        exit;
    }
}
