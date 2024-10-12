<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve all users from the database
$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Users List</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>User Name</th><th>Email</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['user_id']}</td><td>{$row['username']}</td><td>{$row['email']}</td></tr>";
    }

    echo "</table>";
} else {
    echo "No users found.";
}

// Close the database connection
mysqli_close($connection);
?>