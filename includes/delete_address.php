<?php
if (isset($_GET['delete'])) {
    $user_id    = $_SESSION['user_id'];
    $address_id = (int)$_GET['delete'];

    $check = $conn->query("SELECT id FROM addresses WHERE id = '$address_id' AND user_id = '$user_id'");
    if (mysqli_num_rows($check) > 0) {
        $conn->query("DELETE FROM addresses WHERE id = '$address_id' AND user_id = '$user_id'");
        $_SESSION['success'] = "Address deleted successfully";
    } else {
        $_SESSION['error'] = "Address not found";
    }

    header("Location: my-account.php?section=addresses");
    exit;
}

// if (isset($_POST['deleteAdd'])) {

//     $user_id = $_SESSION['user_id'];

//     if (!isset($user_id)){
//         $_SESSION['error'] = "You must be logged in to delete address";
//         return;
//     }
    
//     if (!isset($_POST['delete_address_id']) || empty($_POST['delete_address_id'])) {
//         $_SESSION['error'] =  "No address ID provided";
//         return;
//     }
    
//     $address_id = (int)$_POST['delete_address_id'];
    
//     $sql = "SELECT id FROM addresses WHERE id = '$address_id' AND user_id = '$user_id'";
//     $result = $conn->query($sql);

//     if (mysqli_num_rows($result) == 0) {
//         $_SESSION['error'] =  "Address not found";
//         return;
//     }

//     $delete ="DELETE FROM addresses WHERE id = '$address_id' AND user_id = '$user_id'";
//     $delResult = $conn->query($delete);

//     if ($delResult) {
//         $_SESSION['success'] =  "Address deleted successfully";

//         header("Location: my-account.php?section=addresses");
//         exit;
//     } else {
//         $_SESSION['error'] =  "Error deleting address" . mysqli_error($conn);
//     }
// }
// header("Location: my-account.php");