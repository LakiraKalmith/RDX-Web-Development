<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_header.php';
require_once __DIR__ . '/../includes/admin_only.php';
?>
    
    <?php 
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn,$query);

    $category = mysqli_fetch_assoc($result);

    $all = "SELECT * FROM categories";
    $allQuery = $conn->query($all);
    

    if(!$category) {
        header("Location: categories.php");
        exit;
    }

    if(isset($_POST['update'])) {

        $name = $_POST['name'];
        $status = $_POST['status'];

        $updateQuery ="UPDATE categories 
        SET name = '$name', status = '$status'
        WHERE id = $id ";

        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            $_SESSION['success'] = "Category updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update category";
        }

        header("Location: categories.php");
        exit;
    }


?>



<body>
    <!-- this is for the navbar -->
    <?php require_once __DIR__ . '/../includes/admin_nav.php' ?>  

    <div class="main-content">
        <a href="categories.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a> 
        
        <div class="page-header">
            <h1>Edit Category</h1>
            <p class="page-subtitle">Update category information</p>
        </div>

        <div class="form-container">
            <form method="POST" class="modern-form">    
                <div class="form-group">
                    <label>Category Name<span class="required">*</span></label>
                    <input type="text" name="name" value="<?= $category['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Status<span class="required">*</span></label>
                    <select name="status">
                        <option value="Active" <?= $category['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $category['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="window.location.href='categories.php'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" name="update" class="btn-submit">
                        <i class="fas fa-save"></i> Update Category
                    </button>
                </div>
            </form>  
        </div>  
    </div>  
    
    
    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>