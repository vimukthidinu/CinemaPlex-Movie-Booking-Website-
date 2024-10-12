
<?php
session_start(); // Start the session
var_dump($_POST);
$connection = mysqli_connect("localhost", "root", "", "admin_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


class MovieReservation {
    private $pdo = null;
    public $error = null;

    function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=admin_db;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function __destruct() {
        $this->pdo = null;
    }

    function saveBooking($userId, $movieId, $location, $showDate, $showTime, $selectedSeats) {
        // Calculate total price based on movie price and selected seats count
        $moviePrice = $this->getMoviePrice($movieId);
        if ($moviePrice === null) {
            $this->error = "Invalid movie ID.";
            return false;
        }
        $totalPrice = $moviePrice * count($selectedSeats);

        // Example SQL to insert data 
        $sql = "INSERT INTO booking (user_id, movie_id, location, show_date, show_time, num_seats, tot_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute([$userId, $movieId, $location, $showDate, $showTime, implode(",", $selectedSeats), $totalPrice])) {
            $this->error = "Error: Unable to save booking.";
            return false;
        }
        

    function getMoviePrice($movieId) {
        // Example SQL to retrieve movie price from the database based on movie ID
        $sql = "SELECT movie_price FROM movies WHERE movie_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId]);
        $result = $stmt->fetchColumn();

        // Check if the movie ID exists in the database
        if ($result !== false || $result !== null) {
            return $result; // Valid movie price found
        } else {
            return null; // Movie ID not found, return null to indicate an error
        }
    }
}
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['movie']) && isset($_POST['location']) && isset($_POST['today']) && isset($_POST['TIME']) && isset($_POST['selectedSeats'])) {
    $reservation = new MovieReservation();
    $userId = $_SESSION['user_id'];
    $movieId = $_POST['movie'];
    $location = $_POST['location'];
    $showDate = $_POST['today'];
    $showTime = $_POST['TIME'];
    $selectedSeats = $_POST['selectedSeats'];
    $totalPrice = $_POST['totalPrice'];

}

$numSeatsJSON = json_encode($selectedSeats);
    // Prepare and execute the SQL query
   
    $stmt = $connection->prepare("INSERT INTO booking (user_id, movie_id, location, show_date, show_time, num_seats, tot_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssi", $userId, $movieId, $location, $showDate, $showTime,  $numSeatsJSON, $totalPrice);
    if (mysqli_stmt_execute($stmt)) {
    echo "Booking inserted successfully!";

 } else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>