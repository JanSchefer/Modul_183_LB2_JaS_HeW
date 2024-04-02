<?php
// Config for database configuration
require_once 'config.php';
// Create logs with given information
require_once __ROOT__ . '/log/log.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username']) && isset($_GET['password'])) {
    // Get username and password from the form
    $username = $_GET['username'];
    $password = $_GET['password'];
    
    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        $log->error("Database connection failed for user '" . $username . "': " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }
    // Prepare SQL statement to retrieve user from database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    // Store the result
    $stmt->store_result();
    // Check if username exists
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($db_id, $db_username, $db_password);
        // Fetch the result
        $stmt->fetch();
        // Verify the password
        if ($password == $db_password) {
            $log->info("User successfully logged in as '" . $username . "'");
            // Password is correct, store username in session
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["userid"] = $db_id;
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            $log->warning("User login failed as '" . $username . "'");
            // Password is incorrect
            echo "Incorrect password";
        }
    } else {
        $log->warning("Username not found: '" . $username . "'");
        // Username does not exist (fixed)
        echo "Incorrect password";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="get">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>