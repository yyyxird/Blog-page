<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "drixylir"; // Change this to your database name
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST["username"]; // Updated to match input field name
    $password = $_POST["password"]; // Updated to match input field name

    // Prepare SQL statement with a prepared statement
    $sql = "SELECT * FROM drix WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct, start session and redirect
            $_SESSION["username"] = $username;
            header("Location: blog.php"); // Redirect to blog page
            exit(); // Stop further execution of the script
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
    
    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <form method="POST"> <!-- Added method="POST" -->
            <label>Username</label>
            <input type="text" name="username" required> <!-- Updated name attribute -->
            <label>Password</label>
            <input type="password" name="password" required> <!-- Updated name attribute -->
            <input type="submit" value="Submit">
        </form>
        <p>Don't have an Account? <a href="register.php">Sign up Here</a></p>
    </div>
</body>
</html>
