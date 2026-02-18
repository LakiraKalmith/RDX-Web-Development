<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';




if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
    $_SESSION['error'] = "Invalid category ID!";
    header('Location: products.php');
    exit;
}

$defaultCategoryId = 1;
$defaultCategoryId = (int)$defaultCategoryId;
$id = (int)$_GET['id'];

if ($id == $defaultCategoryId) {
    $_SESSION['error'] = "Cannot delete the default category!";
    header('Location: categories.php');
    exit;
}

$query = "SELECT * FROM categories WHERE id =$id";
$result = mysqli_query($conn , $query);
$category = mysqli_fetch_assoc($result);

if ($category) 
{
    $move = "UPDATE products SET category_id = $defaultCategoryId WHERE category_id = $id";
    mysqli_query($conn,$move);

    $delete = "DELETE FROM categories WHERE id = $id";
    mysqli_query($conn,$delete);



    $_SESSION['success'] = "Category deleted and products moved to default category!";
    header('Location: categories.php');
    exit;
}
else
{
    $_SESSION['error'] = "Category not found!";
    header('Location: categories.php');
    exit;
}