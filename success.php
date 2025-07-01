<?php
session_start();
include("config/config.php"); // Include your database connection

// Check if the necessary session variables or POST data are available
if (!isset($_SESSION['userID'], $_SESSION['packageID'], $_SESSION['pax'], $_SESSION['totalPrice'], $_SESSION['bookedDate'])) {
    die("Required data is missing!");
}

// Retrieve booking details from session or POST
$userID = $_SESSION['userID'];
$packageID = $_SESSION['packageID'];
$pax = $_SESSION['pax'];
$cost = $_SESSION['totalPrice']; // Ensure this is the total cost in MYR (not in cents)
$bookedDate = $_SESSION['bookedDate'];
$notes = isset($_SESSION['notes']) ? $_SESSION['notes'] : null; // Optional notes
$isFinish = 0; // Default to 0 (unfinished booking)
$createdDate = date("Y-m-d H:i:s"); // Current timestamp

// Insert the booking into the database
$sql = "INSERT INTO booking (packageID, userID, pax, cost, bookedDate, createdDate) 
        VALUES ('$packageID', '$userID', '$pax', '$cost', '$bookedDate', '$createdDate')";

if (mysqli_query($conn, $sql)) {
    echo "<h1>Payment Successful</h1>";
    echo "<p>Thank you for your payment. Your booking has been successfully recorded.</p>";
} else {
    echo "<h1>Payment Successful</h1>";
    echo "<p>Payment was successful, but we encountered an issue saving your booking details. Please contact support.</p>";
    echo "Error: " . mysqli_error($conn); // For debugging
}
?>
