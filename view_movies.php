<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         body{
            background-image: url(images/admin/admin_pannel.avif);
            background-repeat: no-repeat;
            background-size: cover;
        }
        h1{
            text-align: center;
            margin-top: 5%;
            margin-bottom: 5%;
            font-size: 50px;
            color: white;

        }
        table{
            background-color: #0009;
            backdrop-filter: blur(5px);
            padding: 2%;
            border: solid 2px white;
            border-radius: 10px;
            text-align:center;
            margin-left:3.5%;
        }
        th,td{
            color:white;
            font-size:20px;
        }
    </style>
</head>
<body>
    

<?php
// Establish a MySQL connection
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve all movies from the database
$query = "SELECT * FROM movie";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Movie List</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Movie ID</th><th>Movie Name</th><th>Movie Description</th><th>Movie Price $</th><th>Movie Image</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['movie_id']}</td><td>{$row['movie_name']}</td><td>{$row['movie_descrip']}</td><td>{$row['movie_price']}</td><td><img src='{$row['movie_image']}' width='100' height='150'></td></tr>";
    }

    echo "</table>";
} else {
    echo "No movies found.";
}

// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
