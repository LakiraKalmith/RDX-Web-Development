<?php

session_start();
session_unset();
session_destroy();
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<script>
    localStorage.removeItem('rdx_cart'); // clear the cart when logging out

    window.location.href = '/RDX/home.php';
</script>
</body>
</html>
