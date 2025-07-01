<?php
include("config/config.php");

// Hardcoded userID for testing purposes
$userID = 1; // Change this to the user ID you want to test

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Bookings</title>
    <style>

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color:rgb(69, 110, 130);
            color: white;
            font-size: 18px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 16px;
            color: #555;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include("includes/usernav.php");?>
    <h1>My Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Tour Package</th>
                <th>Booking Date</th>
                <th>Amount</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Prepare the SQL query to fetch bookings for the specified user
            $joinsql = "SELECT booking.bookingID, 
                        package.title AS packageTitle, 
                        booking.bookedDate AS BookingDate, 
                        booking.cost AS amount
                        FROM booking 
                        JOIN package ON booking.packageID = package.packageID 
                        WHERE booking.userID = ?";


            $stmt = mysqli_prepare($conn, $joinsql);
            if ($stmt === false) {
                echo "Error preparing statement: " . mysqli_error($conn);
                exit;
            }

            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result === false) {
                echo "Error executing query: " . mysqli_error($conn);
                exit;
            }

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    echo "<tr>
                            <td>{$row['bookingID']}</td>
                            <td>{$row['packageTitle']}</td>
                            <td>" . date("d/m/Y", strtotime($row['BookingDate'])) . "</td>
                            <td>". number_format($row['amount'], 2) . "</td>
                            <td><a href='review.php?id=" . urlencode($row["bookingID"]). "'>Go</a></td>
                            
                          </tr>";
                }
            } else {
                
                echo "<tr><td colspan='6' style='text-align: center;'>No bookings found.</td></tr>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
            ?>
        </tbody>
    </table>
</body>
</html>