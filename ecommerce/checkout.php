<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p>Your cart is empty. <a href='index.php'>Go back to shop</a></p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$total_price = 0;
$cart_items = [];

foreach ($_SESSION['cart'] as $item) {
    if (isset($item['product_id']) && isset($item['quantity'])) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $sql = "SELECT name, price, image_url FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product['product_id'] = $product_id;
            $product['quantity'] = $quantity;
            $product['total_price'] = $product['price'] * $quantity;
            $cart_items[] = $product;
            $total_price += $product['total_price'];
        }
        $stmt->close();
    } else {
        echo "<p>Warning: One or more items in the cart do not have a product ID or quantity set.</p>";
    }
}

foreach ($cart_items as $item) {
    if (isset($item['product_id'])) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $order_date = date('Y-m-d H:i:s');

        $order_sql = "INSERT INTO orders (user_id, product_id, quantity, order_date) VALUES (?, ?, ?, ?)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("iiis", $user_id, $product_id, $quantity, $order_date);

        if (!$order_stmt->execute()) {
            echo "Error: " . $order_stmt->error;
        }

        $order_stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['cart']);
    header("Location: confirmation.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
<header>
    <h1>Checkout</h1>
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

<div class="checkout-container">
    <h2>Order Summary</h2>
    <?php foreach ($cart_items as $product): ?>
        <div class="cart-item">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
            <span><?php echo htmlspecialchars($product['name']); ?> (x<?php echo (int)$product['quantity']; ?>)</span>
            <span>$<?php echo number_format($product['total_price'], 2); ?></span>
        </div>
    <?php endforeach; ?>
    <h3 class="order-summary">Total: $<?php echo number_format($total_price, 2); ?></h3>

    <h2>Payment & Shipping Details</h2>
    <form action="checkout.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">Shipping Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="upi">UPI</option>
        </select>

        <!-- Credit Card Fields -->
        <div id="credit-card-fields" style="display:none;">
            <label for="card-number">Card Number:</label>
            <input type="text" id="card-number" name="card_number" maxlength="16" placeholder="1234 5678 9012 3456">

            <label for="expiry">Expiry Date:</label>
            <input type="text" id="expiry" name="expiry_date" placeholder="MM/YY">

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123">
        </div>

        <!-- PayPal -->
        <div id="paypal-fields" style="display:none;">
            <p>You will be redirected to PayPal to complete your payment.</p>
        </div>

        <!-- UPI -->
        <div id="upi-fields" style="display:none;">
            <label for="upi-id">Enter UPI ID:</label>
            <input type="text" id="upi-id" name="upi_id" placeholder="example@upi">
            <p>Or scan QR to pay:</p>
            <img src="images/upi-qr-code.png" alt="Scan QR Code" width="150">
        </div>

        <button type="submit">Place Order</button>
    </form>
</div>

<script>
    const paymentSelect = document.getElementById("payment");
    const ccFields = document.getElementById("credit-card-fields");
    const paypalFields = document.getElementById("paypal-fields");
    const upiFields = document.getElementById("upi-fields");

    function togglePaymentFields() {
        const value = paymentSelect.value;
        ccFields.style.display = value === "credit_card" ? "block" : "none";
        paypalFields.style.display = value === "paypal" ? "block" : "none";
        upiFields.style.display = value === "upi" ? "block" : "none";
    }

    paymentSelect.addEventListener("change", togglePaymentFields);
    window.addEventListener("DOMContentLoaded", togglePaymentFields);
</script>
</body>
</html>
