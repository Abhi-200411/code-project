<?php
session_start();
include 'db_config.php';


// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {//isset true if vsriable set in cart
    $_SESSION['cart'] = [];
}

// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        // Check if the product is already in the cart
        $product_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] += $quantity;
                $product_exists = true;
                break;
            }
        }

        // If the product is not in the cart, add it
        if (!$product_exists) {
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
        }
    } else {
        echo "Product ID and quantity must be provided.";
    }
}

// Fetch cart items for display
$cart_items = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/style1.css">
    
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
                <li><a href="cart.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <h1>Your Cart</h1>
    <div class="cart-container">
        <?php if (count($cart_items) > 0): ?>
            <?php
            $total_price = 0;
            foreach ($cart_items as $item):
                if (!isset($item['product_id'])) continue;

                $sql = "SELECT * FROM products WHERE id = " . (int)$item['product_id'];
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                } else {
                    echo "<p>Product not found.</p>";
                    continue;
                }
            ?>
                <div class="cart-item">
                    <div class="cart-item-details">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <span><?php echo htmlspecialchars($product['name']); ?></span>
                    </div>
                    <div class="product-quantity"><?php echo (int)$item['quantity']; ?></div>
                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                    <div class="remove"><a href="remove_from_cart.php?product_id=<?php echo (int)$item['product_id']; ?>">Remove</a></div>
                </div>
            <?php
                $total_price += $product['price'] * $item['quantity'];
            endforeach;
            ?>
            <div class="cart-summary">
    <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Show the checkout button for logged-in users -->
        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    <?php else: ?>
        <!-- Redirect non-logged-in users to login page -->
        <a href="login.php" class="checkout-button">Login to Checkout</a>
    <?php endif; ?>
</div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
