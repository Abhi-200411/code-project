<?php
session_start();


// Ensure the cart exists
if (isset($_SESSION['cart'])) {
    // Check if a product_id is passed
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Loop through the cart to find the product and remove it
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$index]);
                break;
            }
        }

        // Re-index the cart array to prevent gaps in indices
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
