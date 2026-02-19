<?php 
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';
require_once __DIR__ . '/includes/change_password_handler.php';
require_once __DIR__ . '/includes/delete_address.php';
require_once __DIR__ . '/includes/update_profile.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$addressQuery = "SELECT * FROM addresses WHERE user_id = '$user_id' ORDER BY is_default DESC";
$addressResult = $conn->query($addressQuery);

$section = $_GET['section'] ?? 'profile';


include __DIR__ . '/includes/header.php';
?>

<body>

<!-- nav bar -->
<?php include 'includes/nav.php'; ?>

<section class="account-section">
    <div class="account-container">
        
        <!-- Sidebar -->
        <aside class="account-sidebar">
            <div class="account-user-info">
                <div class="user-avatar">
                    <?php 
                        $initial = $user['first_name'][0];
                        echo $initial;
                    ?>
                </div>
                <h3>
                    <?= $user['first_name'] . " " . $user['last_name']; ?>
                </h3>
                <p><?= $user['email']; ?></p>
            </div>

            <nav class="account-nav">
                <a href="my-account.php?section=profile" 
                class="nav-link  <?= $section === 'profile' ? 'active' : '' ?>" data-section="profile">
                    <i class="fas fa-user"></i> Profile Info
                </a>
                <a href="my-account.php?section=orders"
                 class="nav-link <?= $section === 'orders' ? 'active' : '' ?>" data-section="orders">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="my-account.php?section=addresses" 
                class="nav-link <?= $section === 'addresses' ? 'active' : '' ?>" data-section="addresses">
                    <i class="fas fa-map-marker-alt"></i> Addresses
                </a>
                <a href="my-account.php?section=password"
                 class="nav-link <?= $section === 'password' ? 'active' : '' ?>" data-section="password">
                    <i class="fas fa-lock"></i> Change Password
                </a>
                <a href="logout.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>

        <main class="account-content">

        <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    ✗ <?= $error; ?>
                </div>
            <?php endif; ?>
        
            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    ✓ <?= $success; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    ✓ <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    ✗ <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

      


                <!-- Profile -->
        <div class="content-section <?= $section === 'profile' ? 'active' : '' ?>" id="profile">
            <div class="content-header">
                <div>
                    <h2>Profile Information</h2>
                    <p>Manage your personal details</p>
                </div>
                <button type="button" class="btn-secondary" id="editProfileBtn" onclick="toggleEditProfile()">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>

            <form class="profile-form" id="profileForm" method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" value="<?= $user['first_name']; ?>" readonly name="first_name">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" value="<?= $user['last_name']; ?>" readonly name="last_name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="<?= $user['email']; ?>" readonly name="email">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" value="<?= $user['phone']; ?>" readonly name="phone">
                    </div>
                </div>

                <div class="form-actions" id="profileActions" style="display: none;">
                    <input  type='hidden'  value="<?= $user['id']; ?>" name="profile_id">
                    <button type="submit" class="btn-primary" name="updateProfile">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn-secondary" onclick="cancelEditProfile()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
                      <div class="content-section <?= $section === 'orders' ? 'active' : '' ?>" id="orders">
            <div class="content-header">
                <div>
                    <h2>My Orders</h2>
                    <p>Track and manage your orders</p>
                </div>
            </div>

            <?php
            $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC");
            ?>

            <div class="orders-list">
                <?php if (mysqli_num_rows($orders) == 0): ?>
                    <p style="color:#666; font-size:13px; letter-spacing:1px;">No orders yet.</p>

                <?php else: while ($order = mysqli_fetch_assoc($orders)): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">
                            <h4>Order #RDX<?= $order['id'] ?></h4>
                            <p>Placed on <?= date('F j, Y', strtotime($order['created_at'])) ?></p>
                        </div>
                        <span class="status-badge <?= $order['status'] ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>

                    <?php
                    $items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id = '{$order['id']}'");
                    ?>

                    <div class="order-items">
                        <?php while ($item = mysqli_fetch_assoc($items)): ?>
                        <div class="order-item">
                            <div class="item-details">
                                <h5><?= $item['name'] ?></h5>
                                <p>Qty: <?= $item['quantity'] ?></p>
                                <p class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="order-footer">
                        <div class="order-total">
                            <strong>Total:</strong> $<?= number_format($order['total'], 2) ?>
                        </div>
                        <div class="order-actions">
                            <button class="btn-secondary" onclick="openTrackModal('<?= $order['status'] ?>', '<?= date('F j, Y', strtotime($order['created_at'])) ?>')">
                                Track Order
                            </button>
                            <button class="btn-primary" onclick="openDetailsModal(<?= $order['id'] ?>)">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                <?php endwhile; endif; ?>
            </div>
        </div>
        
                <!-- ── Track Order Modal ── -->
        <div id="trackModal" class="modal-overlay">
            <div class="modal-box">
                <button class="modal-close" onclick="closeModals()">×</button>
                <div class="modal-title">Track Order</div>

                <div class="track-steps">
                    <div class="track-step" id="step-processing">
                        <div class="track-step-icon"><i class="fas fa-box"></i></div>
                        <p>Processing</p>
                    </div>
                    <div class="track-line"></div>
                    <div class="track-step" id="step-shipping">
                        <div class="track-step-icon"><i class="fas fa-truck"></i></div>
                        <p>Shipping</p>
                    </div>
                    <div class="track-line"></div>
                    <div class="track-step" id="step-delivered">
                        <div class="track-step-icon"><i class="fas fa-check"></i></div>
                        <p>Delivered</p>
                    </div>
                </div>

                <p id="trackDate" class="modal-meta"></p>
            </div>
        </div>
        <!-- ── View Details Modal ── -->
        <div id="detailsModal" class="modal-overlay">
            <div class="modal-box">
                <button class="modal-close" onclick="closeModals()">×</button>
                <div class="modal-title">Order Details</div>
                <div id="detailsContent">Loading...</div>
            </div>
        </div>


                <!-- Addresses -->
        <div class="content-section <?= $section === 'addresses' ? 'active' : '' ?>" id="addresses">
            <div class="content-header">
                <div>
                    <h2>My Addresses</h2>
                </div>
                <a class="btn-primary" href="/RDX/add-address.php" style="text-decoration:none;">+ Add New Address</a>
            </div>
            
            <div class="addresses-grid">
                <?php while ($row = $addressResult->fetch_assoc()) {?>
                <div class="address-card">
                    <div class="address-header">
                        <h4>
                        <?= $row['address_type']; ?>
                        </h4>
                        <span class="<?= ($row['is_default'] == 1) ? "default-badge" : '' ; ?>">
                            <?= ($row['is_default'] == 1) ? "Default" : '' ; ?>
                        </span>
                    </div>
                    <p><?= $row['full_name']; ?></p>
                    <p><?= $row['address_line1']; ?></p>
                    <p><?= $row['city'] . ', ' . $row['state'] . ' ' . $row['zip_code']; ?></p>
                    <p><?= $row['country']; ?></p>
                    <p>Phone: <?= $row['phone']; ?></p>
                    <div class="address-actions">
                        
                            <a class="btn-link" href="/RDX/edit-address.php?id=<?= $row['id']; ?>">Edit</a>

                        <form method="post" action="">
                            <input  type='hidden'  value="<?= $row['id'] ;?>" name="delete_address_id">
                            <button type=submit class="btn-link delete" name="deleteAdd" onclick="return confirm ('Are u sure u want to delete');">Delete</button>
                        </form>    
                    </div>
                </div>
                <?php } ?>
                
            </div>
            
        </div>

                <!-- Change Password -->
        <div class="content-section <?= $section === 'password' ? 'active' : '' ?>" id="password">
            <div class="content-header">
                <div>
                    <h2>Change Password</h2>
                    <p>Keep your account secure</p>
                </div>
            </div>


         

            <form class="password-form" method="POST">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="currentPassword">
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="newPassword">
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirmPassword">
                </div>

                <button type="submit" class="btn-primary" name="updatePassword">Update Password</button>
            </form>
        </div>

        </main>

    </div>
                

</section>
<script src="/RDX/js/main.js"></script>
<script>
function toggleEditProfile() {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input');
    const actions = document.getElementById('profileActions');
    const editBtn = document.getElementById('editProfileBtn');
    
    inputs.forEach(input => input.removeAttribute('readonly'));
    actions.style.display = 'flex';
    editBtn.style.display = 'none';
}

function cancelEditProfile() {
    location.reload();
}

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300); 
        }, 3000); 
    });
});

function openTrackModal(status, date) {
    document.getElementById('trackModal').style.display = 'flex';

    // Reset all steps
    ['processing', 'shipping', 'delivered'].forEach(s => {
        document.getElementById('step-' + s).classList.remove('active');
    });

    // Highlight steps up to current status
    const steps = ['processing', 'shipping', 'delivered'];
    const currentIndex = steps.indexOf(status);
    for (let i = 0; i <= currentIndex; i++) {
        document.getElementById('step-' + steps[i]).classList.add('active');
    }

    document.getElementById('trackDate').textContent = 'Order placed: ' + date;
}

function openDetailsModal(orderId) {
    document.getElementById('detailsModal').style.display = 'flex';
    document.getElementById('detailsContent').innerHTML = 'Loading...';

    fetch('/RDX/includes/get_order.php?order_id=' + orderId)
        .then(res => res.text())
        .then(html => {
            document.getElementById('detailsContent').innerHTML = html;
        });
}

function closeModals() {
    document.getElementById('trackModal').style.display = 'none';
    document.getElementById('detailsModal').style.display = 'none';
}

// Close when clicking outside the box
document.getElementById('trackModal').addEventListener('click', function(e) {
    if (e.target === this) closeModals();
});
document.getElementById('detailsModal').addEventListener('click', function(e) {
    if (e.target === this) closeModals();
});
</script>

<!-- footer -->
