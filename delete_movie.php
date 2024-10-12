<!DOCTYPE html>
<html>
<head>
    <title>Delete Movie</title>
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
        form{
            background-color: #0009;
            backdrop-filter: blur(5px);
            padding: 2%;
            margin-left: 10%;
            margin-right: 10%;
            border: solid 2px white;
            border-radius: 10px;
            text-align: center;
        }
        label{
            font-size:50px;
            color: white;
        }
        input{
            font-size:30px;
            border-radius: 10px;
        }
         select{
            font-size:20px;
            padding-top:2%;
            border-radius: 10px;
            margin-left:3%;
         }
    </style>
</head>
<body>
    <h1>Delete Movie</h1>
    <form action="remove_movie.php" method="POST">
        <label for="movie_id">Select a Movie to Delete:</label><br><br>
        <select name="movie_id" required>
            <option value="">Select Movie</option>
            
            <?php
            // Establish a MySQL connection
            $connection = mysqli_connect("localhost", "root", "", "admin_db");

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve the list of movies from the database
            $query = "SELECT movie_id, movie_name FROM movie";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['movie_id']}'>{$row['movie_name']}</option>";
                }
            }

            // Close the database connection
            mysqli_close($connection);
            ?>
            
        </select><br>
        
        <input type="submit" value="Delete Movie" style="margin-top: 5%;padding: 2%;">
    </form>
</body>
</html>
