<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {
        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $success_message = "Registration successful!";
            header("Location: login.php"); // Redirect to login.php
            exit(); // Ensure no further code is executed
        } else {
            $error_message = "Error: Registration failed.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <script src="js/register.js"></script>

    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php
        if (isset($success_message)) {
            echo "<p style='color:green;'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>
        <form action="register.php" method="post">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
