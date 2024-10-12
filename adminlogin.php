<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input from the login form
$admin_name = $_POST['admin_name'];
$ad_password = $_POST['ad_password'];

// Retrieve hashed password from the database based on the provided email
$query = "SELECT admin_name, ad_password FROM admin WHERE admin_name='$admin_name'";
$result = mysqli_query($connection, $query);

if ($result) {
    // Check if the email exists in the database
    if (mysqli_num_rows($result) > 0) {
        // Fetch the stored password hash
        $row = mysqli_fetch_assoc($result);
        $stored_password_hash = $row['ad_password'];

        // Verify the entered password with the stored password hash
        if (password_verify($ad_password, $stored_password_hash)) {
            // Login successful, redirect to user dashboard or homepage
            header("Location: admin_panel.html");
            exit(); // Ensure that no further code is executed after redirection
        } else {
            // Invalid password, redirect back to login page with an error code
            header("Location: adminlogin.html?error=1");
            exit(); // Ensure that no further code is executed after redirection
        }
    } else {
        // Email not found, redirect back to login page with an error code
        header("Location: adminlogin.html?error=2");
        exit(); // Ensure that no further code is executed after redirection
    }
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
