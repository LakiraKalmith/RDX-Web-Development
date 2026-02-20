<?php 
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/admin_only.php';




if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
    header('Location: products.php');
    exit;
}

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if ($product) {

    $imagePath = "../images/products/" . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $deleteSizes = "DELETE FROM product_sizes WHERE product_id = $id";
    mysqli_query($conn,$deleteSizes);


    $deleteQuery = "DELETE FROM products WHERE id = $id ";
    mysqli_query($conn, $deleteQuery);

    $_SESSION['success'] = "Product deleted successfully";
}
else 
{
    header('Location: products.php');
    exit;
}

header('Location: products.php');
    exit;

?>



