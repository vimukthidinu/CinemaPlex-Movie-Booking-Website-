<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input from the form
$movie_name = $_POST['movie_name'];
$movie_descrip = $_POST['movie_descrip'];
$movie_price = $_POST['movie_price'];

// Handle image upload
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["movie_image"]["name"]);
move_uploaded_file($_FILES["movie_image"]["tmp_name"], $target_file);

// Insert movie data into the database
$query = "INSERT INTO movie (movie_name, movie_descrip,movie_price, movie_image) VALUES ('$movie_name', '$movie_descrip','$movie_price', '$target_file')";

if (mysqli_query($connection, $query)) {
    echo "Movie added successfully.";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
