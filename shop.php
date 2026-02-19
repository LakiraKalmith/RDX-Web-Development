<?php 
require_once __DIR__ . '/includes/init.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/load_cart.php'; 
include 'newsletter.php'; 

$sql = "SELECT * FROM products WHERE status = 'active'";
$result = $conn->query($sql);

?>
<body>
        <!-- this is for the navbar -->
        <?php include 'includes/nav.php'; ?>

    <section class="product1" >
        <h4>ALL COLLECTIONS</h4>

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