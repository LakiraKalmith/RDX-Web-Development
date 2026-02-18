<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    
    // Check if fields are empty
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email and password are required';
        header("Location: index.php?login=1");
        exit();
    }
    
    // Query user from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        // User found
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Password correct - Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            // Redirect based on user type
            if ($user['user_type'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: shop.php");
            }
            exit();
            
        } else {
            // Password wrong
            $_SESSION['error'] = 'Invalid email or password!';
            header("Location: home.php?login=1");
            exit();
        }
        
    } else {
        // User not found
        $_SESSION['error'] = 'Invalid email or password!';
        header("Location: home.php?login=1");
        exit();
    }
}

mysqli_close($conn);
?>