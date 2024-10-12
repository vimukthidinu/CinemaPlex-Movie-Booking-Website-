<?php


// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a movie ID is provided via POST
if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    // Retrieve movie image path
    $image_query = "SELECT movie_image FROM movie WHERE movie_id = $movie_id";
    $image_result = mysqli_query($connection, $image_query);
    $row = mysqli_fetch_assoc($image_result);
    $image_path = $row['movie_image'];

    // Delete the movie from the database
    $query = "DELETE FROM movie WHERE movie_id = $movie_id";

    if (mysqli_query($connection, $query)) {
        // Delete successful, also remove the movie image file
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the movie image file
        }
        echo "Movie deleted successfully.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    // If no movie ID is provided, display the deletion form
    echo file_get_contents('delete_movies.php');
}

// Close the database connection
mysqli_close($connection);
?>
