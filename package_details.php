<?php
// Start session and include database configuration
session_start();
include("config/config.php");

// Check if packageID is set in the URL
if (isset($_GET['packageID'])) {
    $packageID = $_GET['packageID'];

    // Prepare SQL statement to get package details and total activity prices
    $stmt = $conn->prepare("
        SELECT p.*, 
               COALESCE(SUM(a.price), 0) AS total_price 
        FROM package p
        LEFT JOIN activity_list al ON p.packageID = al.packageID
        LEFT JOIN activity a ON al.activityID = a.activityID
        WHERE p.packageID = ?
        GROUP BY p.packageID
    ");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $packageID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the package details
    if ($result->num_rows > 0) {
        $package = $result->fetch_assoc();
    } else {
        // If no package found, show an error
        echo "Package not found.";
        exit;
    }
} else {
    // If packageID is not set, show an error
    echo "Invalid package ID.";
    exit;
}

// Fetch accommodations
$accommodationStmt = $conn->prepare("SELECT * FROM accommodation");
$accommodationStmt->execute();
$accommodationResult = $accommodationStmt->get_result();

// Fetch meals
$mealStmt = $conn->prepare("SELECT * FROM meal");
$mealStmt->execute();
$mealResult = $mealStmt->get_result();

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($package['title']); ?> - Package Details</title>
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            display: inline-block;
            width: 75%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-weight: 900;
            font-size: 40px;
            text-align: center;
            color: #2B6ABC;
        }
        .package-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .package-image {
            max-width: 50%;
            height: auto;
            border-radius: 8px;
        }
        .package-info {
            margin-top: 20px;
            text-align: left;
        }
        .package-info p {
            margin: 10px 0;
        }
        .booking-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #2B6ABC;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .booking-button:hover {
            background: #1a4e8c;
        }
        /* Popup styles */
.popup {
    display: none; /* Hidden by default */
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Darker background for better contrast */
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background: #fff;
    padding: 30px; /* Increased padding for better spacing */
    border-radius: 10px; /* More rounded corners */
    width: 400px; /* Fixed width for better layout */
    text-align: left;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
}

.close-popup {
    cursor: pointer;
    color: #ff4d4d; /* Red color for close button */
    font-weight: bold;
    font-size: 20px; /* Larger font size for visibility */
    position: absolute;
    top: 10px;
    right: 15px; /* Positioning the close button */
}

.close-popup:hover {
    color: #ff1a1a; /* Darker red on hover */
}

h2 {
    margin-bottom: 20px; /* Space below the header */
    color: #2B6ABC; /* Consistent color with the main theme */
    text-align: center;
    font-weight: 1000px;
}

label {
    display: block; /* Block display for labels */
    margin: 10px 0 5px; /* Spacing around labels */
    font-weight: bold; /* Bold labels for emphasis */
    text-align: center;
}

input[type="date"],
input[type="number"],
select {
    width: 100%; /* Full width for inputs */
    padding: 10px; /* Padding for comfort */
    margin-bottom: 15px; /* Space below inputs */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
}

button[type="submit"] {
    background: #2B6ABC; /* Consistent button color */
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px; /* Larger font size for buttons */
}

button[type="submit"]:hover {
    background: #1a4e8c; /* Darker shade on hover */
}
    </style>
</head>
<body>
    <?php include("includes/userNav.php"); ?>
    <div class="container">
        <h1><?php echo htmlspecialchars($package['title']); ?></h1>
        <div class="package-details">
            <img src ="<?php echo htmlspecialchars($package['image']); ?>" alt="<?php echo htmlspecialchars($package['title']); ?>" class="package-image">
            <div class="package-info">
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($package['description'])); ?></p>
                <p><strong>Price:</strong> RM <span id="basePrice"><?php echo number_format($package['total_price'], 2); ?></span></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($package['duration']); ?></p>
            </div>
            <button class="booking-button" onclick="openBookingPopup()">Book Now</button>
        </div>
    </div>

<!-- Booking Popup -->
<div class="popup" id="bookingPopup">
    <div class="popup-content">
        <span class="close-popup" onclick="closeBookingPopup()">&times;</span>
        <h2><?php echo htmlspecialchars($package['title']); ?></h2> 
        
        <form method="post" action="checkout.php">
            <input type="hidden" name="packageID" value="<?php echo $package['packageID']; ?>">
            <input type="hidden" name="guideID" value="<?php echo $package['guideID']; ?>">
            <input type="hidden" name="transportationID" value="<?php echo $package['transportationID']; ?>">
            
            <label for="bookedDate">Please Select A Date</label>
            <input type="date" name="bookedDate" required>
            <br><br>
            
            <label for="accommodation">Your Choice of Accommodation</label>
            <select name="accommodationID" id="accommodation">
                <option value="none" data-price="0">No Accommodation</option>
                <?php while ($accommodation = $accommodationResult->fetch_assoc()): ?>
                    <option value="<?php echo $accommodation['accommodationID']; ?>" data-price="<?php echo $accommodation['price']; ?>">
                        <?php echo htmlspecialchars($accommodation['name']); ?> (RM <?php echo number_format($accommodation['price'], 2); ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            
            <label>Meal Package</label>
            <div id="mealAddons">
                <?php while ($meal = $mealResult->fetch_assoc()): ?>
                    <div>
                        <?php echo "<input type='checkbox' name='meal_list[]' value='".$meal['mealID']."'>".$meal['name']."</input>"; ?>
                        <?php echo htmlspecialchars($meal['name']); ?> (RM <?php echo number_format($meal['price'], 2); ?>)
                    </div>
                <?php endwhile; ?>
            </div>
            <br>
            
            <label for="pax">Please Enter Number of Pax</label>
            <input type="number" name="pax" id="pax" required min="<?php echo $package['minPax']; ?>" placeholder="Enter number of pax">
            <small>Minimum required: <?php echo $package['minPax']; ?></small>
            <br><br>
            
            <button type="submit">Submit Booking</button>
        </form>
    </div>
</div>

<script>
function openBookingPopup() {
    document.getElementById("bookingPopup").style.display = "flex";
}

function closeBookingPopup() {
    document.getElementById("bookingPopup").style.display = "none";
}
</script>
</body>
</html>