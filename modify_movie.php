<!DOCTYPE html>
<html>
<head>
    <title>Modify Movie</title>
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
            text-align: left;
        }
        label{
            font-size:50px;
            color: white;
        }
        input,textarea{
            font-size:40px;
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
    <h1>Modify Movie</h1>
    <form action="edit_movie.php" method="POST" enctype="multipart/form-data">
        <label for="movie_id">Select a Movie:</label>
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
            
        </select><br><br>
        
        <label for="movie_name">Movie Name:</label>
        <input type="text" name="movie_name" required style="margin-left:6.5%; width:64.5%"><br><br>
        
        <label for="movie_descrip">Movie Description:</label><br><br>
        <textarea name="movie_descrip" required style="margin-left:20%"></textarea><br><br>
        
        <label for="movie_image">Movie Image:</label><br><br>
        <input type="file" name="movie_image" accept="image/*" required style="margin-left:20%; color: white;"><br><br>
        
        <input type="submit" value="Edit Movie" style="margin-left:40%;margin-top: 5%;padding: 2%;">
    </form>
</body>
</html>
