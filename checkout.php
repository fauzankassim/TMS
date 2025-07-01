<?php
session_start();
include("config/config.php");

// Validate and sanitize input
$packageID = isset($_POST["packageID"]) ? intval($_POST["packageID"]) : 0;
$guideID = isset($_POST["guideID"]) ? intval($_POST["guideID"]) : 0;
$transportationID = isset($_POST["transportationID"]) ? intval($_POST["transportationID"]) : 0;
$accommodationID = isset($_POST["accommodationID"]) ? intval($_POST["accommodationID"]) : 0;
$bookedDate = isset($_POST["bookedDate"]) ? $_POST["bookedDate"] : '';
$meal_list = isset($_POST["meal_list"]) ? $_POST["meal_list"] : [];
$pax = isset($_POST["pax"]) ? intval($_POST["pax"]) : 1; // Default to 1 if not set
$totalPrice = 0;

// Use prepared statements for database queries
$stmt = $conn->prepare("SELECT price FROM guide WHERE guideID = ?");
$stmt->bind_param("i", $guideID);
$stmt->execute();
$result_guide = $stmt->get_result();
$row_guide = $result_guide->fetch_assoc();
$totalPrice += $row_guide["price"];

$stmt = $conn->prepare("SELECT price FROM transportation WHERE transportationID = ?");
$stmt->bind_param("i", $transportationID);
$stmt->execute();
$result_transportation = $stmt->get_result();
$row_transportation = $result_transportation->fetch_assoc();
$totalPrice += $row_transportation["price"];

$stmt = $conn->prepare("SELECT price FROM accommodation WHERE accommodationID = ?");
$stmt->bind_param("i", $accommodationID);
$stmt->execute();
$result_accommodation = $stmt->get_result();
$row_accommodation = $result_accommodation->fetch_assoc();
$totalPrice += $row_accommodation["price"];

$stmt = $conn->prepare("SELECT a.price FROM activity_list al JOIN activity a ON al.activityID = a.activityID WHERE al.packageID = ?");
$stmt->bind_param("i", $packageID);
$stmt->execute();
$result_activities = $stmt->get_result();
while ($row_activity = $result_activities->fetch_assoc()) {
    $totalPrice += $row_activity["price"];
}

// Calculate meal prices
foreach ($meal_list as $mealID) {
    $stmt = $conn->prepare("SELECT price FROM meal WHERE mealID = ?");
    $stmt->bind_param("i", $mealID);
    $stmt->execute();
    $result_meals = $stmt->get_result();
    while ($row_meals = $result_meals->fetch_assoc()) {
        $totalPrice += $row_meals["price"];
    }
}

// Calculate total price based on number of pax
$totalPrice *= $pax;

// Store booking details in session
$_SESSION['userID'] = 1; // Get the logged-in user's ID
$_SESSION['packageID'] = $packageID;
$_SESSION['pax'] = $pax;
$_SESSION['totalPrice'] = $totalPrice; // Store total price in cents
$_SESSION['bookedDate'] = $bookedDate;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/newstyle.css"> <!-- Link to your main stylesheet -->
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 {
            color:rgb(74, 148, 80);
            margin-bottom: 15px;
            font-size: 30px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        strong {
            font-size: 24px;
            color:rgb(74, 148, 80);
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Booking Payment</h1>
        <form action="payment.php" method="POST">
            <p>Total Amount :</p>
            <p><strong>RM <?php echo number_format($totalPrice, 2); ?></strong></p> <!-- Format the total price -->
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>"> <!-- Hidden input for total price -->
            <div>
                <button type="submit" class="btn">Pay</button>
                <a href="cancel.php" class="btn" style="background-color: #28a745;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>