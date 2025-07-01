<?php
//include db config
session_start();
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>AZ Borneo Homepage</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<header>
		<!-- <h1>Home</h1> 	
		<img class="image" src="img/coffeeblog.png"> -->
	</header>
	<!-- User Nav section-->
	<!-- Main container for sticky footer -->
	<div class="container">

		<!-- Login Popup -->
		<div id="login-popup" class="login-popup">
			<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
			<h3>User Login </h3>
			<form action="userAuth/login_process.php" method="post">
				<label for="userEmail">User Email:</label><br>
				<input type="email" id="userEmail" name="email" required><br><br>
				<label for="userPwd">Password:</label><br>
				<input type="password" id="userPwd" name="password" required maxlength="8" autocomplete="off"><br><br>
				<input type="submit" value="Login">
				<input type="reset" value="Reset"></br>
			</form>
			<p><a href="javascript:void(0);" onclick="openRegPopup();">| Registration </a> | Forgot Password |</p>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
		<!-- End Login Popup -->
		<!-- Registration Popup -->
		<div id="reg-popup" class="reg-popup">
			<span class="close-btn" onclick="closeRegPopup()">&times;</span>
			<h3>User Registration </h3>
			<form action="userAuth/register_process.php" method="post">
				<label for="reguserName">Username:</label><br>
				<input type="text" id="reguserName" name="name" required><br><br>
				<label for="reguserEmail">User Email:</label><br>
				<input type="email" id="reguserEmail" name="email" required><br><br>
				<label for="reguserPwd">Password:</label><br>
				<input type="password" id="reguserPwd" name="password" required maxlength="8"><br><br>
				<label for="regconfirmPwd">Confirm Password:</label><br>
				<input type="password" id="regconfirmPwd" name="confirmpassword" required><br><br>
				<input type="submit" value="Register">
				<input type="reset" value="Reset"></br>
			</form>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
		<!-- End Registration Popup -->



		<main>
    <!-- Background Video -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
    <?php
		include("includes/userNav.php");
	?>
        <div class="container">
            <video autoplay loop muted playsinline class="background-video"> 
                <source src="img/Borneo.mp4" type="video/mp4"> 
                    Your browser does not support the video tag.
            </video>
            <div class="row" style="display: flex; align-items: center; margin: 20px; gap: 20px;">
                <!-- Left Column: Title, Caption, and Buttons -->
                <div style="flex: 1; padding: 20px;">
                    <h1 style="font-size: 5em; color: #fff; margin-bottom: 15px; margin-left: 40px">Discover Borneo with AZ Borneo Travel & Tours</h1>
                    <p style="font-size: 1.2em; color: #ccc; line-height: 1.5; margin-bottom: 20px; margin-left: 40px">
                        Embark on unforgettable journeys across the heart of Borneo. From pristine beaches to lush rainforests, 
                        let us craft your perfect adventure. Your next great escape starts here!
                    </p>

                    <!-- Buttons -->
                    <div>
                        <a href="javascript:void(0);" onclick="openRegPopup();" 
                           class="btn-primary">
                            Sign Up Now!
                        </a>
                        <a href="package.php" class="btn-secondary">
                            View Packages
                        </a>
                    </div>
                </div>

                <!-- Right Column: Image -->
                <div style="flex: 1; text-align: center;">
                    <img src="img/showcase.png" alt="Showcase Image" 
                        style="width: 100%; max-width: 550px;">
                </div>
            </div>
        </div>
		<footer class="footer">
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">AZ Borneo Travel & Tours</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">Jalan Tawau-Semporna, Pekan Semporna, 91300 Semporna, Sabah, Malaysia, Semporna, Malaysia</p>
        <p style="font-size: 1.2em; color: #ccc; line-height: 0.5; margin-left: 40px">010-669 3017   |   azborneotravel@gmail.com</p>
	    </footer>
        </div>
</main>




	</div>
	<script>
		//Login & Reg Form Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

		function openRegPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("reg-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeRegPopup() {
			document.getElementById("reg-popup").style.display = "none";
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}
	</script>
</body>

</html>