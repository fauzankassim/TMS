<?php
// Start session and include database configuration
session_start();
include("config/config.php");

// Execute the query to get all packages with total activity prices
$sql_package = "
    SELECT p.*, 
           COALESCE(SUM(a.price), 0) AS total_price 
    FROM package p
    LEFT JOIN activity_list al ON p.packageID = al.packageID
    LEFT JOIN activity a ON al.activityID = a.activityID
    GROUP BY p.packageID
";
$result = mysqli_query($conn, $sql_package);

// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . mysqli_error($conn));
}

$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Travel Packages</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .package-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 70%;
            margin: 0 auto;
        }

        .package-card {
            width: 45%; /* Adjust width for better alignment */
            margin-top: 30px;
            height: 400px;
            padding: 0;
            background: #fff;
            position: relative;
            display: flex;
            align-items: flex-end;
            box-shadow: 0px 7px 1px rgba(0,0,0,0.5);
            transition: 0.5s ease-in-out;
            border-radius: 15px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .package-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .package-info {
            position: absolute;
            bottom: 20px; /* Slight padding from the bottom */
            left: 20px; /* Slight padding from the left */
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            text-align: left;
        }

        .package-info h3 {
            font-size: 1.5rem;
            margin: 0;
        }

        .package-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <?php include("includes/userNav.php"); ?>
    <div class="container">
        <div class="content" style="background-image: url('img/background.png'); background-size: auto; background-position: center; background-repeat: repeat; min-height: 100vh;">
            <main>
                <h2 style="color:rgb(43, 106, 188);text-align: center; font-size: 3rem; font-weight: 1000; padding-top: 5px;">
                    Travel Packages
                </h2>
                <div style="text-align: center; border-bottom: 3px solid #2B6ABC; width: 100%;"></div>
                <div class="package-container">
                    <?php
                    if ($rowcount > 0) { 
                        // Output each tour package
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="package_details.php?packageID=' . $row['packageID'] . '" class="package-card">';
                            echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">'; // Display package image
                            echo '<div class="package-info">';
                            echo '<h3>' . $row["title"] . '</h3>'; // Display package title
                            echo '<p>Price starting from: RM ' . number_format($row["total_price"], 2) . '</p>'; // Display total price
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "No tour packages found.";
                    }
                    // Free result set
                    mysqli_free_result($result);
                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </main>  
        </div>
    </div>
</body>
</html>