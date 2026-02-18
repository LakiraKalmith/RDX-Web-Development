<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';
?>
    
    <?php 
    if (isset($_POST['add'])) {

        $name = $_POST['name'];
        $status = $_POST['status'];

        $sql = "INSERT INTO categories (name, status)
        VALUES ('$name', '$status')";

        $result = mysqli_query($conn,$sql);

        if ($result) {
            header("Location: categories.php");
            exit;

        } else {
            echo "Error adding category: " . mysqli_error($conn);
        }
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
            <h1>Add New Category</h1>
            <p class="page-subtitle">Create a new product category</p>
        </div>
    
        <div class="form-container">
            <form method="POST" class="modern-form" >
                <div class="form-group">
                    <label>Category Name<span class="required">*</span></label>
                    <input type="text" name="name" required placeholder="e.g T-Shirts, Hoodies, Accessories">
                </div>

                <div class="form-group">
                    <label>Status<span class="required">*</span></label>
                    <select name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="window.location.href='categories.php'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-submit" name="add">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>     

    
    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>