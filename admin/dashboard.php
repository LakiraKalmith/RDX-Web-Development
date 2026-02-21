<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';

$count = "SELECT * FROM users WHERE role = 'customer'";
$countRes = $conn->query($count);
$users = (int)mysqli_num_rows($countRes);

// Total products
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE status = 'active'"));
$products_this_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$products_last_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$products_percent = $products_last_month['total'] > 0 ? round((($products_this_month['total'] - $products_last_month['total']) / $products_last_month['total']) * 100) : 0;

// Total orders
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"));
$orders_this_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$orders_last_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$orders_percent = $orders_last_month['total'] > 0 ? round((($orders_this_month['total'] - $orders_last_month['total']) / $orders_last_month['total']) * 100) : 0;

// Revenue
$revenue_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders"));
$revenue_this_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$revenue_last_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$revenue_percent = $revenue_last_month['total'] > 0 ? round((($revenue_this_month['total'] - $revenue_last_month['total']) / $revenue_last_month['total']) * 100) : 0;

// Total users
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'customer'"));
$users_this_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$users_last_month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"));
$users_percent = $users_last_month['total'] > 0 ? round((($users_this_month['total'] - $users_last_month['total']) / $users_last_month['total']) * 100) : 0;

function formatK($num) {
    if ($num >= 1000000) {
        return round($num / 1000000, 2) . 'M';
    }
    if ($num >= 1000) {
        return round($num / 1000, 1) . 'K';
    }
    return $num;
}
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
                    <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">$<?= formatK($revenue_total['total'] ?? 0) ?></div>
                        <div class="stat-change positive">
                            <i class="fas fa-chart-line"></i>
                            All time
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-shopping-cart"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Orders</div>
                        <div class="stat-value"><?= $total_orders['total'] ?></div>
                        <div class="stat-change <?= $orders_percent >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $orders_percent >= 0 ? 'up' : 'down' ?>"></i>
                            <?= abs($orders_percent) ?>% from last month
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Revenue This Month</div>
                        <div class="stat-value">$<?= formatK($revenue_this_month['total'] ?? 0) ?></div>
                        <div class="stat-change <?= $revenue_percent >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $revenue_percent >= 0 ? 'up' : 'down' ?>"></i>
                            <?= abs($revenue_percent) ?>% from last month
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value"><?= $total_users['total'] ?></div>
                        <div class="stat-change <?= $users_percent >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $users_percent >= 0 ? 'up' : 'down' ?>"></i>
                            <?= abs($users_percent) ?>% from last month
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
