<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';
?>
    

    
<body>
    <!-- this is for the navbar -->
    <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>  
        <div class="main-content">
            <div class="page-header">
                <h1>Orders</h1>
                <p class="page-subtitle">Manage customer orders</p>
            </div>

            <div class="container">
                <div class="container-header">
                    <h2 class="container-title">Recent Orders (8)</h2>
                    <div class="btn-group">
                        <button class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orders-table">
                            <!-- Orders will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>