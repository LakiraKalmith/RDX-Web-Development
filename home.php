<?php
require_once __DIR__ . '/includes/init.php';
include __DIR__ . '/includes/header.php';
include 'newsletter.php'; 

$sql = "SELECT * FROM products WHERE featured = 1 AND status = 'active'";
$result = $conn->query($sql);



?>

<body>
    <div class="loader">
        <img src="/RDX/images/logo.png" class="loader-logo">
    </div>

    <!-- this is for the navbar -->
    <?php include 'includes/nav.php'; ?>
    <!-- newsletter -->
 

    <section class="hero ">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h4>DRESS LIKE YOU MEAN IT</h4>
            <button class="btn-hero" onclick="document.location='shop.php'">SHOP NOW</button>

        </div>
    </section>

    <section class="product1 section-m1">
        <h4>FEATURED COLLECTION</h4>

        <div class="pro-container">
            <?php while ($row = mysqli_fetch_assoc($result)) {?>
            <div class="pro">
                <img src="/RDX/images/products/<?= $row['image']; ?>">
                <div class="des">
                    <h5><?= $row['name']; ?></h5>
                    <h4>$<?= $row['price']; ?></h4>
                </div>
                <div class="add-to-cart-container">
                    <input type="button" class="add-to-cart" value="ADD TO CART"
                        onclick="addToCart('<?= $row['name']; ?>', <?= $row['price']; ?>, '/RDX/images/products/<?= $row['image']; ?>', <?= $row['id']; ?>)">
                </div>
            </div>
            <?php }; ?>
        </div>
    </section>


    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <!-- ✓ --> <?= $_SESSION['success'] ?> 
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <!-- ✗ --> <?= $_SESSION['error'] ?> 
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>


    <section class="newsletter section-p1">
        <div class="news-text">
            <h4>Join The Exclusive Club</h4>
            <p>Enter your email for early access and <span>exclusive offers.</span></p>
        </div>

        <form action="" method="post" class="form">
            <input type="text" placeholder="Your email address" name="email" required>
            <button class="normal" type="submit" >Sign up</button> 
            <!-- onclick="subscribe()" -->
        </form>
    </section>

    <!-- footer -->
    <?php include __DIR__ . '/includes/footer-scripts.php'; ?>