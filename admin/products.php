<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';

$count = "SELECT * FROM products";
$countRes = $conn->query($count);
$countValue = (int)mysqli_num_rows($countRes);
?>


<body>
    
<!-- this is for the navbar -->
<?php require_once __DIR__ . '/../includes/admin_nav.php' ?>
    
<div class="main-content">
    <div class="page-header">
        <h1>Products</h1>
        <p class="page-subtitle">Manage your product catalog</p>
    </div>

    <div class="container">
        <div class="container-header">
            <h2 class="container-title">All Products (<?= $countValue; ?>)</h2>
            <div class="btn-group">
                <button class="btn btn-secondary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <!-- <a href="categories.php" class="btn btn-primary">[Manage Categories]</a> -->
                <a href="add-product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
            </div>  
        </div>  
        

        <!-- <input type="button" value="+ Add Product" onclick="window.location.href='add-product.php'"> -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>   

                <tbody>
                    <?php 
                        $query = "SELECT products.*, categories.name AS category_name
                            FROM products
                            LEFT JOIN categories
                            ON products.category_id = categories.id";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die(mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>

                        <td>
                            <img src="../images/products/<?php echo $row['image']; ?>" class="product-img">
                        </td>

                        <td>
                            <?php echo $row['name'] ;?>
                        </td>

                        <td>
                            <?php echo $row['price'] ;?>
                        </td>

                        <td>
                            <?php if ($row['category_name'] != '') {
                                echo $row['category_name'];
                            } else {
                                echo 'No Category';
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            echo (($row['featured']) ? "Yes" : "No");
                            ?>
                        </td>

                        <td>
                            <?php if ($row['status'] === 'active') { ?>
                            <span class="badge active">Active</span>
                            <?php } else { ?>
                            <span class="badge inactive">Inactive</span>
                            <?php } ?>
                        </td>

                        <td class="stock-info">
                            <div class="stock-item">
                            <?php
                            $pid = $row['id'];
                            $sizeQuery = "SELECT size, stock FROM product_sizes WHERE product_id = $pid";
                            $sizeResult = mysqli_query($conn, $sizeQuery);

                            while ($sizeRow = mysqli_fetch_assoc($sizeResult)) {
                            echo $sizeRow['size'] . ":" . $sizeRow['stock'] . "<br>";
                            }
                            ?>
                            </div>
                        </td>

                        <td>
                            <div class="actions">
                                <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="icon-btn">
                                <i class="fa fa-edit"></i>
                                </a>

                                <a href="#" class="icon-btn delete"
                                    onclick="confirmDelete('delete-product.php?id=<?= $row['id'] ?>', 'Are you sure you want to delete \'<?= $row['name'] ?>\'? This cannot be undone.')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
            </tbody>
                <?php } ?>
            </table>
        </div>
    </div>            
</div>

    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>