<?php 
$currentPage = basename($_SERVER['PHP_SELF']);?>



<section class="header">
        
        <a href="home.php" class="" ><img src="/RDX/images/logo.png" class="logo" alt=""></a>
        <nav>
            <ul class="navbar">
                <li><a href="home.php" class="<?=  ($currentPage == 'home.php') ? 'active' : '' ?>">HOME</a></li>
                <li><a href="shop.php" class="<?=  ($currentPage == 'shop.php') ? 'active' : '' ?>">SHOP</a></li>
                <li><a href="contact.php" class="<?=  ($currentPage == 'contact.php') ? 'active' : '' ?>">CONTACT</a></li>
                
                
                <li>
                    <a class="cart-icon-wrapper" onclick="openCart()">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="cart-badge" id="cartBadge">0</span>
                    </a>
                </li>
                
             
                <li class="user-dropdown-wrapper">
                <a class="user-pointer">
                    <i class="fa-regular fa-user"></i>
                </a>
                
               
                 
                <!-- drop down menu -->
                <div class="user-dropdown">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>

                        <!-- logged in user -->
                        <div class="dropdown-header">
                            <i class="fa-solid fa-circle-user"></i>
                            <div>
                                <p class="user-welcome">Welcome back!</p>
                                <p class="user-name"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="my-account.php" class="dropdown-item">
                            <i class="fa-solid fa-user"></i>
                            <span>My Account</span>
                        </a>
                        <a href="orders.php" class="dropdown-item">
                            <i class="fa-solid fa-box"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="wishlist.php" class="dropdown-item">
                            <i class="fa-solid fa-heart"></i>
                            <span>Wishlist</span>
                        </a>
                        <!-- admin only view part -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <div class="dropdown-divider"></div>
                            <a href="/RDX/admin/dashboard.php" class="dropdown-item admin-link">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>Admin Panel</span>
                            </a>
                        <?php endif; ?>
                        
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item logout-item">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </a>
                    <?php else: ?>
                        <!-- not logged in part -->
                        <div class="dropdown-header-guest">
                        <!-- <img src="/RDX/images/logo.png" height="32px" width="32px"> -->
                            <p>Join RDX Luxury</p>
                        </div>
                        <a onclick="openLogin()" class="dropdown-item">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Sign In</span>
                        </a>
                        <a onclick="openLogin(); setTimeout(() => { document.querySelector('.signUpBtn-link').click(); }, 100);" class="dropdown-item">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Create Account</span>
                        </a>
                    <?php endif; ?>
                </div>
            </li>
            </ul>
        </nav>
</section>