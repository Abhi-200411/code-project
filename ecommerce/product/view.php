<?php
include '../db_config.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="product-detail">
        <h1><?php echo $product['name']; ?></h1>
        <img src="../<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" />
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <button>Add to Cart</button>
    </div>
</body>
</html>
