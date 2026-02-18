<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';

$count = "SELECT * FROM users WHERE role = 'customer'";
$countRes = $conn->query($count);
$users = (int)mysqli_num_rows($countRes);

?>

<body>
    
    <!-- this is for the navbar -->
    <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>
  <div class="main-content">  
<div id="dashboard-page" class="page-content">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p class="page-subtitle">Welcome back! Here's what's happening with your store today.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">24</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            12% from last month
                        </div>
                    </div>
                </div>

            <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Orders</div>
                        <div class="stat-value">48</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            8% from last week
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Revenue</div>
                        <div class="stat-value">$12.5K</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            23% from last month
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Active Users</div>
                        <div class="stat-value"><?= $users; ?></div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            5% from yesterday
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="container-header">
                    <h2 class="container-title">Recent Activity</h2>
                </div>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="empty-title">Analytics Coming Soon</div>
                    <div class="empty-text">Your dashboard analytics will appear here</div>
                </div>
            </div>
        </div>
</div>



    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
