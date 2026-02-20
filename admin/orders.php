<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';
require_once __DIR__ . '/../includes/db.php';

// ── Handle status change ──────────────────────────
if (isset($_POST['change_status'])) {
    $order_id = (int) $_POST['order_id'];
    $status   = $_POST['status'];
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = '$order_id'");
    header('Location: orders.php');
    exit;
}

// ── Handle delete ─────────────────────────────────
if (isset($_POST['delete_order'])) {
    $order_id = (int) $_POST['order_id'];
    mysqli_query($conn, "DELETE FROM order_items WHERE order_id = '$order_id'");
    mysqli_query($conn, "DELETE FROM orders WHERE id = '$order_id'");
    header('Location: orders.php');
    exit;
}

// ── Get orders (with optional filter) ────────────
$filter = $_GET['status'] ?? 'all';

if ($filter == 'all') {
    $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY created_at DESC");
} else {
    $orders = mysqli_query($conn, "SELECT * FROM orders WHERE status = '$filter' ORDER BY created_at DESC");
}

$order_count = mysqli_num_rows($orders);
?>

<body>
    <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>

    <link rel="stylesheet" href="/RDX/admin/css/orders.css">

    <div class="main-content">
        <div class="page-header">
            <h1>Orders</h1>
            <p class="page-subtitle">Manage customer orders</p>
        </div>

        <!-- Filter tabs -->
        <div class="filter-tabs">
            <a href="orders.php?status=all"        class="filter-tab <?= $filter=='all'        ? 'active'            : '' ?>">All</a>
            <a href="orders.php?status=processing" class="filter-tab <?= $filter=='processing' ? 'active processing' : '' ?>">Processing</a>
            <a href="orders.php?status=shipping"   class="filter-tab <?= $filter=='shipping'   ? 'active shipping'   : '' ?>">Shipping</a>
            <a href="orders.php?status=delivered"  class="filter-tab <?= $filter=='delivered'  ? 'active delivered'  : '' ?>">Delivered</a>
        </div>

        <div class="container">
            <div class="container-header">
                <h2 class="container-title">Orders (<?= $order_count ?>)</h2>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if ($order_count == 0): ?>
                        <tr>
                            <td colspan="7" class="no-orders">No orders found</td>
                        </tr>

                        <?php else: ?>
                        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td class="order-id">#RDX<?= $order['id'] ?></td>
                            <td><?= $order['full_name'] ?></td>
                            <td class="order-address">
                                <?= $order['address'] ?>, <?= $order['city'] ?>, <?= $order['country'] ?>
                            </td>
                            <td class="order-date"><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                            <td>$<?= number_format($order['total'], 2) ?></td>
                            <td>
                                <span class="status-badge <?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">

                                    <!-- Change status -->
                                    <form method="POST">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="change_status" value="1">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="processing" <?= $order['status']=='processing' ? 'selected' : '' ?>>Processing</option>
                                            <option value="shipping"   <?= $order['status']=='shipping'   ? 'selected' : '' ?>>Shipping</option>
                                            <option value="delivered"  <?= $order['status']=='delivered'  ? 'selected' : '' ?>>Delivered</option>
                                        </select>
                                    </form>

                                    <!-- Delete -->
                                    <form method="POST" onsubmit="return confirm('Delete order #RDX<?= $order['id'] ?>? This cannot be undone.')">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <button type="submit" name="delete_order" class="icon-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>