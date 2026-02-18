<?php 
require_once 'includes/init.php';

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_safe = mysqli_real_escape_string($conn , $email);
            
            $check = "SELECT * from newsletter_subscribers WHERE email = '$email_safe'";
            $checkRes = $conn->query($check);

            if (mysqli_num_rows($checkRes) > 0) {
                $_SESSION['error'] = "You are already subcrcribed! ";
                header("Location: home.php");
                exit;
            }

            $sql = "INSERT IGNORE INTO newsletter_subscribers (email) VALUES ('$email_safe')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "Thank you for subscribing!";
            }
            else {
                $_SESSION['error'] = "Something went wrong. Please try again.";
            }

            header("Location: home.php");
            exit;
        }
        else {
            $_SESSION['error'] = "Please enter a valid email address ";
        }     
    }
?>