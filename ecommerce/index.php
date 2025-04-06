
<?php
include 'db_config.php';


// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<?php
// Start session
session_start();

// Set the session timeout duration (e.g., 15 minutes)
$timeout_duration = 900; // 900 seconds = 15 minutes

// Check if the user is already logged in (optional based on your application flow)
if (isset($_SESSION['user_id'])) {
    // Check if last activity timestamp is set
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        // Calculate the session's inactivity time
        $inactivity_duration = time() - $_SESSION['LAST_ACTIVITY'];

        // If inactivity time exceeds timeout duration, destroy the session
        if ($inactivity_duration > $timeout_duration) {
            session_unset();     // Unset session variables
            session_destroy();   // Destroy the session
            header("Location: login.php?session_expired=1"); // Redirect to login page with an expired message
            exit();
        }
    }

    // Update last activity time
    $_SESSION['LAST_ACTIVITY'] = time();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-commerce Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/logo2.png">
   
</head>
<body>
<header>
        <i><h1>Tiny Trunk</h1></i>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="register.php">Register</a></li> 
                    
                    <li><a href="login.php">Login</a></li>
                    <li><a href="cart.php">Cart</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="cart.php">Cart</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
        
    <h1>Product List</h1>
    <div class="product-list">
        <?php
        if ($result && $result->num_rows > 0) {
            // Output each product
            while($row = $result->fetch_assoc()) {
                // Define $image_url with a fallback in case it's empty
                $image_url = !empty($row['image_url']) ? $row['image_url'] : 'images/default.jpg';
            
                echo "<div class='product'>";
                echo "<a href='product_details.php?id=" . htmlspecialchars($row['id']) . "'>";
                echo "<img src='" . htmlspecialchars($image_url) . "' alt='" . htmlspecialchars($row['name']) . "' />";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                echo "</a>";
                echo "<p class='price'>Price: $" . htmlspecialchars($row['price']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </div>
</body>
</html>
