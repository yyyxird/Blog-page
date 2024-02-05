<?php
// Include the file containing database connection details
include 'config.php';

// Initialize variables for form data
$username = $password = $email = $address = "";
$username_err = $password_err = $email_err = $address_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter an address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Check for errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($address_err)) {
        // Prepare a prepared statement
        // Prepare a prepared statement
$sql = "INSERT INTO drix (username, password, email, address) VALUES (?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Set parameters and bind them to the prepared statement
    $param_username = $_POST["username"];
    $param_password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
    $param_email = $_POST["email"];
    $param_address = $_POST["address"];

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ssss", $param_username, $param_password, $param_email, $param_address);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to login page
        header("location: login.php");
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register">
        <h1>Register</h1>
        <h4>It's free and takes only a few minutes</h4>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>" required>
            <span class="error"><?php echo $username_err; ?></span>

            <label>Password</label>
            <input type="password" name="password" value="<?php echo $password; ?>" required>
            <span class="error"><?php echo $password_err; ?></span>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $email_err; ?></span>

            <label>Address</label>
            <input type="text" name="address" value="<?php echo $address; ?>" required>
            <span class="error"><?php echo $address_err; ?></span>

            <input type="submit" value="Submit">
        </form>
        <p>By clicking the Register button, you agree to our<br>
        <a href="#">Terms and Conditions</a> and <a href="#">Policy and Privacy</a>
        </p>
        <p>Already have an account? <a href="login.php">Log in Here</a></p>
        <p>Click here <a href="index.html">To homepage</a> </p> 
    </div>
</body>
</html>
