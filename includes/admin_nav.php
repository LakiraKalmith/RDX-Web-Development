 <?php 
$currentPage = basename($_SERVER['PHP_SELF']);

$count = "SELECT * FROM products";
$countRes = $conn->query($count);
$countValue = (int)mysqli_num_rows($countRes);
?>
?>
 <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                <div class="logo-icon">
                <img src="/RDX/images/logo.png" alt="RDX Logo" class="logo-icon">
                </div>
                <span class="logo-text">ADMIN</span>
            </a>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <ul>
                    <li>
                        <a href="dashboard.php" class="<?=  ($currentPage == 'dashboard.php') ? 'active' : '' ?>" >
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Catalog</div>
                <ul>
                    <li>
                        <a href="products.php" class="<?=  ($currentPage == 'products.php') ? 'active' : '' ?>" >
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                            <span class="nav-badge"><?= $countValue; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="categories.php" class="<?= ($currentPage == 'categories.php') ? 'active' : '' ;?>">
                            <i class="fas fa-tags"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Sales</div>
                <ul>
                    <li>
                        <a href="orders.php" class="<?= ($currentPage == 'orders.php') ? 'active' : '' ;?>">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                            <span class="nav-badge">8</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                <ul>
                    <li>
                        <a href="users.php" class="<?= ($currentPage == 'users.php') ? 'active' : '' ;?>">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="sidebar-footer">
            <!-- <div class="user-info">
                <div class="user-avatar">A</div>
                <div class="user-details">
                    <span class="user-name">Admin</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div> -->

             
            <div class="theme-toggle" onclick="toggleTheme()">
                <span class="theme-label">
                    <i class="fas fa-sun"></i>
                    <span id="theme-text">Light Mode</span>
                </span>
                <div class="toggle-switch"></div>
            </div>

           <a href="../logout.php" class="logout-btn red">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            

        </div>
    </aside>
