<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input from the form
$admin_name = $_POST['admin_name'];
$ad_password = password_hash($_POST['ad_password'], PASSWORD_DEFAULT);

// Insert user data into the database
$query = "INSERT INTO  admin (admin_name, ad_password) VALUES ('$admin_name','$ad_password')";

if (mysqli_query($connection, $query)) {
    header("Location: admin.html");;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
