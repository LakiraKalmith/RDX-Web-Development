<?php 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: home.php");
    exit;
}
