<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input from the form
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert user data into the database
$query = "INSERT INTO user_reg (user_name,email, password) VALUES ('$user_name', '$email', '$password')";

if (mysqli_query($connection, $query)) {
     // User registration successful, retrieve the generated user ID
     $userID = $connection->insert_id; // Retrieve the generated user ID

     // Store the user ID in the session for future bookings
     session_start();
     $_SESSION['user_id'] = $userID;

    header("Location: userlogin.html#");;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
