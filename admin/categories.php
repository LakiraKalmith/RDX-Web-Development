<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';
require_once __DIR__ . '/../includes/admin_header.php';

$count = "SELECT * FROM categories";
$countRes = $conn->query($count);
$countValue = (int)mysqli_num_rows($countRes);
?>

?>
    
    
    
<body>
    <!-- this is for the navbar -->
    <?php require_once __DIR__ . '/../includes/admin_nav.php';
    

//     if (isset($_SESSION['success'])) {
//     echo "<p style='color:green'>" . $_SESSION['success'] . "</p>";
//     unset($_SESSION['success']);
// }

// if (isset($_SESSION['error'])) {
//     echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
//     unset($_SESSION['error']);
// }
    
    ?>  

    

<div class="main-content">
    <div class="page-header">
        <h1>Categories</h1>
        <p class="page-subtitle">Organize your product categories</p>
    </div>

    <div class="container">
         <div class="container-header">
            <h2 class="container-title">All Categories (<?= $countValue; ?>)</h2>
            <a href="add-category.php" class="btn btn-primary"><i class="fas fa-plus"></i>
            Add Category
            </a>
         </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php 

                    $sql = "SELECT * FROM categories";
                    $result = mysqli_query($conn,$sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                    
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>

                        <td>
                            <?php echo $row['name']; ?>
                        </td>

                        <td>
                            

                        </td>

                        <td>
                            <?php if ($row['status'] === 'active') { ?>
                            <span class="badge active">Active</span>
                            <?php } else { ?>
                            <span class="badge inactive">Inactive</span>
                            <?php } ?>
                        </td>

                        <td class="actions">
                        <a href="edit-category.php?id=<?php echo $row['id']; ?>" class="icon-btn">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="icon-btn delete"
                            onclick="confirmDelete('delete-category.php?id=<?= $row['id'] ?>', 'Are you sure you want to delete \'<?= $row['name'] ?>\'? This cannot be undone.')">
                            <i class="fa fa-trash"></i>
                        </a>
                        </td>
                        <?php 
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>            
    </div>  
</div>
    
  
    
    
    
    
    
    <!-- footer -->
    <?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>