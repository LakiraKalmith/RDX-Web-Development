<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/customer_only.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];
    $id = (int)$_POST['edit_id'];

    if (!isset($_POST['edit_id']) || empty($_POST['edit_id'])) {
        echo "No address ID provided";
        exit;
    }
    
    $sql = "SELECT * FROM addresses WHERE id = '$id' and user_id = '$user_id'";
    $result = $conn->query($sql);   

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Address don't match user or doesn't exist!";
        exit;
    }

    $address_type = $_POST['address_type'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    $country = $_POST['country'];

    if ($is_default == 1) {
        $unset_sql = "UPDATE addresses SET is_default = 0 WHERE user_id = $user_id";
        $conn->query($unset_sql);
    }

    $updateQuery = "UPDATE addresses SET address_type = '$address_type', full_name = '$full_name', phone = '$phone', address_line1 = '$address_line1',
                    address_line2 = '$address_line2', city = '$city', state = '$state', zip_code = '$zip_code', is_default = '$is_default', country = '$country' 
                    WHERE id = '$id' and user_id = '$user_id'
                    ";
    
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $_SESSION['success'] = "Address updated successfully!";
        header("Location: ../my-account.php?section=addresses");
    }
}
