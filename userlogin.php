<?php
session_start(); // Start the session

$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input from the login form (sanitize the inputs to prevent SQL injection)
$email = mysqli_real_escape_string($connection, $_POST['email']);
$password = mysqli_real_escape_string($connection, $_POST['password']);

// Query to retrieve user details
$query = "SELECT user_id, email, password FROM user_reg WHERE email='$email'";
$result = mysqli_query($connection, $query);

if ($result) {
    // Check if the email exists in the database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $stored_password_hash = $row['password'];

        // Verify the entered password with the stored password hash
        if (password_verify($password, $stored_password_hash)) {
            // Login successful, set up the session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;

            // Redirect to user dashboard or homepage
            header("Location: index.html");
            exit();
        } else {
            // Invalid password, redirect back to login page with an error code
            header("Location: userlogin.html?error=1");
            exit();
        }
    } else {
        // Email not found, redirect back to login page with an error code
        header("Location: userlogin.html?error=2");
        exit();
    }
} else {
    // Database query error handling
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
