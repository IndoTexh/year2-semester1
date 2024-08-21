<?php
include("connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle login logic
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Perform the login query
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connect, $query);

    // Check if login is successful
    if (mysqli_num_rows($result) > 0) {
        // Start the session
        session_start();

        // Store username in session variable
        $_SESSION['username'] = $username;

        session_regenerate_id(true);
        
        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit();

    } else {
        // Display an error message
        session_start();
        $_SESSION['error_message'] = "Invalid username or password";
        header("Location: form.php");
        exit();
    }

    // Close the connection
    if (isset($connect)) {
        mysqli_close($connect);
    }
}

?>