<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';
?>


<?php 
    $message = '';
    $messageType = '';

    if (isset($_SESSION['success'])) {
        $message = $_SESSION['success'];
        $messageType = 'success';
        unset($_SESSION['success']); 
    }

    if (isset($_SESSION['error'])) {
        $message = $_SESSION['error'];
        $messageType = 'error';
        unset($_SESSION['error']); 
    }
    if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $featured = $_POST['featured'];
    $status = $_POST['status'];
    $image = $_FILES['product_image']['name'];
    $imageName = time() . '_' . $image;
    $tmpName   = $_FILES['product_image']['tmp_name'];
    
    $category_id = $_POST['category_id'];

    $sql = "INSERT INTO products (name, price,description, image, category_id, featured, status, created_at)
    VALUES ('$name', $price,'$description','$imageName', '$category_id', $featured, '$status', NOW())";

 
   try {
        $result = mysqli_query($conn, $sql);

            $uploadPath = "../images/products/" . $imageName;
            
            move_uploaded_file($tmpName,$uploadPath);

            $product_id = mysqli_insert_id($conn);

            foreach($_POST['sizes'] as $size => $stock) {
                if ($stock !== "" && $stock >0) {

                    $size = mysqli_real_escape_string($conn,$size);
                    $stock = (int)$stock;

                    $query = "INSERT INTO product_sizes (product_id, size, stock)
                    VALUES ('$product_id', '$size', '$stock') ";

                    mysqli_query($conn, $query);
                }
            }


            $_SESSION['success'] = "Product added successfully!" ;
            header("Location: add-product.php");
            exit;

        
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: add-product.php");
        exit;
    }
    }

    $catResult = mysqli_query($conn, "SELECT id, name FROM categories");

?>


<body>
      <!-- navbar -->
     <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>

<div class="main-content">
    <div id="toast" class="toast <?php echo $messageType; ?>">
        <?php echo $message; ?>
    </div>

    <a href="products.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>

    <div class="page-header">
        <h1>Add New Product</h1>
        <p class="page-subtitle">Create a new product in your catalog</p>
    </div>
    <div class="form-wrapper">
        <form method="POST" enctype="multipart/form-data" class="product-form">
            <!-- productin info secton -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Product Information</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Product Name<span class="required">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. RDX Signature Shirt">
                    </div>
            

                    <div class="form-group">
                        <label>Price<span class="required">*</span></label>
                        <input type="number" name="price" required >
                    </div>
                </div>

                <div class="form-group">
                    <label>Description<span class="required">*</span></label>
                    <textarea name="description" required rows="4" placeholder="Describe your product..."></textarea>
                </div>
            </div>    

            <!-- cateogry and settisng section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-cog"></i>
                    <h3>Category & Settings</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Category<span class="required">*</span></label>
                        <select name="category_id" required>
                            <option value="">-- Select category --</option>
                            <?php while ($cat = mysqli_fetch_assoc($catResult)) { ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status<span class="required">*</span></label>
                        <select name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Featured Product</label>
                    <select name="featured">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <small class="form-hint">Featured products appear on the homepage</small>
                </div>
            </div>

            <!-- image seciton -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-image"></i>
                    <h3>Product Image</h3>
                </div>

                <div class="form-group">
                    <label>Upload Image<span class="required">*</span></label>
                    <input type="file" name="product_image" accept="image/*" required class="file-input">
                    <small class="form-hint">Recommended: Square image, min 800x800px</small>
                </div>
            </div>
            
            <!-- sizess and stock -->
                <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-boxes"></i>
                    <h3>Sizes & Stock</h3>
                </div>

                <div class="size-grid">
                    <div class="size-item">
                        <label>Small (S)</label>
                        <input type="number" name="sizes[S]" placeholder="0" >
                    </div>

                    <div class="size-item">
                        <label>Medium (M)</label>
                        <input type="number" name="sizes[M]" placeholder="0" >
                    </div>

                    <div class="size-item">
                        <label>Large (L)</label>
                        <input type="number" name="sizes[L]" placeholder="0" >
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.location.href='products.php'" name="cancel">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn-submit" name="add">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
        </form>
    </div>
</div>
    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
