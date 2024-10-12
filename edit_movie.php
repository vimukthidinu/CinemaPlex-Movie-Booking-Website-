<?php


// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a movie ID is provided via POST
if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];
    $movie_name = $_POST['movie_name'];
    $movie_descrip = $_POST['movie_descrip'];

    // Handle image upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["movie_image"]["name"]);
    move_uploaded_file($_FILES["movie_image"]["tmp_name"], $target_file);

    // Update movie data in the database, including movie_image
    $query = "UPDATE movie SET movie_name = '$movie_name', movie_descrip = '$movie_descrip', movie_image = '$target_file' WHERE movie_id = $movie_id";

    if (mysqli_query($connection, $query)) {
        echo "Movie updated successfully.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    // If no movie ID is provided, display the modification form
    include('modify_movies.php'); // Assuming modify_movies.php contains the form for editing movies
}

// Close the database connection
mysqli_close($connection);
?>
