<?php
if (isset($_POST['updatePassword'])) {

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $userId = $_SESSION['user_id'];

    if ($newPassword !== $confirmPassword) {
        $error = "New passwords do not match";
        return;
    }

    if (strlen($newPassword) < 6) {
        $error = "Passwords must be at least 6 characters";
        return;
    }

    $sql = "SELECT password FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows !== 1) {
        $error = "User not found";
        return;
    }

    $user = mysqli_fetch_assoc($result);

    if (!password_verify($currentPassword, $user['password'])) {
        $error = "Current password is incorrect";
        return;
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE id='$userId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $success = "Password changed succesfully";
    } else {
        $error = "Something went wrong. Try again.";
    }
}