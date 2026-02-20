<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_header.php';
require_once __DIR__ . '/../includes/admin_only.php';
?>
<?php 
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn,$query);

    $sizeQuery = "SELECT size, stock FROM product_sizes WHERE product_id = $id";
    $resultSize = mysqli_query($conn,$sizeQuery);

    $categoriesQuery = "SELECT id, name FROM categories";
    $categoriesResult = mysqli_query($conn, $categoriesQuery); 


    $product = mysqli_fetch_assoc($result);

    $sizes = [];

    if(!$product) {
        header("Location: products.php");
        exit;
    }

    while ($row = mysqli_fetch_assoc($resultSize)) {
        $sizes[$row['size']] = $row['stock'];
    }

    if(isset($_POST['update'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $category_id = $_POST['category_id'];
        $featured = $_POST['featured'];
        $status = $_POST['status'];

        $tmpName   = $_FILES['product_image']['tmp_name'];
        $newImage = $_FILES['product_image']['name'];
        $oldImage = $product['image'];

        if ($newImage != "")
        {
            $imageName = time() . '_' . $newImage;
            $uploadPath = "../images/products/" . $imageName;

            move_uploaded_file($tmpName, $uploadPath);
            unlink("../images/products/" . $oldImage);
            
        } 
        else
        {  
            $imageName = $oldImage;
        }


        $updateQuery = " UPDATE products 
        SET name = '$name', price = '$price', description = '$description', category_id = '$category_id',
        featured = '$featured', status = '$status', image = '$imageName'
        WHERE id = $id ";

        $updateResult = mysqli_query($conn,$updateQuery);

        



        if ($updateResult) {

            $delete_sql = "DELETE FROM product_sizes WHERE product_id = '$id'";
            mysqli_query($conn, $delete_sql);

            // Inserting the sizes again cuz deleted it in the above line
            foreach($_POST['sizes'] as $size => $stock) {
                if ($stock >0) {

                    $size = mysqli_real_escape_string($conn,$size);
                    $stock = (int)$stock;

                    $query = "INSERT INTO product_sizes (product_id, size, stock)
                    VALUES ('$id', '$size', '$stock') ";

                    mysqli_query($conn, $query);
                }
            }
        }
        
    
        

        if ($updateResult) {
            $_SESSION['success'] = "Product updated successfully";
            header("Location: products.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update product";
        }
    }

    
?>




<body>
    <!-- this is for the navbar -->
    <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>  

<div class="main-content">
        <a href="products.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>

    <div class="page-header">
            <h1>Edit Product</h1>
            <p class="page-subtitle">Update product information</p>
        </div>

    <div class="form-wrapper">
    <form method="POST" enctype="multipart/form-data" class="product-form">
        <!-- product info -->
        <div class="form-section">
            <div class="section-header">
                <i class="fas fa-info-circle"></i>
                <h3>Product Information</h3>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Product Name<span class="required">*</span></label>
                    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Price<span class="required">*</span></label>
                    <input type="number" name="price" value="<?php echo $product['price']; ?>" required step="0.01" >
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required rows="4"><?php echo $product['description']; ?></textarea>
            </div>
        </div>
        
        <!-- category and seting -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-cog"></i>
                    <h3>Category & Settings</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Category<span class="required">*</span></label>
                        <select name="category_id" required>
                            <option value="">-- Select Category --</option>
                            <?php while ($cat = mysqli_fetch_assoc($categoriesResult)) { ?>
                                <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                    <?= $cat['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status<span class="required">*</span></label>
                        <select name="status">
                            <option value="active" <?php echo $product['status'] == 'active' ? 'selected' : '' ?> >Active</option>
                            <option value="inactive" <?php echo $product['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Featured Product</label>
                    <select name="featured">
                        <option value="0" <?php echo $product['featured'] == '0' ? 'selected' : '' ?>>No</option>
                        <option value="1" <?php echo $product['featured'] == '1' ? 'selected' : '' ?>>Yes</option>
                    </select>
                    <small class="form-hint">Featured products appear on the homepage</small>
                </div>
            </div>

            <!-- image -->
            
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-image"></i>
                    <h3>Product Image</h3>
                </div>

                <div class="current-image">
                    <label>Current Image</label>
                    <img src="../images/products/<?= $product['image']; ?>" class="preview-img">
                </div>

                <div class="form-group">
                    <label>Change Image</label>
                    <input type="file" name="product_image" accept="image/*" class="file-input">
                    <small class="form-hint">Leave empty to keep current image</small>
                </div>
            </div>

            <!-- size n stock -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-boxes"></i>
                    <h3>Sizes & Stock</h3>
                </div>

                <div class="size-grid">
                    <?php 
                    $allSizes = ['S', 'M', 'L'];
                    foreach ($allSizes as $size):
                        $stock = $sizes[$size] ?? 0;
                    ?>
                        <div class="size-item">
                            <label><?= $size == 'S' ? 'Small (S)' : ($size == 'M' ? 'Medium (M)' : 'Large (L)') ?></label>
                            <input type="number" name="sizes[<?= $size ?>]" placeholder="Stock" value="<?php echo $stock; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.location.href='products.php'">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn-submit" name="update">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>





<!-- footer -->
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>