<?php
if (isset($_POST['updateProfile'])) {
    
    $user_id = $_SESSION['user_id'];
    $Fname = trim($_POST['first_name']);
    $Lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $profileID = (int)$_POST['profile_id'];


    if (!isset($user_id)) {
    $error = "you must be logged in";
    return;
    }

    if (!$profileID == $user_id) {
        $error = "Please login again";
        return;
    }

    if (!isset($_POST['profile_id']) || empty($_POST['profile_id'])) {
        $error = "User ID missing.";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
        return;
    }
    // check for email exising

    $check_sql = "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'";
    $check_result = $conn->query($check_sql);

    if (mysqli_num_rows($check_result) > 0 ) {
        $error = "Email already in use";
        return;
        header("Location: my-account.php?section=profile&error");
        exit;
    }

    $sql = "UPDATE users SET first_name = '$Fname', last_name = '$Lname', email = '$email', phone = '$phone' 
            WHERE id = '$profileID'";
    $result = $conn->query($sql);

    if ($result) {
        $success = "Profile updated succesfully";
        return;
        header("Location: my-account.php?section=profile");
        exit;
    } else {
        $error = "Error deleting address" . mysqli_error($conn);
    }
} 