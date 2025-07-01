<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rating = intval($_POST['rating']);

    $insertQuery = "INSERT INTO review (title, description, rating) VALUES ('$title', '$description', $rating)";
    
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: review.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
