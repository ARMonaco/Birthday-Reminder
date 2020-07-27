<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php session_start(); // make sessions available ?>
<?php

if (!isset($_SESSION['user']))
{
	header('Location: signin.php?error=notloggedin');
}

?>

<html lang="en">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Birthday Reminder Logout</title>    
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" /> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<style>
		.error{color: red; font-style: italic; padding: 10px;}
		.nav-link {
			color: white;
		}
	</style>
	
	<script> 
	<!-- Imports the navbar header used on every signed-in page. -->
	$(function(){
		$("#header").load("navbar_header.html"); 
		});
	</script>
	
</head>
<body>
	<div id="header"></div>
	<div class = "container">
		<div class = "pt-5"><div class="pb-3">
			<h2 class = "text-center">Are you sure you want to log out?<h2>
		</div></div>
		
		<div class="text-center">
		<!-- Buttons for log-out and return -->
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="submit" class="btn btn-danger btn-lg" name="logout" id="logout" value="LOG OUT">
			<!--<button type="button" id="logout" class="btn btn-danger btn-lg">LOG OUT</button>-->
			<button type="button" id= "return" class="btn btn-secondary btn-lg">RETURN TO PROFILE</button>
			<br>
			<p hidden id="logout_msg">Logging you out in 5 seconds...</p>
		</form>
		</div>
		
	
		<script>
			<!-- fetches button information from document.  -->
			var logout_btn = document.getElementById("logout");
			var return_btn = document.getElementById("return");
			
			var logout_time = 5000;
			
			
			<!-- returns user to profile page -->
			return_btn.onclick = function(){
				window.location = "profile.html";
			}
			
			<!-- logs the user out after five seconds. -->
			<!-- disables buttons so the useer cannot cause a loop. -->
			logout_btn.onclick = function(){
				document.getElementById("logout_msg").removeAttribute("hidden");
				$(logout_btn).prop('disabled', true);
				$(return_btn).prop('disabled', true);

				setTimeout(function(){
					window.location = "logouthandler.php";
				},logout_time);
			}
		</script>
			
	</div>
</body>
</html>