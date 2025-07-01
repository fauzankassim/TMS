<?php
session_start(); // Start the session
include("config/config.php");

// Initialize variables
$error = ''; // Initialize error variable
$success = ''; // Initialize success variable
$question = ''; // Initialize question variable

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page with an alert if not logged in
    echo '<script>alert("You need to log in to access this page."); window.location.href = "userAuth/login.php";</script>';
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $question = trim($_POST['question']);

    // Validate input
    if (empty($question)) {
        $error = 'Please enter your question.';
    } else {
        // Prepare SQL statement to prevent SQL injection
        $sql = "INSERT INTO inquiry (userID, question, answer, hasAnswer) VALUES (?, ?, '', 0)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $_SESSION['userID'], $question); // Use userID from session

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Store success message in session
            $_SESSION['success'] = 'Your inquiry has been submitted successfully!';
            // Redirect to the same page to prevent resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Ensure no further code is executed
        } else {
            $error = 'Error submitting inquiry: ' . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

// Fetch existing inquiries for the user
$userInquiries = [];
$sql = "SELECT inquiryID, question, answer, hasAnswer FROM inquiry WHERE userID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $userInquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Close the database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Inquiry </title>
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header>
        <?php include("includes/usernav.php"); ?>
    </header>

    <!-- Display success message if it exists -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="inquiry-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); // Clear the message after displaying it ?>
    <?php endif; ?>


        <!-- Login Popup -->
        <div id="login-popup" class="login-popup">
            <span class="close-btn" onclick="closeLoginPopup()">&times;</span>
            <h3>User Login</h3>
            <form action="userAuth/login_action.php" method="post">
                <label for="userEmail">User   Email:</label><br>
                <input type="email" id="userEmail" name="userEmail" required><br><br>
                <label for="userPwd">Password:</label><br>
                <input type="password" id="userPwd" name="userPwd" required maxlength="8" autocomplete="off"><br><br>
                <input type="submit" value="Login">
                <input type="reset" value="Reset"><br>
            </form>
            <p><a href="javascript:void(0);" onclick="openRegPopup();">Registration </a></p>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
        <!-- End Login Popup -->

        <!-- Registration Popup -->
        <div id="reg-popup" class="reg-popup">
            <span class="close-btn" onclick="closeRegPopup()">&times;</span>
            <h3>User Registration</h3>
            <form action="userAuth/register_action.php" method="post">
                <label for="reguserName">Username:</label><br>
                <input type="text" id="reguserName" name="userName" required><br><br>
                <label for="reguserEmail">User   Email:</label><br>
                <input type="email" id="reguserEmail" name="userEmail" required><br><br>
                <label for="reguserPwd">Password:</label><br>
                <input type="password" id="reguserPwd" name="userPwd" required maxlength="8"><br><br>
                <label for="regconfirmPwd">Confirm Password:</label><br>
                <input type="password" id="regconfirmPwd" name="confirmPwd" required><br><br>
                <input type="submit" value="Register">
                <input type="reset" value="Reset"><br>
            </form>
        </div>

<div class="contact-container">
  <div class="contact-item">
    <i class="bx bx-phone-call"></i>
    <h3>General Enquiries:</h3>
    <p>(+6) 012 841 3814</p>
    <p>Mon-Fri: 8:30 AM to 6:00 PM</p>
    <p>Sat: 9:00 AM to 1:00 PM</p>
    <p>Sun: Closed</p>
  </div>
  <div class="contact-item">
    <i class="bx bx-mobile-alt"></i>
    <h3>Sales Enquiries</h3>
    <p>Call or WhatsApp <i class="bx bx-message-square-alt"></i></p>
    <p>(+6) 017 450 2009</p>

  </div>
  <div class="contact-item">
    <i class="bx bx-support"></i>
    <h3>Support</h3>
    <p>Call or WhatsApp <i class="bx bx-message-square-alt"></i></p>
    <p>(+6) 019 860 2009</p>
  </div>
  <div class="contact-item">
    <i class="bx bx-envelope"></i>
    <h3>Email</h3>
    <p>azborneotravel@gmail.com</p>
  </div>
</div>
<div class="inquiry-container">
            <h1 class="inquiry-title">Submit Your Inquiry</h1>

            <?php if ($error): ?>
                <div class="inquiry-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="inquiry-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="inquiry-form">
                <div class="form-group">
                    <label for="question" class="form-label">Your Question:</label>
                    <textarea id="question" name="question" rows="4" class="form-textarea" required><?php echo htmlspecialchars($question); ?></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn submit-btn">Submit Inquiry</button>
                </div>
            </form>
        </div>

        <!-- User Inquiries Table -->
        <div class="user-inquiries-container">
            <h1 class="inquiry-title">Your Previous Inquiries</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>Inquiry ID</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($userInquiries)): ?>
                        <?php foreach ($userInquiries as $inquiry): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($inquiry['inquiryID']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['question']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['answer'] ?: 'Not answered yet'); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['hasAnswer'] == 0 ? 'Not answered' : 'Answered'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No inquiries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="footer">
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">AZ Borneo Travel & Tours</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">Jalan Tawau-Semporna, Pekan Semporna, 91300 Semporna, Sabah, Malaysia, Semporna, Malaysia</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">010-669 3017   |   azborneotravel@gmail.com</p>
	    </footer>
</body>
<script src="https://unpkg.com/boxicons@2.1.3/dist/boxicons.js"></script>

</html>