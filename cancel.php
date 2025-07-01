<?php
// Start session if needed
session_start();
include ("config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Canceled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
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
    <div class="container">
        <h1>Payment Canceled</h1>
        <p>Your payment process has been canceled. If this was a mistake, you can try again by clicking the button below.</p>
        
        <!-- Button to retry payment -->
        <a href="package.php" class="btn">Rebook</a>
        
        <!-- Button to go back to main page -->
        <a href="index.php" class="btn" style="background-color: #28a745;">Go Back to Home</a>
    </div>
</body>
</html>