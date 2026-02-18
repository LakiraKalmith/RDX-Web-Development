<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $first_name = ucfirst(strtolower(trim($_POST['first_name'])));
    $last_name = ucfirst(strtolower(trim($_POST['last_name'])));
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'customer';
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
    }
    
    if (strlen($first_name) < 2) {
        $_SESSION['error'] = "First name must be at least 2 characters";
    }

    if (strlen($last_name) < 2) {
        $_SESSION['error'] = "Last name must be at least 2 characters";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] =  "Invalid email format";
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters";
    }
    
    // checking if email exists
    
    $check_email = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Email already registered";
        header("Location: home.php");
        exit;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (first_name, last_name, email, password, role) 
            VALUES ('$first_name', '$last_name', '$email', '$hashed_password', 'customer')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] =  'Account created successfully! You can now login.';
        header("Location: home.php");
        exit;
    } else {     
        $_SESSION['error'] =  'Error creating account: ' . mysqli_error($conn);
        header("Location: home.php");
        exit;

}

} else {
        $_SESSION['error'] = 'Invalid request';
        header("Location: home.php");
        exit;
}

mysqli_close($conn);
?>