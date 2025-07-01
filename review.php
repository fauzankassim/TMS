<?php
// Start session and include database configuration
session_start();
include("config/config.php");

if (isset($_GET['id'])) {
    $bookingID = intval($_GET['id']);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Product Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST["bookingID"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];

    $sql_rating = "INSERT INTO review(`title`, `description`, `rating`, `bookingID`) VALUES ('$title', '$description', '$rating', '$bookingID')";

        // Execute query
    if (mysqli_query($conn, $sql_rating)) {
        echo "Activity updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }


    // Redirect or display a success message
} 

// Execute the query to get all packages
$reviewsQuery = "SELECT * FROM review ORDER BY reviewID DESC";
$result = mysqli_query($conn, $reviewsQuery);

// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . mysqli_error($conn));
}

$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews</title>
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Raleway', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            align-items: center;
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 20px;
        }

        .review-form {
            width: 45%;
            padding: 20px;
            background: #eef2f3;
            border-radius: 8px;
        }

        .review-form h2 {
            margin-bottom: 10px;
        }

        .review-form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .review-form input, .review-form textarea, .review-form input[type="range"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .review-form button {
            background: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
        }

        .review-form button:hover {
            background: #0056b3;
        }

        .review-list {
            width: 55%;
            padding: 20px;
            border-left: 2px solid #ddd;
        }

        .review-list h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007BFF;
            color: white;
        }
    </style>

</head>
<body>
<?php
		include("includes/usernav.php");
	?>
    <div class="container">
    <!-- Review Submission Form -->
    <div class="review-form">
        <h2>Submit Your Review</h2>
        <form action="" method="POST">
            <input type="hidden" name="bookingID" value="<?= htmlspecialchars($bookingID) ?>" required>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5" required></textarea>

            <label for="rating">Rating (1-5):</label>
            <input type="range" name="rating" id="rating" min="1" max="5" required>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>

    <!-- Display Existing Reviews -->
    <div class="review-list">
        <h2>All Feedback</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Rating</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
    <footer class="footer">
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">AZ Borneo Travel & Tours</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">Jalan Tawau-Semporna, Pekan Semporna, 91300 Semporna, Sabah, Malaysia, Semporna, Malaysia</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">010-669 3017   |   azborneotravel@gmail.com</p>
	    </footer>
</body>
</html>
