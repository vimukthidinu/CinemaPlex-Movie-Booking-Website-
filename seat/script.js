const seats = document.querySelectorAll(".row .seat:not(.occupied)");
const seatContainer = document.querySelector(".row-container");
const count = document.getElementById("count");
const total = document.getElementById("total");
const movieSelect = document.getElementById("movie");


populateUI();

let ticketPrice = +movieSelect.value;

// Save selected movie index and price
function setMovieData(movieIndex, moviePrice) {
  localStorage.setItem("selectedMovieIndex", movieIndex);
  localStorage.setItem("selectedMoviePrice", moviePrice);
}

function updateSelectedCount() {
  const selectedSeats = document.querySelectorAll(".container .selected");

  seatsIndex = [...selectedSeats].map(function(seat) {
    return [...seats].indexOf(seat);
  });

  localStorage.setItem("selectedSeats", JSON.stringify(seatsIndex));

  let selectedSeatsCount = selectedSeats.length;
  count.textContent = selectedSeatsCount;
  total.textContent = selectedSeatsCount * ticketPrice;
}

// Get data from localstorage and populate
function populateUI() {
  const selectedSeats = JSON.parse(localStorage.getItem("selectedSeats"));

  if (selectedSeats !== null && selectedSeats.length > 0) {
    seats.forEach(function(seat, index) {
      if (selectedSeats.indexOf(index) > -1) {
        seat.classList.add("selected");
      }
    });
  }

  const selectedMovieIndex = localStorage.getItem("selectedMovieIndex");

  if (selectedMovieIndex !== null) {
    movieSelect.selectedIndex = selectedMovieIndex;
  }
}

// Movie select event

movieSelect.addEventListener("change", function(e) {
  ticketPrice = +movieSelect.value;
  setMovieData(e.target.selectedIndex, e.target.value);
  updateSelectedCount();
});

// Adding selected class to only non-occupied seats on 'click'

seatContainer.addEventListener("click", function(e) {
  if (
    e.target.classList.contains("seat") &&
    !e.target.classList.contains("occupied")
  ) {
    e.target.classList.toggle("selected");
    updateSelectedCount();
  }
});

// Initial count and total rendering
updateSelectedCount();
// ... (existing code)
// Form submission handling
document.getElementById("booking-form").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent the form from submitting in the traditional way

  const selectedSeats = JSON.parse(localStorage.getItem("selectedSeats"));
  const movieIndex = localStorage.getItem("selectedMovieIndex");
  const movieId = document.getElementById("movie").value;
  const location = document.getElementById("location").value;
  const showDate = document.getElementById("date").value;
  const showTime = document.getElementById("time").value;

  // Calculate total price based on selected seats and movie price
  const ticketPrice = +document.getElementById("movie").value;
  const totalPrice = selectedSeats.length * ticketPrice;
  // Serialize the selectedSeats array into a JSON string
  const selectedSeatsJSON = JSON.stringify(selectedSeats);

  // Perform AJAX request
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "buytickets.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Handle successful response from server
      console.log(xhr.responseText);
alert("Your booking is successful.Thank you for making a reservation.We will email our payment gateway to confirm your booking. Have a great day!!! ");
        // Redirect to a success page or show a success message
      } else {
        // Handle error response from server
        console.error("Error: " + xhr.status);
        // Show an error message to the user
      }
    }
  };

  // Prepare data to send to the server
  const data = `movie=${movieId}&location=${location}&today=${showDate}&TIME=${showTime}&selectedSeats=${JSON.stringify(selectedSeats)}&totalPrice=${totalPrice}`;

  // Send the request
  xhr.send(data);
});
